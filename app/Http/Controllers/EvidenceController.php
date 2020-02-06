<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Evidence;
use App\User;
use App\OrderDetail;
use App\Order;
use Mail;
use App\Mail\Order\OrderBuktiTayang;

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
        if ($request->hasFile('image')) {
            $filegambar = [];
            $arr = [];
            foreach ($request->image as $key => $g) {
                $path = $g->store('uploads/bukti_tayang');
                array_push($arr, $path);
                $filegambar['gambar'] = $arr;
            }
        }else {
            $filegambar['gambar'] = null;
        }
        if ($request->hasFile('video')) {
            $filevideo = [];
            $arr = [];
            foreach ($request->video as $key => $g) {
                $path = $g->store('uploads/bukti_tayang');
                array_push($arr, $path);
                $filevideo['video'] = $arr;
            }
        }else {
            $filevideo['video'] = null;
        }

        $result = array_merge($filegambar, $filevideo);
        $query = DB::table('orders as o')
                ->join('order_details as od', 'od.order_id', '=', 'o.id')
                ->join('users as b', 'b.id', '=', 'o.user_id')
                ->join('products as p', 'p.id', '=', 'od.product_id')
                ->where('od.id', $request->order_detail_id)
                ->select([
                    'od.*',
                    'b.name as buyer_name',
                    'b.email as buyer_email',
                    'p.name as product_name',
                ])
                ->first();
        $evidence = New Evidence;
        if ($evidence) {
            $evidence->order_detail_id = $request->order_detail_id;
            $evidence->no_order = $request->order_id;
            $order_detail = OrderDetail::where('id', $request->order_detail_id)->first();
            if ($order_detail != null) {
                $order_detail->status = 3; // uploaded
                Mail::to($query->buyer_email)->send(new OrderBuktiTayang($query));
                $order_detail->save();
            }
            $evidence->no_bukti = $request->no_bukti;
            $evidence->no_order = $request->no_order;
            $evidence->file = json_encode($result);
            $evidence->status = 0;
            $evidence->save();
            flash('Bukti tayang uploaded!')->success();
            return back();
        }else{
            flash('Someting Wrong!')->error();
            return back();
        }
    }

    public function update_bukti_tayang(Request $request)
    {
        $evidence = Evidence::where('order_detail_id', $request->order_detail_id)->first();
        
        $file = json_decode($evidence->file);

        if ($request->hasFile('image')) {
            $arr = [];
            foreach ($request->image as $key => $g) {
                $path = $g->store('uploads/bukti_tayang');
                array_push($arr, $path);
                if ($file->gambar !== null) {
                    foreach ($file->gambar as $key => $a) {
                        array_push($arr, $a);
                    }
                }
            }
            $file->gambar = $arr;
        }
        if ($request->hasFile('video')) {
            $arr = [];
            foreach ($request->video as $key => $g) {
                $path = $g->store('uploads/bukti_tayang');
                array_push($arr, $path);
                if ($file->video !== null) {
                    foreach ($file->video as $key => $b) {
                        array_push($arr, $b);
                    }
                }
            }
            $file->video = $arr;
        }
        if ($evidence !== null) {
            $evidence->file = json_encode($file);
            $evidence->save();
            flash('Bukti tayang updated!')->success();
            return back();
        }else {
            flash('Someting Wrong!')->error();
            return back();
        }
    }

    public function delete_file_image(Request $request)
    {
        $evidence = Evidence::where('id', $request->id)->first();
        if ($evidence !== null) {
            $file = json_decode($evidence->file);
            foreach ($file->gambar as $key => $gambar) {
                if ($gambar === $request->val) {
                    unset($file->gambar[$key]);
                    unlink($request->val);
                }
            }
            $evidence->file = json_encode($file);
            $evidence->save();
        }
    }

    public function delete_file_video(Request $request)
    {
        $evidence = Evidence::where('id', $request->id)->first();
        if ($evidence !== null) {
            $file = json_decode($evidence->file);
            foreach ($file->video as $key => $video) {
                if ($video === $request->val) {
                    unset($file->video[$key]);
                    unlink($request->val);
                }
            }
            $evidence->file = json_encode($file);
            $evidence->save();
        }
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
