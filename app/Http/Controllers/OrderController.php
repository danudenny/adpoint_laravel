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
use Auth;
use Session;
use DB;
use PDF;
use Mail;
use File;
// use App\Mail\Order\OrderComplete;
use App\Mail\Order\OrderStart;
use App\Mail\Order\OrderApprovedAdmin;
use App\Mail\Order\OrderSold;
use App\Mail\Order\OrderDisapprovedAdmin;
use App\Mail\Order\OrderApprovedSeller;
use App\Mail\Order\OrderDisapprovedSeller;
use App\Mail\Order\OrderNotifPaymentBuyer;
use App\Mail\Order\OrderNotifPaymentSeller;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource to seller.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = DB::table('orders')
                    ->orderBy('code', 'desc')
                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                    ->where('order_details.seller_id', Auth::user()->id)
                    ->select('orders.id','status_order')
                    ->distinct()
                    ->paginate(9);
        return view('frontend.seller.orders', compact('orders'));
    }

    public function list_orders(Request $request)
    {
        $orders = Order::orderBy('code', 'desc')->get();
        return view('orders.list_orders', compact('orders'));
    }

    public function approve_by_admin($id)
    {
        $order = Order::findOrFail(decrypt($id));
       
        $user = User::findOrFail($order->user_id);
        $users['name'] = $user->name;
        $users['email'] = $user->email;
        $users['code'] = $order->code;

        $seller = DB::table('orders')
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->join('users', 'order_details.seller_id', '=', 'users.id')
                ->select('users.*')
                ->where('orders.id','=',decrypt($id))
                ->first();
        $sellers['name'] = $seller->name;
        $sellers['email'] = $seller->email;
        $sellers['code'] = $order->code;
        if($order != null){
            $order->status_order = 1;
            $order->updated_at = time();
            $order->save();
            Mail::to($user->email)->send(new OrderApprovedAdmin($users));
            Mail::to($seller->email)->send(new OrderSold($sellers));
            flash('Order approved')->success();
        }
        else{
            flash('Something went wrong')->error();
        }
        return back();
    }

    public function disapprove_by_admin(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $user = User::findOrFail($order->user_id);
        $users['name'] = $user->name;
        $users['email'] = $user->email;
        $users['code'] = $order->code;
        $users['alasan'] = $request->alasan;
        if($order != null){
            $order->status_order = 0;
            $order->updated_at = time();
            $order->save();
            Mail::to($user->email)->send(new OrderDisapprovedAdmin($users));
            flash('Order disapproved')->success();
        }
        else{
            flash('Something went wrong')->error();
        }
        return back();
    }

    public function approve_by_seller($id)
    {
        $query = DB::table('orders as o')
            ->join('order_details as od', 'o.id', '=', 'od.order_id')
            ->join('users as b', 'o.user_id', '=', 'b.id')
            ->join('users as s', 'od.seller_id', '=', 's.id')
            ->join('products as p', 'od.product_id', '=', 'p.id')
            ->select(
                [
                    'p.name as product_name',
                    'o.code',
                    'o.shipping_address',
                    'o.grand_total',
                    'o.payment_type',
                    'o.created_at',
                    'b.name as buyer_name',
                    'b.email as buyer_email',
                    's.name as seller_name',
                    's.email as seller_email',
                    'od.variation',
                    'od.price',
                    'od.tax',
                    'od.quantity',
                    'od.payment_status',
                    'od.delivery_status',
                    'od.start_date',
                    'od.end_date'

                ]
            )
            ->where('o.id','=',decrypt($id))
            ->get();
        $product = [];
        foreach ($query as $key => $q) {
            array_push($product, [
                'name' => $q->product_name, 
                'price' => $q->price,
                'start_date' => $q->start_date,
                'end_date' => $q->end_date,
                'periode' => $q->variation,
                'qty' => $q->quantity
            ]);
            $users['id'] = decrypt($id);
            $users['code'] = $q->code;
            $users['shipping_address'] = $q->shipping_address;
            $users['tax'] = $q->tax;
            $users['grand_total'] = $q->grand_total; 
            $users['payment_type'] = $q->payment_type; 
            $users['created_at'] = $q->created_at; 
            $users['buyer_name'] = $q->buyer_name; 
            $users['buyer_email'] = $q->buyer_email; 
            $users['seller_name'] = $q->seller_name; 
            $users['seller_email'] = $q->seller_email; 
            $users['payment_status'] = $q->payment_status; 
            $users['delivery_status'] = $q->delivery_status;
        }
        $users['product'] = $product;
        // dd($users);
        $order = Order::findOrFail(decrypt($id));
        if($order != null){
            $order->status_order = 2;
            $order->updated_at = time();
            $order->save();
            Mail::to($users['buyer_email'])->send(new OrderApprovedSeller($users));
            flash('Order approved')->success();
        }
        else{
            flash('Something went wrong')->error();
        }
        return back();
    }

    public function disapprove_by_seller($id)
    {
        $order = Order::findOrFail(decrypt($id));
        $user = User::findOrFail($order->user_id);
        $users['name'] = $user->name;
        $users['email'] = $user->email;
        $users['code'] = $order->code;
        if($order != null){
            $order->status_order = 3;
            $order->updated_at = time();
            $order->save();
            Mail::to($user->email)->send(new OrderDisapprovedSeller($users));
            flash('Order disapproved')->success();
        }
        else{
            flash('Something went wrong')->error();
        }
        return back();
    }

    /**
     * Display a listing of the resource to admin.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display a listing of the sales to admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function sales(Request $request)
    {
        $orders = Order::orderBy('code', 'desc')->get();
        return view('sales.index', compact('orders'));
    }


    public function confirm_payment($id)
    {
        $order_id = decrypt($id);
        $order = DB::table('orders as o')
                    ->join('order_details as od', 'o.id', '=', 'od.order_id')
                    ->join('users as u', 'o.user_id', '=', 'u.id')
                    ->join('products as p', 'od.product_id', '=', 'p.id')
                    ->select([
                        'o.code',
                        'o.status_order',
                        'o.status_confirm',
                        'u.name as buyer_name',
                        'od.variation',
                        'od.quantity',
                        'od.price',
                        'od.start_date',
                        'od.end_date',
                        'p.name'
                    ])
                    ->where('o.id',$order_id)->get();
        return view('frontend.confirm_payment', compact('order_id', 'order'));
    }

    public function insert_confirm_payment(Request $request)
    {
        $request->validate([
            'no_rek' => 'required',
            'bukti' => 'required'
        ]);
        $order = Order::where('id', $request->order_id)->first();
        if ($order != null) {
            $order->status_confirm = 1;
            $order->updated_at = time();
            $order->save();
        }
        $confirm_payment = New ConfirmPayment;
        if ($request->all() != null) {
            $confirm_payment->order_id = $request->order_id;
            $confirm_payment->no_order = $request->no_order;
            $confirm_payment->nama = $request->nama;
            $confirm_payment->nama_bank = $request->nama_bank;
            $confirm_payment->no_rek = $request->no_rek;
            $confirm_payment->bukti = $request->bukti->store('uploads/bukti_transfer');
            $confirm_payment->read = 0;
            $confirm_payment->save();
            flash('Order confirmed')->success();
        }else{
            flash('Something went wrong')->error();
        }
        return redirect('purchase_history');
    }

    public function show_payment($id)
    {
        $cp = ConfirmPayment::where('order_id', decrypt($id))->first();
        if ($cp != null) {
            $cp->read = 1;
            $cp->updated_at = time();
            $cp->save();
        }
        $query = DB::table('confirm_payments as cp')
                    ->join('orders as o', 'o.id', '=', 'cp.order_id')
                    ->where('cp.order_id',decrypt($id))
                    ->select([
                        'cp.no_order',
                        'cp.nama',
                        'cp.nama_bank',
                        'cp.no_rek',
                        'cp.bukti',
                        'o.grand_total',
                        'o.payment_status'
                    ])->get();
        $order_id = decrypt($id);
        return view('confirm_payment.show_payment', compact('query', 'order_id'));
    }

    public function change_to_paid($id)
    {
        $order = Order::where('id',decrypt($id))->first();
        $query = DB::table('orders as o')
            ->join('order_details as od', 'o.id', '=', 'od.order_id')
            ->join('users as b', 'o.user_id', '=', 'b.id')
            ->join('users as s', 'od.seller_id', '=', 's.id')
            ->select(
                [
                    'o.code',
                    'o.grand_total',
                    'b.name as buyer_name',
                    'b.email as buyer_email',
                    's.name as seller_name',
                    's.email as seller_email',
                ]
            )
            ->where('o.id','=',decrypt($id))
            ->first();
        $users = [];
        $users['order_id'] = decrypt($id);
        $users['code'] = $query->code;
        $users['grand_total'] = $query->grand_total;
        $users['buyer_name'] = $query->buyer_name;
        $users['buyer_email'] = $query->buyer_email;
        $users['seller_name'] = $query->seller_name;
        $users['seller_email'] = $query->seller_email;

        if ($order != null) {
            $order->payment_status = 'paid';
            $order->updated_at = time();
            $order->save();
            Mail::to($users['buyer_email'])->send(new OrderNotifPaymentBuyer($users));
            Mail::to($users['seller_email'])->send(new OrderNotifPaymentSeller($users));
            flash('Order Paid')->success();
        }else{
            flash('Something went wrong')->error();
        }
        return back();
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
        }else{
            flash('Something went wrong')->error();
        }
        return back();
    }

    /**
     * Display a single sale to admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function sales_show($id)
    {
        $order = Order::findOrFail(decrypt($id));
        return view('sales.show', compact('order'));
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
        $cart = [];
        $data = [];
        foreach (Session::get('cart') as $sc) {
            array_push($cart, $sc);
        }
        foreach ($cart as $c) {
            $data[$c['user_id']][] = $c;
        }    

        foreach ($data as $key => $d) {
            $order = new Order;
            if(Auth::check()){
                $order->user_id = Auth::user()->id;
            }else{
                $order->guest_id = mt_rand(100000, 999999);
            }
            $order->shipping_address = json_encode($request->session()->get('shipping_info'));
            $order->payment_type = $request->payment_option;
            $order->code = date('Ymd-his');
            $order->date = strtotime('now');
            $order->status_confirm = 0;
            if ($request->hasFile('file_ads')) {
                $order->file_advertising = $request->file_ads->store('uploads/materi_advertising');
                $order->desc_advertising = $request->desc_ads;
            }
            if ($order->save()) {
                $subtotal = 0;
                $tax = 0;
                $shipping = 0;
                foreach ($d as $value) {
                    $product = Product::find($value['id']);
                    $subtotal += $value['price']*$value['quantity'];
                    $tax += $value['tax']*$value['quantity'];
                    $shipping += $value['shipping']*$value['quantity'];
                    $product_variation = null;
                    if(isset($value['color'])){
                        $product_variation .= Color::where('code', $value['color'])->first()->name;
                    }
                    
                    foreach (json_decode($product->choice_options) as $choice){
                        $str = $choice->title;
                        if ($product_variation != null) {
                            $product_variation .= $value[$str];
                        }
                        else {
                            $product_variation .= $value[$str];
                        }
                    }

                    if($product_variation != null){
                        $variations = json_decode($product->variations);
                        $variations->$product_variation->qty -= $value['quantity'];
                        $product->variations = json_encode($variations);
                        $product->save();
                    }

                    $order_detail = new OrderDetail;
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
                    $order_detail->order_id  = $order->id;
                    $order_detail->seller_id = $value['user_id'];
                    $order_detail->status_tayang = 0;
                    $order_detail->complete = 0;
                    $order_detail->product_id = $value['id'];
                    $order_detail->variation = $product_variation;
                    $order_detail->price = $value['price'] * $value['quantity'];
                    $order_detail->tax = $value['tax'] * $value['quantity'];
                    $order_detail->shipping_cost = $value['shipping']*$value['quantity'];
                    $order_detail->quantity = $value['quantity'];
                    $order_detail->save();

                    $product->num_of_sale++;
                    $product->save();
                }
                $order->grand_total = $subtotal + $tax + $shipping;
                if(Session::has('coupon_discount')){
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
                Mail::to($send_to)->send(new OrderStart($user));
                $request->session()->put('order_id', $order->id);
            }
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail(decrypt($id));
        $order->viewed = 1;
        $order->save();
        return view('orders.show', compact('order'));
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
        $order = Order::findOrFail($id);
        if($order != null){
            foreach($order->orderDetails as $key => $orderDetail){
                $orderDetail->delete();
            }
            $order->delete();
            flash('Order has been deleted successfully')->success();
        }
        else{
            flash('Something went wrong')->error();
        }
        return back();
    }

    public function order_details(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        return view('frontend.partials.order_details_seller', compact('order'));
    }

    public function update_delivery_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        foreach($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail){
            $orderDetail->delivery_status = $request->status;
            $orderDetail->save();
        }
        return 1;
    }

    public function update_payment_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        foreach($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail){
            $orderDetail->payment_status = $request->status;
            $orderDetail->save();
        }
        $status = 'paid';
        foreach($order->orderDetails as $key => $orderDetail){
            if($orderDetail->payment_status != 'paid'){
                $status = 'unpaid';
            }
        }
        $order->payment_status = $status;
        $order->save();
        return 1;
    }
}
