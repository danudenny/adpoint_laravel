@extends('frontend.layouts.app')

@section('content')

    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @include('frontend.inc.seller_side_nav')
                </div>

                <div class="col-lg-9">
                    <!-- Page title -->
                    <div class="page-title">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                    {{__('Dashboard')}}
                                </h2>
                            </div>
                            <div class="col-md-6">
                                <div class="float-md-right">
                                    <ul class="breadcrumb">
                                        <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                        <li class="active"><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- dashboard content -->
                    <div class="">
                        <div class="row">
                            <div class="col-md-4 col-6">
                                <div class="dashboard-widget text-center green-widget mt-4 c-pointer">
                                    <a href="javascript:;" class="d-block">
                                        <img src="{{ asset('frontend/images/icons/billboard.png') }}" alt="">
                                        <span class="d-block title heading-6 strong-400">{{ count(\App\Product::where('user_id', Auth::user()->id)->get()) }}</span>
                                        <span class="d-block sub-title">{{__('Products')}}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="dashboard-widget text-center red-widget mt-4 c-pointer">
                                    <a href="javascript:;" class="d-block">
                                        <img src="{{ asset('frontend/images/icons/total-sales.png') }}" alt="">
                                        <span class="d-block title heading-6 strong-400">{{ count(\App\OrderDetail::where('seller_id', Auth::user()->id)->where(['status'=>3,'status'=>4])->get()) }}</span>
                                        <span class="d-block sub-title">{{__('Total Sales')}}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="dashboard-widget text-center blue-widget mt-4 c-pointer">
                                    <a href="javascript:;" class="d-block">
                                        <img src="{{ asset('frontend/images/icons/payroll.png') }}" alt="">
                                        @php
                                            $orders = \App\Order::where('seller_id', Auth::user()->id)->get();
                                            $total = 0;
                                            foreach ($orders as $key => $o) {
                                                if($o->approved == 1){
                                                    $total += $o->grand_total-$o->adpoint_earning;
                                                }
                                            }
                                        @endphp
                                        <span class="d-block title heading-6 strong-400">{{ single_price($total) }}</span>
                                        <span class="d-block sub-title">{{__('Total earnings')}}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-box bg-white mt-4">
                                    <div class="form-box-title px-3 py-2 text-center">
                                        {{__('Incoming Orders')}}
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-6">
                                            <div class="dashboard-widget text-center green-widget mt-4 c-pointer">
                                                <a href="javascript:;" class="d-block">
                                                    <img src="{{ asset('frontend/images/icons/purchase-order.png') }}" alt="">
                                                    <span class="d-block title heading-6 strong-400">{{ count(\App\OrderDetail::where('seller_id', Auth::user()->id)->get()) }}</span>
                                                    <span class="d-block sub-title">{{__('Total Orders')}}</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="dashboard-widget text-center red-widget mt-4 c-pointer">
                                                <a href="javascript:;" class="d-block">
                                                    <img src="{{ asset('frontend/images/icons/data-pending.png') }}" alt="">
                                                    <span class="d-block title heading-6 strong-400">{{ count(\App\OrderDetail::where('seller_id', Auth::user()->id)->where('status', 100)->get()) }}</span>
                                                    <span class="d-block sub-title">{{__('Pending orders')}}</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="dashboard-widget text-center blue-widget mt-4 c-pointer">
                                                <a href="javascript:;" class="d-block">
                                                    <img src="{{ asset('frontend/images/icons/cancel-subscription.png') }}" alt="">
                                                    <span class="d-block title heading-6 strong-400">{{ count(\App\OrderDetail::where('seller_id', Auth::user()->id)->where('status', 100)->get()) }}</span>
                                                    <span class="d-block sub-title">{{__('Cancelled Orders')}}</span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6">
                                            <div class="dashboard-widget text-center yellow-widget mt-4 c-pointer">
                                                <a href="javascript:;" class="d-block">
                                                    <img src="{{ asset('frontend/images/icons/ok.png') }}" alt="">
                                                    <span class="d-block title heading-6 strong-400">{{ count(\App\OrderDetail::where('seller_id', Auth::user()->id)->where(['status'=>3,'status'=>4])->get()) }}</span>
                                                    <span class="d-block sub-title">{{__('Successful orders')}}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-box bg-white mt-4">
                                    <div class="form-box-title px-3 py-2 text-center">
                                        {{__('Products')}}
                                    </div>
                                    @php
                                        $prods = \App\Product::where('user_id', Auth::user()->id)->get();
                                    @endphp
                                    @if (count($prods) == 0)
                                    <div class="text-center mt-2">
                                        <img src="{{ asset('frontend/images/icons/error.png') }}" alt=""><br>
                                        <span>No Products Found</span>
                                    </div>
                                    @endif
                                    <div class="form-box-content p-3 category-widget">
                                        <ul class="clearfix">
                                            @foreach (\App\Category::all() as $key => $category)
                                                @if(count($category->products->where('user_id', Auth::user()->id))>0)
                                                    <li><a>{{ __($category->name) }}<span>({{ count($category->products->where('user_id', Auth::user()->id)) }})</span></a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        <div class="text-center">
                                            <a href="{{ route('seller.products.upload')}}" class="btn pt-3 pb-1"><i class="fa fa-plus-circle"></i> {{__('Add New Product')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2 text-center">
                                    {{__('Outgoing Orders & Transactions')}}
                                </div>
                                <div class="row">
                                    @php
                                        $totalbuyerorders = DB::table('orders as o')
                                                            -> join('order_details as od', 'o.id', '=', 'od.order_id')
                                                            -> where('o.user_id', Auth::user()->id)
                                                            ->get();
                                    @endphp
                                    <div class="col-md-6 col-12">
                                        <div class="dashboard-widget text-center third-widget mt-4 c-pointer">
                                            <a href="javascript:;" class="d-block">
                                                <img src="{{ asset('frontend/images/icons/bill.png') }}" alt="">
                                                <span class="d-block title heading-6 strong-400">{{ count($totalbuyerorders) }}</span>
                                                <span class="d-block sub-title">{{__('Total Orders')}}</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="dashboard-widget text-center fourth-widget mt-4 c-pointer">
                                            <a href="javascript:;" class="d-block">
                                                <img src="{{ asset('frontend/images/icons/transaction.png') }}" alt="">
                                                <span class="d-block title heading-6 strong-400">{{ count(\App\Transaction::where('user_id', Auth::user()->id)->get()) }}</span>
                                                <span class="d-block sub-title">{{__('Total Transactions')}}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
