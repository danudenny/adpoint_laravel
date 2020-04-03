<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderDetail;
use App\Evidence;
use Auth;
use DB;

class PurchaseHistoryController extends Controller
{
    public function get_items($status = null)
    {
        $order_details = DB::table('order_details as od')
                            ->orderBy('od.id', 'desc')
                            ->join('orders as o', 'o.id', '=', 'od.order_id')
                            ->where([
                                'o.user_id' => Auth::user()->id,
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
        return view('frontend.purchase_history', compact('order_details'));
    }

    public function item_details(Request $request)
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
                        'od.id as order_detail_id',
                        'od.product_id as item_name',
                        'od.seller_id',
                        'od.status as od_status',
                        'od.rejected as od_rejected',
                        'od.file_advertising as od_file_advertising'
                    ])
                    ->first();
        return view('frontend.partials.item_details', compact('query'));
    }

    public function show_bukti_tayang(Request $request)
    {
        $query = Evidence::where('id', $request->evidence_id)->first();
        return view('frontend.partials.bukti_tayang_customer', compact('query'));
    }

    public function purchase_history_details(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        return view('frontend.partials.order_details_customer', compact('order'));
    }

    public function my_order($id)
    {
        $order_id = decrypt($id);
        $order = DB::table('orders as o')
                    ->join('order_details as od', 'o.id', '=', 'od.order_id')
                    ->join('products as p', 'od.product_id', '=', 'p.id')
                    ->select([
                        'o.code',
                        'o.status_order',
                        'od.variation',
                        'od.quantity',
                        'od.price',
                        'od.start_date',
                        'od.end_date',
                        'p.name'
                    ])
                    ->where('o.id',$order_id)->get();
        // dd($order);
        return view('frontend.my_order_customer', compact('order_id', 'order'));
    }

    // get load from ajax

    public function order_place()
    {
        $order_details = $this->get_items(0);
        return view('myorder.order_place', compact('order_details'));
    }

    public function order_review()
    {
        $order_details = $this->get_items(1);
        return view('myorder.order_review', compact('order_details'));
    }

    public function order_active()
    {
        $order_details = $this->get_items(3);
        return view('myorder.order_active', compact('order_details'));
    }

    public function order_complete()
    {
        $order_details = $this->get_items(4);
        return view('myorder.order_complete', compact('order_details'));
    }

    public function order_cancelled()
    {
        $order_details = $this->get_items(2);
        return view('myorder.order_cancelled', compact('order_details'));
    }

    public function find_myorder(Request $request)
    {
        $start = date('Y-m-d H:i:s', strtotime($request->start));
        $end = date('Y-m-d H:i:s', strtotime($request->end));

        switch ($request->status) {
            case '0':
                $order_details = $this->get_find_myorder(0, $start, $end);
                return view('myorder.order_place', compact('order_details'));
                break;
            case '1':
                $order_details = $this->get_find_myorder(1, $start, $end);
                return view('myorder.order_review', compact('order_details'));
                break;
            case '3':
                $order_details = $this->get_find_myorder(3, $start, $end);
                return view('myorder.order_active', compact('order_details'));
                break;
            case '4':
                $order_details = $this->get_find_myorder(4, $start, $end);
                return view('myorder.order_complete', compact('order_details'));
                break;
            case '100':
                $order_details = $this->get_find_myorder(100, $start, $end);
                return view('myorder.order_cancelled', compact('order_details'));
                break;
            default:
                break;
        }
    }

    public function get_find_myorder($status, $start, $end)
    {
        $query = DB::table('order_details as od')
                    ->join('orders as o', 'o.id', '=', 'od.order_id')
                    ->where('o.user_id', Auth::user()->id)
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
}
