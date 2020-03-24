<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seller;
use App\User;
use App\Shop;
use App\Product;
use App\Order;
use App\OrderDetail;
use Illuminate\Support\Facades\Hash;

use DB;

use App\Pushy;
// Notif
use Notification;
use App\Notifications\ShopApprove;
use App\Events\ShopApproveEvent;
use App\Notifications\ShopReject;
use App\Events\ShopRejectEvent;

use Mail;
use App\Mail\Shop\ShopApproved;
use App\Mail\Shop\ShopRejected;



class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellers = Seller::orderBy('created_at', 'desc')->get();
        return view('sellers.index', [
            'sellers' => $sellers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sellers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(User::where('email', $request->email)->first() != null){
            flash(__('Email already exists!'))->error();
            return back();
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = "seller";
        $user->password = Hash::make($request->password);
        if($user->save()){
            $seller = new Seller;
            $seller->user_id = $user->id;
            if($seller->save()){
                $shop = new Shop;
                $shop->user_id = $user->id;
                $shop->slug = 'demo-shop-'.$user->id;
                $shop->save();
                flash(__('Seller has been inserted successfully'))->success();
                return redirect()->route('sellers.index');
            }
        }

        flash(__('Something went wrong'))->error();
        return back();
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
        $seller = Seller::findOrFail(decrypt($id));
        return view('sellers.edit', compact('seller'));
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
        $seller = Seller::findOrFail($id);
        $user = $seller->user;
        $user->name = $request->name;
        $user->email = $request->email;
        if(strlen($request->password) > 0){
            $user->password = Hash::make($request->password);
        }
        if($user->save()){
            if($seller->save()){
                flash(__('Seller has been updated successfully'))->success();
                return redirect()->route('sellers.index');
            }
        }

        flash(__('Something went wrong'))->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $seller = Seller::findOrFail($id);
        Shop::destroy($seller->user->id);
        Product::where('user_id', $seller->user->id)->delete();
        Order::where('user_id', $seller->user->id)->delete();
        OrderDetail::where('seller_id', $seller->user->id)->delete();
        User::destroy($seller->user->id);
        if(Seller::destroy($id)){
            flash(__('Seller has been deleted successfully'))->success();
            return redirect()->route('sellers.index');
        }

        flash(__('Something went wrong'))->error();
        return back();
    }

    public function show_verification_request($id)
    {
        $seller = Seller::findOrFail($id);
        return view('sellers.verification', compact('seller'));
    }

    public function show_details_seller($id)
    {
        $seller = Seller::findOrFail($id);
        return view('sellers.details', compact('seller'));
    }

    public function assign_seller_product()
    {
        $prod = Product::get();
        return view('sellers.assignproduct', compact('prod'));
    }

    public function approve_seller($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->verification_status = 1;
        if($seller->save()){
            $owner = User::where('id', $seller->user_id)->first();
            Mail::to($owner->email)->send(new ShopApproved($owner));

            // pushy notif
            $push = DB::table('pushy_tokens as pt')
                    ->join('users as u', 'u.id', '=', 'pt.user_id')
                    ->where(['u.id' => $owner->id])
                    ->select(['pt.*'])
                    ->first();
            if ($push !== null) {
                $tokenPushy = $push->device_token;
                $data = array('message' => 'Congratulations, your shop has been approved!');
                $to = array($tokenPushy);
                $options = array(
                    'notification' => array(
                        'badge' => 1,
                        'sound' => 'ping.aiff',
                        'body'  => "Congratulations, your shop has been approved!"
                    )
                );
                Pushy::sendPushNotification($data, $to, $options);
            }
            $seller_send = User::where('id', $seller->user_id)->first();
            Notification::send($seller_send, new ShopApprove());
            event(new ShopApproveEvent('Congratulations, your shop has been approved!'));
            flash(__('Seller has been approved successfully'))->success();
            return redirect()->route('sellers.index');
        }
        flash(__('Something went wrong'))->error();
        return back();
    }

    public function reject_seller($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->verification_status = 0;
        $seller->verification_info = null;
        if($seller->save()){
            $owner = User::where('id', $seller->user_id)->first();
            Mail::to($owner->email)->send(new ShopRejected($owner));

            // pushy notif
            $push = DB::table('pushy_tokens as pt')
                    ->join('users as u', 'u.id', '=', 'pt.user_id')
                    ->where(['u.id' => $owner->id])
                    ->select(['pt.*'])
                    ->first();
            if ($push !== null) {
                $tokenPushy = $push->device_token;
                $data = array('message' => 'Sorry, your registration as seller has been rejected!');
                $to = array($tokenPushy);
                $options = array(
                    'notification' => array(
                        'badge' => 1,
                        'sound' => 'ping.aiff',
                        'body'  => "Sorry, your registration as seller has been rejected!"
                    )
                );
                Pushy::sendPushNotification($data, $to, $options);
            }
            $seller_send = User::where('id', $seller->user_id)->first();
            Notification::send($seller_send, new ShopReject());
            event(new ShopRejectEvent('Sorry, your registration as seller has been rejected!'));
            flash(__('Seller verification request has been rejected successfully'))->success();
            return redirect()->route('sellers.index');
        }
        flash(__('Something went wrong'))->error();
        return back();
    }


    public function payment_modal(Request $request)
    {
        $seller = Seller::findOrFail($request->id);
        return view('sellers.payment_modal', compact('seller'));
    }
}
