<?php

namespace App\Http\Controllers;
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
use Session;
use DB;
use PDF;
use Mail;
use File;
use Carbon\Carbon;

use App\Mail\Order\OrderStart;
use App\Mail\Order\OrderApprovedAdmin;
use App\Mail\Order\OrderSold;
use App\Mail\Order\OrderDisapprovedAdmin;
use App\Mail\Order\OrderApprovedSeller;
use App\Mail\Order\OrderConfirmation;
use App\Mail\Order\OrderInvoice;
use App\Mail\Order\OrderDisapprovedSeller;

use Notification;
use App\Notifications\OrderStartPush;
use App\Notifications\OrderApproveAdminPush;
use App\Notifications\OrderSoldPush;
use App\Notifications\OrderApproveSellerPush;

use App\Jobs\PaymentDuration;


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
        $order = Order::where('id', decrypt($id))->first();
        $trx = Transaction::where('id', $order->transaction_id)->first();
        $buyer = User::where('id', $order->user_id)->first();

        $data['code_trx']       = $trx->code;
        $data['buyer_name']     = $buyer->name;
        $data['buyer_email']    = $buyer->email;
        
        if ($order != null) {
            $order->approved = 1; // approve admin
            $order->updated_at = time();
            $order->save();
            $default_status_o = $this->_cek_default_status_orders($order->transaction_id);
            if (count($default_status_o) === 0) {
                Mail::to($buyer->email)->send(new OrderApprovedAdmin($data));
                Notification::send($buyer,new OrderApproveAdminPush);
                $orders = Order::where(['transaction_id' => $order->transaction_id, 'approved' => 1])->get();
                foreach ($orders as $key => $o) {
                    $user = User::where('id', $o->seller_id)->first();
                    $seller['code'] = $o->code;
                    $seller['seller_name'] = $user->name;
                    Mail::to($user->email)->send(new OrderSold($seller));
                    Notification::send($user,new OrderSoldPush);
                }
            }
            $request->session()->flash('message', 'Order ID'.' '.$order->code.' '.'Approved');
            flash('Order approved')->success();
            return back();
        } else {
            flash('Something went wrong')->error();
            return back();
        }
    }

    public function disapprove_by_admin(Request $request)
    {
        $order = Order::where('id', $request->order_id)->first();
        $buyer = User::where('id', $order->user_id)->first();
        $data['code']           = $order->code;
        $data['alasan']         = $request->alasan;
        $data['buyer_name']     = $buyer->name;
        $data['buyer_email']    = $buyer->email;
        if ($order != null) {
            $order->approved = 2; // reject by admin
            $order->updated_at = time();
            $order->save();
            $order_details = OrderDetail::where('order_id', $order->id)->get();
            foreach ($order_details as $key => $od) {
                $od->status = 100;
                $od->save();
            }
            $default_status_o = $this->_cek_default_status_orders($order->transaction_id);
            if (count($default_status_o) === 0) {
                Mail::to($buyer->email)->send(new OrderDisapprovedAdmin($data));
                $orders = Order::where(['transaction_id' => $order->transaction_id, 'approved' => 1])->get();
                foreach ($orders as $key => $o) {
                    $user = User::where('id', $o->seller_id)->first();
                    $seller['code'] = $o->code;
                    $seller['seller_name'] = $user->name;
                    Mail::to($user->email)->send(new OrderSold($seller));
                }
            }
            flash('Order disapproved')->success();
            $request->session()->flash('message', 'Order ID'.' '.$order->code.' '.'Rejected');
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
        $data['expire_date'] = date('d M Y h:i:s', strtotime($expire_date));
        $data['code_trx']   = $trx->code;
        $data['created_at'] = date('d M Y h:i:s', strtotime($trx->created_at));
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
                    Notification::send(User::where('user_type','admin')->get(),new OrderApproveSellerPush);
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
            $order_detail->rejected = $request->alasan;
            $order_detail->updated_at = time();
            $product = Product::where('id', $order_detail->product_id)->first();
            if ($order_detail->save()) {
                $order = Order::where('id', $order_detail->order_id)->first();
                $default_status_od = $this->_cek_default_status_order_details($order->transaction_id);
                if (count($default_status_od) === 0) {
                    $trx = Transaction::where('id', $order->transaction_id)->first();
                    $trx->status = "ready";
                    $trx->save();
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
        $invoice = $this->_generate_invoice($request->trx_id);
        return view('frontend.partials.confirm_to_buyer', compact('invoice'));
    }

    public function proses_confirm_to_buyer(Request $request)
    {
        $invoice = $this->_generate_invoice($request->trx_id);
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
            PaymentDuration::dispatch($trx)->delay($order_date); // job expire date
        }
        if ($invoice != null) {
            Mail::to($invoice['buyer_email'])->send(new OrderConfirmation($invoice));
            flash('Order confirmed')->success();
            $request->session()->flash('message', 'CODE: '.' '.$invoice['code_trx'].' '.'Confirmed');
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
        $invoice = $this->_generate_invoice(decrypt($trx_id));
        Mail::to($invoice['buyer_email'])->send(new OrderInvoice($invoice));
        flash('Order confirmed')->success();
        $request->session()->flash('message', 'CODE: '.' '.$invoice['code_trx'].' '.'Confirmed');

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
                $trx->save();
            }
            $confirm_payment->user_id = $request->user_id;
            $confirm_payment->nama = $request->nama;
            $confirm_payment->nama_bank = $request->nama_bank;
            $confirm_payment->no_rek = $request->no_rek;
            $confirm_payment->bukti = $request->bukti->store('uploads/bukti_transfer');
            $confirm_payment->approved = 0;
            $confirm_payment->save();
            $trx = Transaction::where('id', $request->trx_id)->first();
            flash('Order confirmed')->success();
            $request->session()->flash('message', 'Transaction paid!');
            return redirect('transaction');
        } else {
            flash('Something went wrong')->error();
            return back();
        }
        
    }

    public function activate(Request $request, $id)
    {
       $item = OrderDetail::where('id', decrypt($id))->first();
       $product = Product::where('id', $item->product_id)->first();
       if ($item !== null) {
           $item->status = 3; // activated
           $item->save();
           flash('Item '.$product->name.' Activated!')->success();
           return back();
       }else {
            flash('Item '.$product->name.' Invalid!')->error();
            return back();
       }
    }

    public function order_complete($order_detail_id)
    {
        $od_id = decrypt($order_detail_id);
        $orderDetail = OrderDetail::where('id', $od_id)->first();
        if ($orderDetail) {
            $orderDetail->complete = 1;
            $orderDetail->updated_at = time();
            $orderDetail->save();
            flash('Order Paid')->success();
            $order_detail = OrderDetail::where(['order_id' => $orderDetail->order_id])->count();
            $order_detail_complete = OrderDetail::where(['order_id' => $orderDetail->order_id, 'complete' => 1])->count();
            if ($order_detail == $order_detail_complete) {
                $order = Order::where('id', $orderDetail->order_id)->first();
                if ($order != null) {
                    $order->status_order = 5;
                    $order->updated_at = time();
                    $order->save();
                }
            }
        } else {
            flash('Something went wrong')->error();
        }
        return back();
    }

    public function store(Request $request)
    {

        $cart = [];
        $data = [];
        foreach (Session::get('cart') as $sc) {
            array_push($cart, $sc);
        }
        foreach ($cart as $c) {
            $data[$c['user_id']][] = $c;
        }

        $trx = new Transaction;
        $trx->code = 'TRX-'.time();
        $trx->payment_status = 0;
        $trx->payment_type = $request->payment_option;
        $trx->user_id = Auth::user()->id;
        $trx->file_advertising = $request->file_ads;
        $trx->description = $request->desc_ads;
        $cart = [];
        $data = [];
        foreach (Session::get('cart') as $sc) {
            array_push($cart, $sc);
        }
        foreach ($cart as $c) {
            $data[$c['user_id']][] = $c;
        }

        if ($trx->save()) {
            foreach ($data as $key => $d) {
                $order = new Order;
                if (Auth::check()) {
                    $order->user_id = Auth::user()->id;
                }
                $order->address = json_encode($request->session()->get('shipping_info'));               
                $order->code = 'ODR-'.time().''.$key;
                $order->transaction_id = $trx->id;
                $order->seller_id = $key;
                $order->approved = 0;
                if ($order->save()) {
                    $subtotal = 0;
                    foreach ($d as $value) {
                        $product = Product::find($value['id']);
                        $subtotal += $value['price'] * $value['quantity'];
                        $product_variation = null;
    
                        foreach (json_decode($product->choice_options) as $choice) {
                            $str = $choice->title;
                            if ($product_variation != null) {
                                $product_variation .= $value[$str];
                            } else {
                                $product_variation .= $value[$str];
                            }
                        }
    
                        if ($product_variation != null) {
                            $variations = json_decode($product->variations);
                            $variations->$product_variation->qty -= $value['quantity'];
                            $product->variations = json_encode($variations);
                            $product->save();
                        }
    
                        $order_detail = new OrderDetail;
                        
                        $order_detail->order_id  = $order->id;
                        $order_detail->seller_id = $value['user_id'];
                        $order_detail->product_id = $value['id'];
                        $order_detail->variation = $product_variation;
                        $order_detail->price = $value['price'] * $value['quantity'];
                        $order_detail->quantity = $value['quantity'];
                        $order_detail->status = 0;

                        if ($product_variation == 'Harian') {
                            $order_detail->start_date = date('Y-m-d', strtotime($value['start_date']));
                            $order_detail->end_date = date('Y-m-d', strtotime($value['end_date']));
                        }
                        if ($product_variation == 'Mingguan') {
                            $order_detail->start_date = date('Y-m-d', strtotime($value['start_date']));
                            $order_detail->end_date = date('Y-m-d', strtotime($value['end_date']));
                        }
                        if ($product_variation == 'Bulanan') {
                            $order_detail->start_date = date('Y-m-d', strtotime($value['start_date']));
                            $order_detail->end_date = date('Y-m-d', strtotime($value['end_date']));
                        }
                        if ($product_variation == 'TigaBulan') {
                            $order_detail->start_date = date('Y-m-d', strtotime($value['start_date']));
                            $order_detail->end_date = date('Y-m-d', strtotime($value['end_date']));
                        }
                        if ($product_variation == 'EnamBulan') {
                            $order_detail->start_date = date('Y-m-d', strtotime($value['start_date']));
                            $order_detail->end_date = date('Y-m-d', strtotime($value['end_date']));
                        }
                        if ($product_variation == 'Tahunan') {
                            $order_detail->start_date = date('Y-m-d', strtotime($value['start_date']));
                            $order_detail->end_date = date('Y-m-d', strtotime($value['end_date']));
                        }

                        $order_detail->save();
    
                        $product->num_of_sale++;
                        $product->save();
                    }
                    $seller = Seller::where('user_id', $key)->first();

                    $tax = $subtotal*0.1;
                    $grandtotal = $subtotal+$tax;
                    $order->tax = $tax;
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

                    $send_to = $request->session()->get('shipping_info')['email'];
                    $user = $request->session()->get('shipping_info');
                    $order->save();
                    Notification::send(User::where('user_type','admin')->get(),new OrderStartPush);
                    Mail::to($send_to)->send(new OrderStart($user));
                    $request->session()->put('order_id', $order->id);
                }
            }
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
        $order_details = $this->get_items(100);
        return view('myorderseller.order_cancelled', compact('order_details'));
    }

}
