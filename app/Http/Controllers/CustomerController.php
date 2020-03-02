<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\User;
use App\Order;
use Mail;
use App\Mail\User\AcceptUser;
use App\Mail\User\RejectUser;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = User::where('user_type','seller')->orWhere('user_type','customer')->orderBy('created_at', 'desc')->get();
        return view('customers.index', compact('customers'));
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

    }

    public function showCustomer(Request $request)
    {
        $id = $request->id;
        $customer = User::where('id',$id)->get();
        return $customer;
    }

    public function accept(Request $request)
    {
        $id = $request->id;
        $customer = User::findOrFail($id);
        $customer->verified = 1;
        $customer->is_rejected = 0;
        if ($customer->save()) {
            Mail::to($customer->email)->queue(new AcceptUser($customer));
            return redirect()->route('customers.index');
        }
    }

    public function reject(Request $request)
    {
        $id = $request->id;
        $customer = User::findOrFail($id);
        $customer->verified = 0;
        $customer->is_rejected = 1;
        if ($customer->save()) {
            Mail::to($customer->email)->queue(new RejectUser($customer));
            return redirect()->route('customers.index');
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
        Order::where('user_id', Customer::findOrFail($id)->user->id)->delete();
        User::destroy(Customer::findOrFail($id)->user->id);
        if(Customer::destroy($id)){
            flash(__('Customer has been deleted successfully'))->success();
            return redirect()->route('customers.index');
        }

        flash(__('Something went wrong'))->error();
        return back();
    }

}
