<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\User;
use App\Order;
use App\OrderDetail;
use App\Invoice;
use App\ActivatedProces;
use App\Seller;
use App\ConfirmPayment;
use Mail;
use Auth;
use DB;

use PDF;

use App\Pushy;
use App\Mail\Order\OrderNotifPaymentBuyer;
use App\Mail\Order\OrderNotifPaymentSeller;

use Notification;
use App\Notifications\OrderChangeToPaidBuyer;
use App\Events\OrderChangeToPaidBuyerEvent;
use App\Notifications\OrderChangeToPaidSeller;
use App\Events\OrderChangeToPaidSellerEvent;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::orderBy('id', 'desc')->get();
        return view('transactions.index', compact('transactions'));
    }

    public function transaction_details($id)
    {
        $transaction = Transaction::where('id', decrypt($id))->first();
        return view('transactions.transaction_detail', compact('transaction'));
    }

    public function show_invoice(Request $request, $id)
    {
        $inv = Invoice::where('transaction_id', decrypt($id))->first();
        return view('transactions.show_invoice', compact('inv'));
    }

    public function pdf_invoice(Request $request, $id)
    {
        $inv = Invoice::where('transaction_id', $id)->first();
        $pdf = PDF::loadview('transactions.pdf_inv', compact('inv'));
        return $pdf->download($inv->code);
    }

    public function show_payment(Request $request, $code)
    {
        $confirm_payment = DB::table('confirm_payments as cp')
                                ->join('transactions as t', 't.code', '=', 'cp.code_trx')
                                ->where('t.code', $code)
                                ->first();
        $trx = Transaction::where('code', $code)->first();
        return view('transactions.show_payment', compact('confirm_payment', 'trx'));
    }

    public function change_to_paid(Request $request, $code)
    {
        $confirm_payment = ConfirmPayment::where('code_trx', $code)->first();
        $confirm_payment->approved = 1;
        if ($confirm_payment->save()) {
            $transaction = Transaction::where('code', $code)->first();
            $buyer = User::where('id', $transaction->user_id)->first();
            $dataB['buyer_name'] = $buyer->name; 
            $transaction->payment_status = 1;
            $transaction->save();
            // pushy notif
            $push = DB::table('pushy_tokens as pt')
                    ->join('users as u', 'u.id', '=', 'pt.user_id')
                    ->where(['u.id' => $buyer->id])
                    ->select(['pt.*'])
                    ->first();
            if ($push !== null) {
                $tokenPushy = $push->device_token;
                $data = array('message' => 'Thank you for making payment');
                $to = array($tokenPushy);
                $options = array(
                    'notification' => array(
                        'badge' => 1,
                        'sound' => 'ping.aiff',
                        'body'  => "Thank you for making payment"
                    )
                );
                Pushy::sendPushNotification($data, $to, $options);
            }
            Mail::to($buyer->email)->send(new OrderNotifPaymentBuyer($dataB));
            Notification::send($buyer, new OrderChangeToPaidBuyer());
            event(new OrderChangeToPaidBuyerEvent('Thank you for making payment'));
            foreach ($transaction->orders as $key => $o) {
                $order = Order::where(['id' => $o->id, 'approved' => 1])->first();
                foreach ($order->orderDetails as $key => $od) {
                    $od = OrderDetail::where('id', $od->id)->first();
                    $od->is_paid = true;
                    $od->save();

                    $ap = new ActivatedProces;
                    $ap->order_detail_id = $od->id;
                    $ap->status = 0;
                    $ap->save();
                }
                $seller = User::where('id', $o->seller_id)->first();
                $dataS['seller_name'] = $seller->name;
                // pushy notif
                $push = DB::table('pushy_tokens as pt')
                        ->join('users as u', 'u.id', '=', 'pt.user_id')
                        ->where(['u.id' => $o->seller_id])
                        ->select(['pt.*'])
                        ->first();
                if ($push !== null) {
                    $tokenPushy = $push->device_token;
                    $data = array('message' => 'Order '.$o->code.' has been paid, please continue');
                    $to = array($tokenPushy);
                    $options = array(
                        'notification' => array(
                            'badge' => 1,
                            'sound' => 'ping.aiff',
                            'body'  => "Order '.$o->code.' has been paid, please continue"
                        )
                    );
                    Pushy::sendPushNotification($data, $to, $options);
                }
                Mail::to($seller->email)->send(new OrderNotifPaymentSeller($dataS));
                Notification::send($seller, new OrderChangeToPaidSeller($o->code));
                event(new OrderChangeToPaidSellerEvent('Order '.$o->code.' has been paid, please continue'));
            }
            $request->session()->flash('message', 'Change to paid success');
            return redirect('admin/transaction');
        }
    }

    public function get_trx($status = null)
    {
        $trx = Transaction::orderBy('id', 'desc')
                        ->where([
                            'user_id' => Auth::user()->id,
                            'payment_status' => $status
                        ])
                        ->get();
        return $trx;
    }

    public function trx_page_buyer()
    {
        $trx = $this->get_trx();
        return view('frontend.customer.trx_buyer', compact('trx'));
    }

    public function show_transaction_details(Request $request)
    {
        $transaction = Transaction::where('id', $request->trx_id)->first();
        return view('frontend.partials.show_trx_details', compact('transaction'));
    }

    public function trx_unpaid()
    {
        $trx = $this->get_trx(0);
        return view('mytrx.unpaid', compact('trx'));
    }

    public function trx_paid()
    {
        $trx = $this->get_trx(1);
        return view('mytrx.paid', compact('trx'));
    }

    public function find_trx_unpaid(Request $request)
    {
        if ($request->value == null) {
            $trx = Transaction::where([
                'payment_status' => 0,
                'user_id' => Auth::user()->id
            ])->get();
        }else {
            $trx = DB::table('transactions')
                    ->where('code', 'like', '%'.$request->value.'%')
                    ->where('payment_status', 0)
                    ->get();
        }
        return view('mytrx.find_unpaid_trx', compact('trx'));
    }

    public function find_trx_paid(Request $request)
    {
        if ($request->value == null) {
            $trx = Transaction::where([
                'payment_status' => 1,
                'user_id' => Auth::user()->id
            ])->get();
        }else {
            $trx = DB::table('transactions')
                        ->where('code', 'like', '%'.$request->value.'%')
                        ->where('payment_status', 1)
                        ->get();
        }
        return view('mytrx.find_paid_trx', compact('trx'));
    }

    public function reject_detail(Request $request)
    {
        $order_detail = OrderDetail::where('id', $request->order_detail_id)->first();
        return view('transactions.reject_detail', compact('order_detail'));
    }

    public function reject_detail_proses(Request $request)
    {
        $order_detail = OrderDetail::where('id', $request->order_detail_id)->first();

        if ($order_detail !== null) {
            $order_detail->is_confirm = 1;
            // calculate earning
            $order = Order::where('id', $order_detail->order_id)->first();
            $mintotal = $order->total-$order_detail->total;
            $mintax = $mintotal*0.1;
            $mingrandtotal = $mintotal+$mintax;

            $seller = Seller::where('user_id', $order->seller_id)->first();
            $minadpointearning = $seller->commission/100*$mingrandtotal;

            $order->total = $mintotal;
            $order->tax = $mintax;
            $order->grand_total = $mingrandtotal;
            $order->adpoint_earning = $minadpointearning;

            $order_detail->save();
            $order->save();

            return back();
        }
        
        
    }
}
