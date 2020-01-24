<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evidence;
use App\User;
use App\OrderDetail;
use App\Order;
use Mail;
use App\Mail\Order\OrderActive;

use DB;
use Auth;

class EvidenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = DB::table('orders as o')
                    ->orderBy('code', 'desc')
                    ->join('order_details as od', 'o.id', '=', 'od.order_id')
                    ->where('od.seller_id', Auth::user()->id)
                    ->select([
                        'o.*'
                    ])
                    ->distinct()
                    ->get();
        return view('frontend.evidence.index', compact('orders'));
    }

    public function bukti_tayang($id)
    {
        $query = DB::table('orders as o')
            ->join('order_details as od', 'o.id', '=', 'od.order_id')
            ->join('products as p', 'od.product_id', '=', 'p.id')
            ->select(
                [
                    'o.id',
                    'o.code',
                    'p.name',
                    'od.id as od_id',
                    'od.product_id'
                ]
            )
            ->where('o.id','=',decrypt($id))
            ->get();
        $order_id = decrypt($id);
        return view('frontend.evidence.bukti_tayang', compact('order_id','query'));
    }

    public function complete($id)
    {
        $order = Order::where('id', decrypt($id))->first();
        if ($order != null) {
            $order->status_order = 5;
            $order->updated_at = time();
            $order->save();
            flash('Evidences success')->success();
        }else{
            flash('Someting Wrong!')->error();
        }
        return back();
    }

    public function bukti_tayang_detail(Request $request)
    {
        $order_active = DB::table('order_details as od')
                            ->join('orders as o', 'o.id', '=', 'od.order_id')
                            ->where([
                                'o.approved'    => 1,
                                'o.seller_id'   => Auth::user()->id,
                                'od.status'     => 3,
                                'od.id'         => $request->order_detail_id
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
                            ->first();
        return view('frontend.partials.form_bukti_tayang', compact('order_active'));
    }

    public function upload_bukti_tayang(Request $request)
    {
        if ($request->hasFile('filegambar')) {
            $filegambar = [];
            $arr = [];
            foreach ($request->filegambar as $key => $g) {
                $path = $g->store('uploads/bukti_tayang');
                array_push($arr, ['filename'=>$path, 'description'=>$request->descgambar[$key]]);
                $filegambar['gambar'] = $arr;
            }
        }else {
            $filegambar['gambar'] = null;
        }
        if ($request->hasFile('filevideo')) {
            $filevideo = [];
            $arr = [];
            foreach ($request->filevideo as $key => $g) {
                $path = $g->store('uploads/bukti_tayang');
                array_push($arr, ['filename'=>$path, 'description'=>$request->descvideo[$key]]);
                $filevideo['video'] = $arr;
            }
        }else {
            $filevideo['video'] = null;
        }
        if ($request->hasFile('filezip')) {
            $filezip = [];
            $arr = [];
            foreach ($request->filezip as $key => $g) {
                $path = $g->store('uploads/bukti_tayang');
                array_push($arr, ['filename'=>$path, 'description'=>$request->desczip[$key]]);
                $filezip['zip'] = $arr;
            }
        }else {
            $filezip['zip'] = null;
        }
        $result = array_merge($filegambar, $filevideo, $filezip);
        $evidence = New Evidence;
        if ($evidence) {
            $evidence->order_id = $request->order_id;
            $evidence->order_detail_id = $request->order_detail_id;
            $order_detail = OrderDetail::where('id', $request->order_detail_id)->first();
            if ($order_detail != null) {
                $order_detail->status_tayang = 1;
                $order_detail->updated_at = time();
                $order_detail->save();
            }
            $evidence->no_bukti = $request->no_bukti;
            $evidence->no_order = $request->no_order;
            $evidence->file = json_encode($result);
            $evidence->status = 1;
            $evidence->save();
            flash('Evidences success')->success();
        }else{
            flash('Someting Wrong!')->error();
        }

        return back();
        
    }

    public function broadcast_customer()
    {
        $orderDetail = DB::table('orders as o')
                            ->join('order_details as od', 'o.id', '=', 'od.order_id')
                            ->join('products as p', 'od.product_id', '=', 'p.id')
                            ->join('users as s', 'od.seller_id', '=', 's.id')
                            ->where('o.user_id', Auth::user()->id)
                            ->orderBy('o.id', 'DESC')
                            ->select([
                                'p.name',
                                'od.id as od_id',
                                'od.variation',
                                'od.complete',
                                'od.status_tayang',
                                's.name as seller_name'
                            ])
                            ->get();
    
        return view('frontend.evidence.bukti_tayang_customer', compact('orderDetail'));
    }

    public function broadcast_details(Request $request)
    {
        $data = DB::table('order_details as od')
                    ->join('evidences as e', 'e.order_detail_id', '=', 'od.id')
                    ->join('products as p', 'p.id', '=', 'od.product_id')
                    ->join('users as s', 's.id', '=', 'od.seller_id')
                    ->select([
                        'e.no_bukti',
                        'e.no_order',
                        'e.file',
                        'p.name as product_name',
                        's.name as seller_name'
                    ])
                    ->where('od.id', $request->order_detail_id)
                    ->first();
        return view('frontend.partials.broadcast_galery', compact('data'));
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
