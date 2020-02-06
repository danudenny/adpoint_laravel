<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\User;
use App\Order;
use App\OrderDetail;
use App\Invoice;
use App\ConfirmPayment;
use Mail;
use Auth;
use DB;

use App\Mail\Order\OrderNotifPaymentBuyer;
use App\Mail\Order\OrderNotifPaymentSeller;

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
            Mail::to($buyer->email)->send(new OrderNotifPaymentBuyer($dataB));
            foreach ($transaction->orders as $key => $o) {
                $order = Order::where(['id' => $o->id, 'approved' => 1])->first();
                foreach ($order->orderDetails as $key => $od) {
                    $od = OrderDetail::where('id', $od->id)->first();
                    $od->is_paid = true;
                    $od->save();
                }
                $seller = User::where('id', $o->seller_id)->first();
                $dataS['seller_name'] = $seller->name;
                Mail::to($seller->email)->send(new OrderNotifPaymentSeller($dataS));
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
        if ($request->value == null || $request->value == "") {
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
        if ($request->value == null || $request->value == "") {
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
}
