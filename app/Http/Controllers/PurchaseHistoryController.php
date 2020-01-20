<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderDetail;
use Auth;
use DB;

class PurchaseHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $orders = Order::where('user_id', Auth::user()->id)->orderBy('code', 'desc')->paginate(9);
        $order_details = DB::table('order_details as od')
                            ->join('orders as o', 'o.id', '=', 'od.order_id')
                            ->where('o.user_id', Auth::user()->id)
                            ->get();
        return view('frontend.purchase_history', compact('order_details'));
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
