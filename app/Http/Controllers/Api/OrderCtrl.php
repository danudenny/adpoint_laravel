<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetail;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderCtrl extends Controller
{
    /**
     * @OA\Get(
     *     path="/orders",
     *     operationId="list orders",
     *     tags={"Orders"},
     *     summary="Display a listing of the orders",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
    */
    public function index()
    {
        $orders = Order::orderBy('id', 'desc')->get();
        return response()->json($orders, 200);
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
     * @OA\Post(
     *     path="/order/add",
     *     operationId="Add Order",
     *     tags={"Orders"},
     *     summary="Add Brand",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/OrderSchema")
     *     ),
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function store(Request $request)
    {
        $data = $request->order_details[0];
        dd($request->all());
        foreach ($data as $key => $d) {
            $order = new Order;
            $order->user_id = $request->user_id;
            $order->shipping_address = json_encode($request->shipping_address);
            $order->payment_type = $request->payment_option;
            $order->code = date('Ymd-his');
            $order->date = strtotime('now');
            $order->file_advertising = $request->file_advertising;
            $order->desc_advertising = $request->desc_advertising;
            if ($order->save()) {
                $subtotal = 0;
                $tax = 0;
                $shipping = 0;
                foreach ($d as $value) {
                    $product = Product::find($value['product_id']);
                    $subtotal += (int)$value['price']*(int)$value['quantity'];
                    $tax += (int)$value['tax']*(int)$value['quantity'];
                    $shipping += (int)$value['shipping']*(int)$value['quantity'];
                    $product_variation = null;
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
                        $variations->$product_variation->qty -= (int)$value['quantity'];
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
                    $order_detail->product_id = $value['product_id'];
                    $order_detail->variation = $product_variation;
                    $order_detail->price = (int)$value['price'] * (int)$value['quantity'];
                    $order_detail->tax = (int)$value['tax'] * (int)$value['quantity'];
                    $order_detail->shipping_cost = (int)$value['shipping']*(int)$value['quantity'];
                    $order_detail->quantity = $value['quantity'];
                    $order_detail->save();

                    $product->num_of_sale++;
                    $product->save();
                }
                $order->grand_total = $subtotal + $tax + $shipping;
                return response()->json([
                    'data' => $order,
                    'success' => true,
                    'message' => 'Berhasil order'
                ], 200);
            }
        }
    }

    /**
    * @OA\Get(
    *     path="/order/{id}",
    *     operationId="list order by id",
    *     tags={"Orders"},
    *     summary="Display a listing of the order by id",
    *     security={{"bearerAuth":{}}},
    *     @OA\Parameter(
    *         description="ID of order to return",
    *         in="path",
    *         name="id",
    *         required=true,
    *         @OA\Schema(
    *           type="integer",
    *           format="int64"
    *         )
    *     ),
    *     @OA\Response(response="200",description="ok"),
    *     @OA\Response(response="401",description="unauthorized")
    * )
    */
    public function show($id)
    {
        $order = Order::where('id', $id)->get();
        if ($order != null) {
            return response()->json($order, 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 401);
        }
    }

    /**
     * @OA\Get(
     *     path="/orderplaced",
     *     operationId="list order by current user",
     *     tags={"Orders By Current Customer"},
     *     summary="Display a listing of the order by current user",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function orderplaced()
    {
        $orderPlaced = DB::table('orders as o')
            -> join('order_details as od', 'o.seller_id', '=', 'od.seller_id')
            -> join('products as p', 'p.id', '=', 'od.product_id')
            -> orderBy('od.id', 'desc')
            -> where('o.approved', 0)
            -> where('od.status', 0)
            -> where('o.user_id', Auth::user()->id)
            -> groupBy('od.id')
            ->get();
        if ($orderPlaced != null) {
            return response()->json($orderPlaced, 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 401);
        }
    }

    /**
     * @OA\Get(
     *     path="/orderonreview",
     *     operationId="list order on review by current user",
     *     tags={"Orders By Current User"},
     *     summary="Display order on review by current user",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function orderonreview()
    {
        $orderOnReview = DB::table('orders as o')
            -> join('order_details as od', 'o.seller_id', '=', 'od.seller_id')
            -> join('products as p', 'p.id', '=', 'od.product_id')
            -> orderBy('od.id', 'desc')
            -> where('od.status', 1)
            -> where('o.user_id', Auth::user()->id)
            -> groupBy('od.id')
            ->get();
        if ($orderOnReview != null) {
            return response()->json($orderOnReview, 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 401);
        }
    }

    /**
     * @OA\Get(
     *     path="/orderactive",
     *     operationId="list order active by current user",
     *     tags={"Orders By Current User"},
     *     summary="Display order active by current user",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function orderactive()
    {
        $orderActive = DB::table('orders as o')
            -> join('order_details as od', 'o.seller_id', '=', 'od.seller_id')
            -> join('products as p', 'p.id', '=', 'od.product_id')
            -> orderBy('od.id', 'desc')
            -> where('od.status', 3)
            -> where('o.user_id', Auth::user()->id)
            -> groupBy('od.id')
            -> get();
        if ($orderActive != null) {
            return response()->json($orderActive, 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 401);
        }
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

    /**
     * @OA\Get(
     *     path="/cart_session",
     *     operationId="cart session",
     *     tags={"Cart"},
     *     summary="Display a listing of the cart session",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function cartSession()
    {
        if (\Session::has('cart')) {
            $get = \Session::get('cart');
            if ($get != null) {
                return response()->json($get, 200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 401);
            }
        }
//        $order = Order::where('id', $id)->get();
//        if ($order != null) {
//            return response()->json($order, 200);
//        }else{
//            return response()->json([
//                'success' => false,
//                'message' => 'Data tidak ditemukan'
//            ], 401);
//        }
    }
}
