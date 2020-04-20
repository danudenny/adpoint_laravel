<?php

namespace App\Http\Controllers;
use App\Category;
use Illuminate\Http\Request;
use App\Order;
use App\User;
use App\Product;
use App\Color;
use App\OrderDetail;
use App\CouponUsage;
use App\ConfirmPayment;
use App\Evidence;
use App\Transaction;
use App\Invoice;
use App\Seller;
use Auth;
use Calendar;
use Session;
use DB;
use PDF;
use Mail;
use File;
use Carbon\Carbon;

use App\ActivatedProces;

use App\Mail\Order\OrderStart;
use App\Mail\Admin\AdminOrderStart;
use App\Mail\Order\OrderApprovedAdmin;
use App\Mail\Order\OrderSold;
use App\Mail\Admin\AdminOrderApproveBySeller;
use App\Mail\Admin\AdminRejectedBySeller;
use App\Mail\Order\OrderDisapprovedAdmin;
use App\Mail\Order\OrderApprovedSeller;
use App\Mail\Order\OrderConfirmation;
use App\Mail\Order\OrderInvoice;
use App\Mail\Admin\AdminOrderPay;
use App\Mail\Order\OrderDisapprovedSeller;
use App\Mail\Order\OrderActive;
use App\Mail\Order\OrderComplete;

use App\Pushy;

use Notification;
use App\Notifications\OrderProses;
use App\Events\OrderProsesEvent;
use App\Notifications\OrderApproveAdminBuyer;
use App\Events\OrderApproveAdminBuyerEvent;
use App\Notifications\OrderApproveAdminSeller;
use App\Events\OrderApproveAdminSellerEvent;
use App\Notifications\OrderApproveSellerAdmin;
use App\Events\OrderApproveSellerAdminEvent;
use App\Notifications\OrderConfirmByAdmin;
use App\Events\OrderConfirmByAdminEvent;
use App\Notifications\OrderPay;
use App\Events\OrderPayEvent;
use App\Notifications\OrderContinueBuyer;
use App\Events\OrderContinueBuyerEvent;

use App\Notifications\ItemProsesEdit;
use App\Events\ItemProsesEditEvent;
use App\Notifications\ItemProsesInstall;
use App\Events\ItemProsesInstallEvent;
use App\Notifications\ItemReadyActive;
use App\Events\ItemReadyActiveEvent;
use App\Notifications\OrderActiveSellerBuyer;
use App\Events\OrderActiveSellerBuyerEvent;
use App\Notifications\OrderCompleted;
use App\Events\OrderCompletedEvent;
use App\Notifications\DisapproveSellerToAdmin;
use App\Events\DisapproveSellerToAdminEvent;


class OrderController extends Controller
{
    // page seller

    public function get_items($status = null)
    {
        $order_details = DB::table('order_details as od')
                            ->orderBy('od.id', 'desc')
                            ->join('orders as o', 'o.id', '=', 'od.order_id')
                            ->where([
                                'o.seller_id' => Auth::user()->id,
                                'o.approved'  => 1,
                                'od.status' => $status
                            ])
                            ->select([
                                'od.*',
                                'o.id as o_id',
                                'o.user_id as o_user_id',
                                'o.transaction_id as o_trx_id',
                                'o.seller_id as o_seller_id',
                                'o.code as o_code',
                                'o.approved as o_approved',
                                'o.grand_total as o_grandtotal',
                                'o.tax as o_tax',
                                'o.adpoint_earning as o_adpoint_earning',
                                'o.address as o_addres'
                            ])
                            ->get();
        return $order_details;
    }

    public function index()
    {
        $order_details = $this->get_items();
        return view('frontend.seller.orders', compact('order_details'));
    }

    public function item_details_seller(Request $request)
    {
        $query = DB::table('transactions as t')
                    ->join('orders as o', 'o.transaction_id', '=', 't.id')
                    ->join('order_details as od', 'od.order_id', '=', 'o.id')
                    ->where([
                        'od.id' => $request->order_detail_id
                    ])
                    ->select([
                        't.code as code_trx',
                        't.payment_status',
                        't.file_advertising',
                        'o.code as code_order',
                        'o.created_at as order_date',
                        'o.address',
                        'o.user_id as buyer_name',
                        'od.product_id as item_name',
                        'od.seller_id',
                        'od.status as od_status',
                        'od.rejected as od_rejected',
                        'od.file_advertising as od_file_advertising'
                    ])
                    ->first();
        return view('frontend.partials.item_details_seller', compact('query'));
    }

    // page admin
    public function list_orders(Request $request)
    {
        $orders = Order::orderBy('id', 'desc')->get();
        return view('orders.list_orders', compact('orders'));
    }

    private function _cek_default_status_orders($trx_id) {
        $query = DB::table('orders as o')
                            ->join('transactions as t', 't.id', '=', 'o.transaction_id')
                            ->where([
                                't.id' => $trx_id,
                                'o.approved' => 0,
                            ])
                            ->get();
        return $query;
    }

    public function approve_by_admin(Request $request, $id)
    {
        $trx = Transaction::where('id', decrypt($id))->first();
        $buyer = User::where('id', $trx->user_id)->first();

        $data['code_trx']       = $trx->code;
        $data['buyer_name']     = $buyer->name;
        $data['buyer_email']    = $buyer->email;

        if ($trx != null) {
            $trx->status = "approved"; // approve admin
            if($trx->save()) {
                Mail::to($buyer->email)->send(new OrderApprovedAdmin($data));
                Notification::send($buyer, new OrderApproveAdminBuyer($trx->code));
                event(new OrderApproveAdminBuyerEvent('Transaction '.$trx->code.' has been reviewed by the admin'));

                foreach ($trx->orders as $key => $o) {
                    $order = Order::where('id', $o->id)->first();
                    $order->approved = 1;
                    $order->save();
                    $user = User::where('id', $o->seller_id)->first();
                    $seller['code'] = $o->code;
                    $seller['seller_name'] = $user->name;
                    // email
                    Mail::to($user->email)->send(new OrderSold($seller));
                    Notification::send($user, new OrderApproveAdminSeller($o->code));
                    event(new OrderApproveAdminSellerEvent('Order '.$o->code.' has been placed, please continue!'));

                    // pushy notif
                    $push = DB::table('pushy_tokens as pt')
                            ->join('users as u', 'u.id', '=', 'pt.user_id')
                            ->where(['u.id' => $user->id])
                            ->select(['pt.*'])
                            ->first();
                    if ($push !== null) {
                        $tokenPushy = $push->device_token;
                        $data = array('message' => 'Order '.$o->code.' has been placed, please continue!');
                        $to = array($tokenPushy);
                        $options = array(
                            'notification' => array(
                                'badge' => 1,
                                'sound' => 'ping.aiff',
                                'body'  => "Order '.$o->code.' has been placed, please continue!"
                            )
                        );
                        Pushy::sendPushNotification($data, $to, $options);
                    }
                }
            }
            $request->session()->flash('message', 'TRX'.' '.$trx->code.' '.'Approved');
            flash('Trx approved')->success();
            return back();
        } else {
            flash('Something went wrong')->error();
            return back();
        }
    }

    public function disapprove_by_admin(Request $request)
    {
        $trx = Transaction::where('id', $request->trx_id)->first();
        $buyer = User::where('id', $trx->user_id)->first();
        $data['code']           = $trx->code;
        $data['alasan']         = $request->alasan;
        $data['buyer_name']     = $buyer->name;
        $data['buyer_email']    = $buyer->email;
        if ($trx != null) {
            $trx->status = "rejected"; // reject by admin
            $trx->is_rejected = $request->alasan;
            $trx->updated_at = time();
            $trx->save();
            Mail::to($buyer->email)->send(new OrderDisapprovedAdmin($data));
            foreach ($trx->orders as $key => $o) {
                $order = Order::where('id', $o->id)->first();
                $order->approved = 2;
                $order->save();
                $user = User::where('id', $o->seller_id)->first();
                $seller['code'] = $o->code;
                $seller['seller_name'] = $user->name;
                Mail::to($user->email)->send(new OrderSold($seller));
                foreach ($o->orderDetails as $key => $od) {
                    $order_detail = OrderDetail::where('id', $od->id)->first();
                    $order_detail->status = 2;
                    $order_detail->save();
                }
            }
            flash('Trx rejected')->success();
            $request->session()->flash('message', 'TRX'.' '.$trx->code.' '.'Rejected');
            return back();
        } else {
            flash('Something went wrong')->error();
            return back();
        }
    }

    private function _cek_default_status_order_details($trx_id) {
        $query = DB::table('order_details as od')
                            ->join('orders as o', 'o.id', '=', 'od.order_id')
                            ->join('transactions as t', 't.id', '=', 'o.transaction_id')
                            ->where([
                                't.id' => $trx_id,
                                'o.approved' => 1,
                                'od.status' => 0
                            ])
                            ->get();
        return $query;
    }

    private function _generate_invoice($trx_id) {
        $data = array();
        $trx = Transaction::where('id', $trx_id)->first();
        $expire_date = Carbon::createFromTimestamp(strtotime($trx->created_at))->addHour(24);
        $buyer = User::where('id', $trx->user_id)->first();
        $data['trx_id'] = $trx->id;
        $data['expire_date'] = date('d M Y H:i:s', strtotime($expire_date));
        $data['code_trx']   = $trx->code;
        $data['created_at'] = date('d M Y H:i:s', strtotime($trx->created_at));
        $data['buyer_name'] = $buyer->name;
        $data['buyer_email'] = $buyer->email;
        $code_order = array();
        foreach ($trx->orders as $key => $order) {
            if ($order->approved == 1) {
                $order_details = OrderDetail::where('order_id', $order->id)->get();
                $items = array();
                $item = array();
                foreach ($order_details as $key => $od) {
                    $items['seller_id'] = $od->seller_id;
                    $items['product_id'] = $od->product_id;
                    $items['variation'] = $od->variation;
                    $items['price'] = $od->price;
                    $items['quantity'] = $od->quantity;
                    $items['start_date'] = $od->start_date;
                    $items['end_date'] = $od->end_date;
                    $items['status'] = $od->status;
                    array_push($item, $items);
                }
                $code_order[$order->code] = $item;
                array_push($code_order);
            }

        }
        $data['code_order'] = $code_order;
        return $data;
    }

    public function approve_by_seller(Request $request, $id)
    {
        $order_detail = OrderDetail::where('id', decrypt($id))->first();
        if ($order_detail != null) {
            $order_detail->status = 1; // approve item by seller
            $order_detail->updated_at = time();
            $product = Product::where('id', $order_detail->product_id)->first();
            if ($order_detail->save()) {
                $order = Order::where('id', $order_detail->order_id)->first();
                $default_status_od = $this->_cek_default_status_order_details($order->transaction_id);
                if (count($default_status_od) === 0) {
                    $trx = Transaction::where('id', $order->transaction_id)->first();
                    $trx->status = "ready";
                    $trx->save();
                    // pushy notif
                    $admin = User::where('user_type', 'admin')->first();
                    Notification::send($admin, new OrderApproveSellerAdmin($trx->id, $order->code));
                    event(new OrderApproveSellerAdminEvent('Order '.$order->code.' has been approved by the seller, please continue!'));
                    Mail::to($admin->email)->send(new AdminOrderApproveBySeller($admin, $order->code));
                    $push = DB::table('pushy_tokens as pt')
                            ->join('users as u', 'u.id', '=', 'pt.user_id')
                            ->where(['u.user_type' => 'admin'])
                            ->select(['pt.*'])
                            ->first();
                    if ($push !== null) {
                        $tokenPushy = $push->device_token;
                        $data = array('message' => 'Order '.$trx->code.' has been approved by the seller, please continue!');
                        $to = array($tokenPushy);
                        $options = array(
                            'notification' => array(
                                'badge' => 1,
                                'sound' => 'ping.aiff',
                                'body'  => "Order '.$trx->code.' has been approved by the seller, please continue!"
                            )
                        );
                        Pushy::sendPushNotification($data, $to, $options);
                    }

                }
                flash('Item '.$product->name.' Approved')->success();
                return back();
            }
        }else {
            flash('Something went wrong')->error();
            return back();
        }
    }

    public function disapprove_by_seller(Request $request)
    {
        $order_detail = OrderDetail::where('id', $request->od_id)->first();
        if ($order_detail != null) {
            $order_detail->status = 2;
            $order_detail->is_confirm = 0;
            $order_detail->rejected = $request->alasan;
            $order_detail->updated_at = time();
            $product = Product::where('id', $order_detail->product_id)->first();

            if ($order_detail->save()) {
                // push ke admin info bila di reject untuk kalkulasi
                $order = Order::where('id', $order_detail->order_id)->first();
                $default_status_od = $this->_cek_default_status_order_details($order->transaction_id);
                if (count($default_status_od) === 0) {
                    
                    $trx = Transaction::where('id', $order->transaction_id)->first();
                    $trx->status = "ready";
                    $trx->save();

                    $admin = User::where('user_type', 'admin')->first();
                    Notification::send($admin, new DisapproveSellerToAdmin($product->name,$trx->id));
                    event(new DisapproveSellerToAdminEvent('Media telah di batalkan oleh seller '.$product->name));
                    Mail::to($admin->email)->send(new AdminRejectedBySeller($admin, $product->name));
                }
                flash('Item '.$product->name.' Rejected')->success();
                return back();
            }
        }else {
            flash('Something went wrong')->error();
            return back();
        }
    }

    public function confirm_to_buyer(Request $request)
    {
        $trx = Transaction::where('id', $request->trx_id)->first();
        return view('frontend.partials.confirm_to_buyer', compact('trx'));
    }

    public function proses_confirm_to_buyer(Request $request)
    {
        $trx = Transaction::where('id', $request->trx_id)->first();
        $order_date = Carbon::createFromTimestamp(strtotime($trx->created_at))->addHour(24);
        if ($trx != null && $trx->status == "ready") {
            $cekinv = Invoice::where('transaction_id', $trx->id)->first();
            if ($cekinv === null) {
                $inv = new Invoice;
                $inv->code = 'INV-'.time();
                $inv->transaction_id = $trx->id;
                $inv->save();
            }
            $trx->status = "confirmed";
            $trx->save();
        }
        if ($trx != null) {
            $buyer = User::where('id', $trx->user_id)->first();
            Mail::to($buyer->email)->send(new OrderConfirmation($trx));
            Notification::send($buyer, new OrderConfirmByAdmin($trx->code));
            event(new OrderConfirmByAdminEvent('Transaction '.$trx->code.' has been confirmed. please continue to make payment!'));

            // pushy notif
            $push = DB::table('pushy_tokens as pt')
                    ->join('users as u', 'u.id', '=', 'pt.user_id')
                    ->where(['u.id' => $buyer->id])
                    ->select(['pt.*'])
                    ->first();
            if ($push !== null) {
                $tokenPushy = $push->device_token;
                $data = array('message' => 'Transaction '.$trx->code.' has been confirmed. please continue to make payment!');
                $to = array($tokenPushy);
                $options = array(
                    'notification' => array(
                        'badge' => 1,
                        'sound' => 'ping.aiff',
                        'body'  => "Transaction ".$trx->code." has been confirmed. please continue to make payment!"
                    )
                );
                Pushy::sendPushNotification($data, $to, $options);
            }
            flash('Trx confirmed')->success();
            $request->session()->flash('message', 'CODE: '.' '.$trx->code.' '.'Confirmed');
            return back();
        }else {
            flash('Something went wrong')->error();
            return back();
        }
    }

    public function admin_orders(Request $request)
    {
        $orders = DB::table('orders')
            ->orderBy('code', 'desc')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->where('order_details.seller_id', Auth::user()->id)
            ->select('orders.id')
            ->distinct()
            ->paginate(9);

        return view('orders.index', compact('orders'));
    }


    public function continue_payment(Request $request, $trx_id)
    {
        $trx = Transaction::where('id', decrypt($trx_id))->first();
        $trx->status = "continue";
        $trx->save();
        $buyer = User::where('id', $trx->user_id)->first();
        Mail::to($buyer->email)->send(new OrderInvoice($trx));
        Notification::send(User::where('user_type','admin')->first(), new OrderContinueBuyer($trx->id, $trx->code));
        event(new OrderContinueBuyerEvent('Buyer has confirmed the transaction '.$trx->code));
        $push = DB::table('pushy_tokens as pt')
                        ->join('users as u', 'u.id', '=', 'pt.user_id')
                        ->where(['u.user_type' => 'admin'])
                        ->select(['pt.*'])
                        ->first();
        if ($push !== null) {
            $tokenPushy = $push->device_token;
            $data = array('message' => 'Buyer has confirmed the transaction '.$trx->code);
            $to = array($tokenPushy);
            $options = array(
                'notification' => array(
                    'badge' => 1,
                    'sound' => 'ping.aiff',
                    'body'  => 'Buyer has confirmed the transaction '.$trx->code
                )
            );
            Pushy::sendPushNotification($data, $to, $options);
        }

        flash('Order confirmed')->success();
        $request->session()->flash('message', 'CODE: '.' '.$trx->code.' '.'Confirmed');

        return redirect('transaction');
    }

    public function confirm_payment_id(Request $request, $trx_id)
    {
        $trx_id = decrypt($trx_id);
        $trx = Transaction::where('id', $trx_id)->first();
        return view('frontend.confirm_payment', compact('trx'));
    }

    public function insert_confirm_payment(Request $request)
    {
        $request->validate([
            'trx_code' => 'required',
            'no_rek' => 'required',
            'bukti' => 'required'
        ]);
        $confirm_payment = new ConfirmPayment;
        if ($request->all() != null) {
            $confirm_payment->code_trx = $request->trx_code;
            $trx = Transaction::where('code',  $request->trx_code)->first();
            if ($trx != null) {
                $trx->status = "paid";
                if ($trx->save()) {
                    foreach ($trx->orders as $key => $o) {
                        foreach ($o->orderDetails as $key => $od) {
                            $product = Product::where('id', $od->product_id)->first();
                            $product->available = 0;
                            $product->save();
                        }
                    }
                }
            }
            $confirm_payment->user_id = $request->user_id;
            $confirm_payment->nama = $request->nama;
            $confirm_payment->nama_bank = $request->nama_bank;
            $confirm_payment->no_rek = $request->no_rek;
            $confirm_payment->bukti = $request->bukti->store('uploads/bukti_transfer');
            $confirm_payment->approved = 0;
            $confirm_payment->save();
            
            $user_id = $trx->user_id;
            $buyer_name = User::where('id', $user_id)->first()->name;
            $admin = User::where('user_type','admin')->first();
            Notification::send($admin, new OrderPay($buyer_name, $trx->id));
            event(new OrderPayEvent('New payment entered from '.$buyer_name));
            Mail::to($admin->email)->send(new AdminOrderPay($admin,$buyer_name));
            $push = DB::table('pushy_tokens as pt')
                        ->join('users as u', 'u.id', '=', 'pt.user_id')
                        ->where(['u.user_type' => 'admin'])
                        ->select(['pt.*'])
                        ->first();
            if ($push !== null) {
                $tokenPushy = $push->device_token;
                $data = array('message' => 'New payment entered from '.$buyer_name);
                $to = array($tokenPushy);
                $options = array(
                    'notification' => array(
                        'badge' => 1,
                        'sound' => 'ping.aiff',
                        'body'  => "New payment entered from ".$buyer_name
                    )
                );
                Pushy::sendPushNotification($data, $to, $options);
            }
            flash('Order confirmed')->success();
            $request->session()->flash('message', 'Transaction paid!');
            return redirect('transaction');
        } else {
            flash('Something went wrong')->error();
            return back();
        }

    }

    public function activate(Request $request)
    {
        $item = OrderDetail::where('id', $request->id)->first();
        $product = Product::where('id', $item->product_id)->first();
        $query = DB::table('orders as o')
                        ->join('order_details as od', 'od.order_id', '=', 'o.id')
                        ->join('users as b', 'b.id', '=', 'o.user_id')
                        ->join('products as p', 'p.id', '=', 'od.product_id')
                        ->where('od.id', $request->id)
                        ->select([
                            'od.*',
                            'od.id as order_id',
                            'b.id as buyer_id',
                            'b.name as buyer_name',
                            'b.email as buyer_email',
                            'p.name as product_name',
                        ])
                        ->first();
        $order = OrderDetail::where('id', $query->order_id)->first();
        $buyer = User::where('id', $order->buyer_id)->first();
        if ($item !== null) {
            $item->status = 3; // activated
            $item->save();
            Mail::to($query->buyer_email)->send(new OrderActive($query));
            Notification::send($buyer, new OrderActiveSellerBuyer($product->name));
            event(new OrderActiveSellerBuyerEvent('Media '.$product->name.' has been activated'));
            $push = DB::table('pushy_tokens as pt')
                        ->join('users as u', 'u.id', '=', 'pt.user_id')
                        ->where(['u.id' => $query->buyer_id])
                        ->select(['pt.*'])
                        ->first();
            if ($push !== null) {
                $tokenPushy = $push->device_token;
                $data = array('message' => 'Media '.$product->name.' has been activated');
                $to = array($tokenPushy);
                $options = array(
                    'notification' => array(
                        'badge' => 1,
                        'sound' => 'ping.aiff',
                        'body'  => 'Media '.$product->name.' has been activated'
                    )
                );
                Pushy::sendPushNotification($data, $to, $options);
            }
            flash('Item '.$query->product_name.' Activated!')->success();
            return back()->with('popup', 'open');
        }else {
            flash('Item '.$query->product_name.' Invalid!')->error();
            return back();
        }
    }


    public function complete(Request $request, $id)
    {
        $order_detail = OrderDetail::where('id', decrypt($id))->first();
        $query = DB::table('orders as o')
                        ->join('order_details as od', 'od.order_id', '=', 'o.id')
                        ->join('users as b', 'b.id', '=', 'o.user_id')
                        ->join('products as p', 'p.id', '=', 'od.product_id')
                        ->where('od.id', decrypt($id))
                        ->select([
                            'od.*',
                            'b.id as buyer_id',
                            'b.name as buyer_name',
                            'b.email as buyer_email',
                            'p.name as product_name',
                        ])
                        ->first();
        if ($order_detail !== null) {
            $order_detail->status = 4;
            $product = Product::where('id', $order_detail->product_id)->first();
            $product->available = 1;
            $product->save();
            $order_detail->save();
            $buyer = User::where('id', $query->buyer_id)->first();
            Mail::to($query->buyer_email)->send(new OrderComplete($query));
            Notification::send($buyer, new OrderCompleted($product->name));
            event(new OrderCompletedEvent('Media '.$product->name.' has been completed'));
            $push = DB::table('pushy_tokens as pt')
                        ->join('users as u', 'u.id', '=', 'pt.user_id')
                        ->where(['u.id' => $query->buyer_id])
                        ->select(['pt.*'])
                        ->first();
            if ($push !== null) {
                $tokenPushy = $push->device_token;
                $data = array('message' => 'Media '.$product->name.' has been completed');
                $to = array($tokenPushy);
                $options = array(
                    'notification' => array(
                        'badge' => 1,
                        'sound' => 'ping.aiff',
                        'body'  => 'Media '.$product->name.' has been completed'
                    )
                );
                Pushy::sendPushNotification($data, $to, $options);
            }
            flash('Item '.$query->product_name.' Completed!')->success();
            return back();
        }else {
            flash('Item '.$query->product_name.' Invalid!')->error();
            return back();
        }
    }

    public function store(Request $request)
    {
        $cart = Session::get('cart');

        $trx = new Transaction;
        $trx->code = 'TRX-'.time();
        $trx->payment_status = 0;
        $trx->payment_type = $request->payment_option;
        $trx->user_id = Auth::user()->id;
        $trx->status = "on proses";
        $trx->file_advertising = null;
        $trx->description = null;

        if ($trx->save()) {
            foreach ($cart as $seller_id => $c) {
                $order = new Order;
                if (Auth::check()) {
                    $order->user_id = Auth::user()->id;
                }

                $order->address = json_encode($request->session()->get('shipping_info'));
                $order->code = 'ODR-'.time().''.$seller_id;
                $order->transaction_id = $trx->id;
                $order->seller_id = $seller_id;
                $order->approved = 0;
                if ($order->save()) {
                    $subtotal = 0;
                    foreach ($c as $key => $cartItem) {
                        $product = Product::find($cartItem['id']);
                        $subtotal += $cartItem['price'] * $cartItem['quantity'];
                        $product_variation = null;

                        foreach (json_decode($product->choice_options) as $choice) {
                            $str = $choice->title;
                            if ($product_variation != null) {
                                $product_variation .= $cartItem[$str];
                            } else {
                                $product_variation .= $cartItem[$str];
                            }
                        }

                        if ($product_variation != null) {
                            $variations = json_decode($product->variations);
                            $variations->$product_variation->qty -= $cartItem['quantity'];
                            $product->variations = json_encode($variations);
                            $product->save();
                        }

                        $order_detail = new OrderDetail;

                        $order_detail->order_id  = $order->id;
                        $order_detail->seller_id = $cartItem['user_id'];
                        $order_detail->product_id = $cartItem['id'];
                        $order_detail->variation = $product_variation;
                        $order_detail->total = $cartItem['price'] * $cartItem['quantity'];
                        $order_detail->price = $cartItem['price'];
                        $order_detail->quantity = $cartItem['quantity'];
                        $order_detail->file_advertising = $cartItem['advertising'];
                        $order_detail->status = 0;

                        if ($product_variation == 'Harian') {
                            $order_detail->start_date = date('Y-m-d', strtotime($cartItem['start_date']));
                            $order_detail->end_date = date('Y-m-d', strtotime($cartItem['end_date']));
                        }
                        if ($product_variation == 'Mingguan') {
                            $order_detail->start_date = date('Y-m-d', strtotime($cartItem['start_date']));
                            $order_detail->end_date = date('Y-m-d', strtotime($cartItem['end_date']));
                        }
                        if ($product_variation == 'Bulanan') {
                            $order_detail->start_date = date('Y-m-d', strtotime($cartItem['start_date']));
                            $order_detail->end_date = date('Y-m-d', strtotime($cartItem['end_date']));
                        }
                        if ($product_variation == 'TigaBulan') {
                            $order_detail->start_date = date('Y-m-d', strtotime($cartItem['start_date']));
                            $order_detail->end_date = date('Y-m-d', strtotime($cartItem['end_date']));
                        }
                        if ($product_variation == 'EnamBulan') {
                            $order_detail->start_date = date('Y-m-d', strtotime($cartItem['start_date']));
                            $order_detail->end_date = date('Y-m-d', strtotime($cartItem['end_date']));
                        }
                        if ($product_variation == 'Tahunan') {
                            $order_detail->start_date = date('Y-m-d', strtotime($cartItem['start_date']));
                            $order_detail->end_date = date('Y-m-d', strtotime($cartItem['end_date']));
                        }

                        $order_detail->save();
                        $product->num_of_sale++;
                        $product->save();
                    }
                    $seller = Seller::where('user_id', $seller_id)->first();

                    $tax = $subtotal*0.1;
                    $order->total = $subtotal;
                    $order->tax = $tax;
                    $grandtotal = $subtotal+$tax;
                    $order->grand_total = $grandtotal;
                    $order->adpoint_earning = $seller->commission/100*$grandtotal;

                    if (Session::has('coupon_discount')) {
                        $order->grand_total -= Session::get('coupon_discount');
                        $order->coupon_discount = Session::get('coupon_discount');
                        $coupon_usage = new CouponUsage;
                        $coupon_usage->user_id = Auth::user()->id;
                        $coupon_usage->coupon_id = Session::get('coupon_id');
                        $coupon_usage->save();
                    }
                    $order->save();
                    $request->session()->put('order_id', $order->id);
                }
            }
        }
        $buyer_name = Auth::user()->name;
        $buyer_email = Auth::user()->email;
        $data = Transaction::where('id', $trx->id)->first();
        $admin = User::where('user_type','admin')->first();
        Mail::to($buyer_email)->send(new OrderStart($data));
        Notification::send($admin, new OrderProses($buyer_name, $trx->id, $trx->code));
        event(new OrderProsesEvent('New transactions '.$trx->code.' from '.$buyer_name));
        Mail::to($admin->email)->send(new AdminOrderStart($admin));
        $push = DB::table('pushy_tokens as pt')
                ->join('users as u', 'u.id', '=', 'pt.user_id')
                ->where(['u.user_type' => 'admin'])
                ->select(['pt.*'])
                ->first();
        if ($push !== null) {
            $tokenPushy = $push->device_token;
            $data = array('message' => 'New transactions from '.$buyer_name);
            $to = array($tokenPushy);
            $options = array(
                'notification' => array(
                    'badge' => 1,
                    'sound' => 'ping.aiff',
                    'body'  => 'New transactions from '.$buyer_name
                )
            );
            Pushy::sendPushNotification($data, $to, $options);
        }
    }

    public function show($id)
    {
        $order = Order::findOrFail(decrypt($id));
        $order->viewed = 1;
        $order->save();
        return view('orders.show', compact('order'));
    }


    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        if ($order != null) {
            foreach ($order->orderDetails as $key => $orderDetail) {
                $orderDetail->delete();
            }
            $order->delete();
            flash('Order has been deleted successfully')->success();
        } else {
            flash('Something went wrong')->error();
        }
        return back();
    }

    public function order_details(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        return view('frontend.partials.order_details_seller', compact('order'));
    }

    // get load from ajax
    public function order_place()
    {
        $order_details = $this->get_items(0);
        return view('myorderseller.order_place', compact('order_details'));
    }

    public function order_review()
    {
        $order_details = $this->get_items(1);
        return view('myorderseller.order_review', compact('order_details'));
    }

    public function order_active()
    {
        $order_details = $this->get_items(3);
        return view('myorderseller.order_active', compact('order_details'));
    }

    public function order_completes()
    {
        $order_details = $this->get_items(4);
        return view('myorderseller.order_completes', compact('order_details'));
    }

    public function order_cancelled()
    {
        $order_details = $this->get_items(2);
        return view('myorderseller.order_cancelled', compact('order_details'));
    }

    public function find_orders(Request $request)
    {
        $start = date('Y-m-d H:i:s', strtotime($request->start));
        $end = date('Y-m-d H:i:s', strtotime($request->end));

        switch ($request->status) {
            case '0':
                $order_details = $this->get_find_orders(0, $start, $end);
                return view('myorderseller.order_place', compact('order_details'));
                break;
            case '1':
                $order_details = $this->get_find_orders(1, $start, $end);
                return view('myorderseller.order_review', compact('order_details'));
                break;
            case '3':
                $order_details = $this->get_find_orders(3, $start, $end);
                return view('myorderseller.order_active', compact('order_details'));
                break;
            case '4':
                $order_details = $this->get_find_orders(4, $start, $end);
                return view('myorderseller.order_completes', compact('order_details'));
                break;
            case '100':
                $order_details = $this->get_find_orders(100, $start, $end);
                return view('myorderseller.order_cancelled', compact('order_details'));
                break;
            default:
                break;
        }
    }

    public function get_find_orders($status, $start, $end)
    {
        $query = DB::table('order_details as od')
                        ->orderBy('od.id', 'desc')
                        ->join('orders as o', 'o.id', '=', 'od.order_id')
                        ->where('o.seller_id', Auth::user()->id)
                        ->where('o.approved', 1)
                        ->where('od.status', $status)
                        ->where('od.created_at', '>=', $start)
                        ->where('od.created_at', '<=', $end)
                        ->select([
                            'od.*',
                            'o.id as o_id',
                            'o.user_id as o_user_id',
                            'o.transaction_id as o_trx_id',
                            'o.seller_id as o_seller_id',
                            'o.code as o_code',
                            'o.approved as o_approved',
                            'o.grand_total as o_grandtotal',
                            'o.tax as o_tax',
                            'o.adpoint_earning as o_adpoint_earning',
                            'o.address as o_addres'
                        ])
                        ->get();
        return $query;
    }

    public function post_process_active(Request $request)
    {
        $ap = ActivatedProces::where('order_detail_id', $request->order_detail_id)->first();
        $order_detail = OrderDetail::where('id', $request->order_detail_id)->first();
        $order_id = $order_detail->order_id;
        $product_id = $order_detail->product_id;
        $product_name = Product::where('id', $product_id)->first()->name;
        $order = Order::where('id', $order_id)->first();
        $buyer = User::where('id', $order->user_id)->first();
        $push = DB::table('pushy_tokens as pt')
            ->join('users as u', 'u.id', '=', 'pt.user_id')
            ->where(['u.id' =>  $order->user_id])
            ->select(['pt.*'])
            ->first();
        if ($ap !== null) {
            $ap->status = $request->status;
            if ($request->status == "1") {
                $ap->time_1 = now();
                // pushy notif
                if ($push !== null) {
                    $tokenPushy = $push->device_token;
                    $data = array('message' => $product_name.' material editing process is complete');
                    $to = array($tokenPushy);
                    $options = array(
                        'notification' => array(
                            'badge' => 1,
                            'sound' => 'ping.aiff',
                            'body'  => $product_name." material editing process is complete"
                        )
                    );
                    Pushy::sendPushNotification($data, $to, $options);
                    Notification::send($buyer, new ItemProsesEdit($product_name));
                    event(new ItemProsesEditEvent($product_name.' material editing process is complete'));
                }
            }else if($request->status == "2"){
                $ap->time_2 = now();
                // pushy notif
                if ($push !== null) {
                    $tokenPushy = $push->device_token;
                    $data = array('message' => $product_name.' media installation process is complete');
                    $to = array($tokenPushy);
                    $options = array(
                        'notification' => array(
                            'badge' => 1,
                            'sound' => 'ping.aiff',
                            'body'  => $product_name." media installation process is complete"
                        )
                    );
                    Pushy::sendPushNotification($data, $to, $options);
                    Notification::send($buyer, new ItemProsesInstall($product_name));
                    event(new ItemProsesInstallEvent($product_name.' media installation process is complete'));
                }
            }else if($request->status == "3"){
                $ap->time_3 = now();
                // pushy notif
                if ($push !== null) {
                    $tokenPushy = $push->device_token;
                    $data = array('message' => $product_name.' process is complete, ready to active or aired');
                    $to = array($tokenPushy);
                    $options = array(
                        'notification' => array(
                            'badge' => 1,
                            'sound' => 'ping.aiff',
                            'body'  => $product_name." process is comple, ready to active or aired"
                        )
                    );
                    Pushy::sendPushNotification($data, $to, $options);
                    Notification::send($buyer, new ItemReadyActive($product_name));
                    event(new ItemReadyActiveEvent($product_name.' process is comple, ready to active or aired'));
                }
            }
            $ap->save();
            return 1;
        }else {
            return 0;
        }
    }

    public function slot_available() {
        $events = [];
        $data = DB::table('order_details as od')
                -> join('orders as o', 'o.id', '=', 'od.order_id')
                -> join('products as p', 'p.id', '=', 'od.product_id')
                -> where('od.status', 3)
                -> get();
//        $data = OrderDetail::all();
        if($data->count()) {
            foreach ($data as $key => $value) {
                $coloraddons = substr($value->code, -3);
//                if ($value->code) {
//                    $color = '#33';
//                } else {
//                    $color = '#ef0202';
//                }

                $events[] = Calendar::event(
                    $value->code .' - '. $value->name,
                    true,
                    new \DateTime($value->start_date),
                    new \DateTime($value->end_date),
                    null,
                    [
                        'color' => '#'.$coloraddons. $value->id,
                        'url' => 'pass here url and any route',
                    ]
                );

            }
        }
        $calendar = Calendar::addEvents($events);
        return view('slot.index', compact('calendar'));
    }

}
