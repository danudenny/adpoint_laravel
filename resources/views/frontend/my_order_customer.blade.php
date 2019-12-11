@extends('frontend.layouts.app')

@section('content')
    
    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @if(Auth::user()->user_type == 'seller')
                        @include('frontend.inc.seller_side_nav')
                    @elseif(Auth::user()->user_type == 'customer')
                        @include('frontend.inc.customer_side_nav')
                    @endif
                </div>

                <div class="col-lg-9">
                    <div class="main-content">
                        <!-- Page title -->
                        <div class="page-title">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12">
                                    <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                        {{__('My Order')}}
                                    </h2>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li class="active"><a href="{{ route('my.order', encrypt($order_id)) }}">{{__('My Order')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist" >
                                    <li class="nav-item">
                                        <a class="nav-link active" id="order-placed-tab" data-toggle="tab" href="#order-placed" role="tab" aria-controls="order-placed" aria-selected="true">Order Placed</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="on-review-tab" data-toggle="tab" href="#on-review" role="tab" aria-controls="on-review" aria-selected="false">On Review</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="active-tab" data-toggle="tab" href="#active" role="tab" aria-controls="active" aria-selected="false">Active</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="completed-tab" data-toggle="tab" href="#completed" role="tab" aria-controls="completed" aria-selected="false">Completed</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="canceled-tab" data-toggle="tab" href="#canceled" role="tab" aria-controls="canceled" aria-selected="false">Cancelled</a>
                                    </li>
                                </ul>
                                <div class="tab-content mt-3" id="myTabContent">
                                    <div class="tab-pane fade show active" id="order-placed" role="tabpanel" aria-labelledby="order-placed-tab">
                                        <div id="accordion">
                                            <div class="card">
                                                <div class="card-header bg-white" id="headingOne">
                                                    <a class="btn" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        <strong>#{{ $order[0]->code }}</strong>
                                                    </a>
                                                </div>
                                            
                                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="container">
                                                        <div class="row">
                                                            <table>
                                                                @foreach ($order as $od)
                                                                    <tr>
                                                                        <tr>
                                                                            <td>Name:</td>
                                                                            <td><b>{{ $od->name }}</b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Harga:</td>
                                                                            <td><b>Rp {{ number_format($od->price) }}</b></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Durasi:</td>
                                                                            <td><b>{{ $od->quantity }} {{ $od->variation }} ( {{ date('d M Y', strtotime($od->start_date)) }} - {{ date('d M Y', strtotime($od->end_date)) }} )</b></td>
                                                                        </tr>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><br></td>
                                                                    </tr>
                                                                @endforeach
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="on-review" role="tabpanel" aria-labelledby="on-review-tab">
                                        <h1>On Review</h1>
                                    </div>
                                    <div class="tab-pane fade" id="active" role="tabpanel" aria-labelledby="active-tab">
                                        <h1>Active</h1>
                                    </div>
                                    <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                                        <h1>Completed</h1>
                                    </div>
                                    <div class="tab-pane fade" id="canceled" role="tabpanel" aria-labelledby="canceled-tab">
                                        <h1>Canceled</h1>
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