<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\User;
use App\Product;
use App\Color;
use App\OrderDetail;
use App\CouponUsage;
use Auth;
use Session;
use DB;
use PDF;
use Mail;
use App\Mail\Order\OrderComplete;
use App\Mail\Order\OrderReviewed;
use App\Mail\Order\OrderSold;
use App\Mail\Order\OrderApproved;

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
                    ->select('orders.id','approved')
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
            $order->approved = 1;
            $order->updated_at = time();
            $order->save();
            Mail::to($user->email)->send(new OrderReviewed($users));
            Mail::to($seller->email)->send(new OrderSold($sellers));
            flash('Order approved')->success();
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
        dd($users);
        $order = Order::findOrFail(decrypt($id));
        if($order != null){
            $order->approved = 2;
            $order->updated_at = time();
            $order->save();
            Mail::to($users['buyer_email'])->send(new OrderApproved($users));
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
        if($order != null){
            $order->approved = 0;
            $order->updated_at = time();
            $order->save();
            // Mail::to($user->email)->send(new OrderReviewed($users));
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
        $order = new Order;
        if(Auth::check()){
            $order->user_id = Auth::user()->id;
        }
        else{
            $order->guest_id = mt_rand(100000, 999999);
        }

        $order->shipping_address = json_encode($request->session()->get('shipping_info'));
        $order->payment_type = $request->payment_option;
        $order->code = date('Ymd-his');
        $order->date = strtotime('now');

        if($order->save()){
            $subtotal = 0;
            $tax = 0;
            $shipping = 0;
            foreach (Session::get('cart') as $key => $cartItem){
                $product = Product::find($cartItem['id']);
                $subtotal += $cartItem['price']*$cartItem['quantity'];
                $tax += $cartItem['tax']*$cartItem['quantity'];
                $shipping += $cartItem['shipping']*$cartItem['quantity'];
                $product_variation = null;
                if(isset($cartItem['color'])){
                    $product_variation .= Color::where('code', $cartItem['color'])->first()->name;
                }
                foreach (json_decode($product->choice_options) as $choice){
                    $str = $choice->title; // example $str =  choice_0
                    if ($product_variation != null) {
                        $product_variation .= $cartItem[$str];
                    }
                    else {
                        $product_variation .= $cartItem[$str];
                    }
                }


                if($product_variation != null){
                    $variations = json_decode($product->variations);
                    $variations->$product_variation->qty -= $cartItem['quantity'];
                    $product->variations = json_encode($variations);
                    $product->save();
                }
                
                $order_detail = new OrderDetail;
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
                $order_detail->order_id  =$order->id;
                $order_detail->seller_id = $product->user_id;
                $order_detail->product_id = $product->id;
                $order_detail->variation = $product_variation;
                $order_detail->price = $cartItem['price'] * $cartItem['quantity'];
                $order_detail->tax = $cartItem['tax'] * $cartItem['quantity'];
                $order_detail->shipping_cost = $cartItem['shipping']*$cartItem['quantity'];
                $order_detail->quantity = $cartItem['quantity'];
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
            Mail::to($send_to)->send(new OrderComplete($user));
            //stores the pdf for invoice
            // $pdf = PDF::setOptions([
            //                 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true,
            //                 'logOutputFile' => storage_path('logs/log.htm'),
            //                 'tempDir' => storage_path('logs/')
            //             ])->loadView('invoices.customer_invoice', compact('order'));
            // $output = $pdf->output();
    		// file_put_contents('public/invoices/'.'Order#'.$order->code.'.pdf', $output);

            // $array['view'] = 'emails.invoice';
            // $array['subject'] = 'Order Placed - '.$order->code;
            // $array['from'] = env('MAIL_USERNAME');
            // $array['content'] = 'Hi. Your order has been placed';
            // $array['file'] = 'public/invoices/Order#'.$order->code.'.pdf';
            // $array['file_name'] = 'Order#'.$order->code.'.pdf';

            //sends email to customer with the invoice pdf attached
            // if(env('MAIL_USERNAME') != null && env('MAIL_PASSWORD') != null){
            //     Mail::to($request->session()->get('shipping_info')['email'])->queue(new InvoiceEmailManager($array));
            // }
            // unlink($array['file']);

            $request->session()->put('order_id', $order->id);
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
