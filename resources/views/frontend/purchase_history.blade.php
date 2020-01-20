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
                                            <li class="active"><a href="{{ route('purchase_history.index') }}">{{__('My Order')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (Session::has('message'))
                            <div class="alert alert-success">
                                {!! session('message') !!}
                            </div>
                        @endif
                        
                        <div class="card no-border mt-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="startDate" placeholder="Start">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="endDate" placeholder="End">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control selectpicker">
                                            <option value="latest">Latest</option>
                                            <option value="old">Old</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button class="btn btn-danger">Reset Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="card no-border mt-2">
                            <div class="card-body">
                                <nav class="no-border" style="color: black">
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-order-place-tab" data-toggle="tab" href="#nav-order-place" role="tab" aria-controls="nav-order-place" aria-selected="true">Order place</a>
                                    <a class="nav-item nav-link" id="nav-onreview-tab" data-toggle="tab" href="#nav-onreview" role="tab" aria-controls="nav-onreview" aria-selected="false">On review</a>
                                    <a class="nav-item nav-link" id="nav-active-tab" data-toggle="tab" href="#nav-active" role="tab" aria-controls="nav-active" aria-selected="false">Active</a>
                                    <a class="nav-item nav-link" id="nav-complete-tab" data-toggle="tab" href="#nav-complete" role="tab" aria-controls="nav-complete" aria-selected="false">Complete</a>
                                    <a class="nav-item nav-link" id="nav-cancel-tab" data-toggle="tab" href="#nav-cancel" role="tab" aria-controls="nav-cancel" aria-selected="false">Cancelled</a>
                                    </div>
                                </nav>
                            </div>
                        </div>

                        <div class="card no-border mt-1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-order-place" role="tabpanel" aria-labelledby="nav-order-place-tab">
                                                @foreach ($order_details as $key => $od)
                                                    @if ($od->status === 0)
                                                        <article class="card mt-3">
                                                            <div style="height: 35px; background: #0f355a; color: white; border-bottom: 2px solid #fd7e14">
                                                                <strong style="line-height: 35px; margin-left: 15px">{{ $od->created_at }}</strong>
                                                            </div>
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    @php
                                                                        $product = \App\Product::where('id', $od->product_id)->first();
                                                                    @endphp
                                                                    <tr>
                                                                        <td width="80">
                                                                            <img src="{{ url(json_decode($product->photos)[0]) }}" class="img-fluid" width="50">
                                                                        </td>
                                                                        <td width="250"> 
                                                                            {{ $product->name }} <br>
                                                                            {{ $od->variation }} 
                                                                            <small>
                                                                                ( {{ date('d M Y', strtotime($od->start_date)) }} - {{ date('d M Y', strtotime($od->end_date)) }} )
                                                                            </small>
                                                                        </td>
                                                                        <td width="200">
                                                                            QTY: {{ $od->quantity }} <br>
                                                                            {{ single_price($od->price) }}
                                                                        </td>
                                                                        <td>
                                                                            Status: 
                                                                            @if ($od->status === 0)
                                                                                <div class="badge badge-warning">
                                                                                    Placed
                                                                                </div>
                                                                            @endif
                                                                        </td>
                                                                        <td align="right">
                                                                            <a href="#" class="btn btn-light"><i class="fa fa-eye"></i> Details</a> 
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </article>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="tab-pane fade" id="nav-onreview" role="tabpanel" aria-labelledby="nav-onreview-tab">
                                                @foreach ($order_details as $key => $od)
                                                    @if ($od->status === 1)
                                                        <article class="card mt-3">
                                                            <div style="height: 35px; background: #0f355a; color: white; border-bottom: 2px solid #fd7e14">
                                                                <strong style="line-height: 35px; margin-left: 15px">{{ $od->created_at }}</strong>
                                                            </div>
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    @php
                                                                        $product = \App\Product::where('id', $od->product_id)->first();
                                                                    @endphp
                                                                    <tr>
                                                                        <td width="80">
                                                                            <img src="{{ url(json_decode($product->photos)[0]) }}" class="img-fluid" width="50">
                                                                        </td>
                                                                        <td width="250"> 
                                                                            {{ $product->name }} <br>
                                                                            {{ $od->variation }} 
                                                                            <small>
                                                                                ( {{ date('d M Y', strtotime($od->start_date)) }} - {{ date('d M Y', strtotime($od->end_date)) }} )
                                                                            </small>
                                                                        </td>
                                                                        <td width="200">
                                                                            QTY: {{ $od->quantity }} <br>
                                                                            {{ single_price($od->price) }}
                                                                        </td>
                                                                        <td>
                                                                            Status: 
                                                                            @if ($od->status === 1)
                                                                                <div class="badge badge-secondary">
                                                                                    On Review
                                                                                </div>
                                                                            @endif
                                                                        </td>
                                                                        <td align="right">
                                                                            <a href="#" class="btn btn-light"><i class="fa fa-eye"></i> Details</a> 
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </article>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="tab-pane fade" id="nav-active" role="tabpanel" aria-labelledby="nav-active-tab">
                                                <h1>Active</h1>
                                            </div>
                                            <div class="tab-pane fade" id="nav-complete" role="tabpanel" aria-labelledby="nav-complete-tab">
                                                <h1>Active</h1>
                                            </div>
                                            <div class="tab-pane fade" id="nav-cancel" role="tabpanel" aria-labelledby="nav-cancel-tab">
                                                @foreach ($order_details as $key => $od)
                                                    @if ($od->status === 100)
                                                        <article class="card mt-3">
                                                            <div style="height: 35px; background: #0f355a; color: white; border-bottom: 2px solid #fd7e14">
                                                                <strong style="line-height: 35px; margin-left: 15px">{{ $od->created_at }}</strong>
                                                            </div>
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    @php
                                                                        $product = \App\Product::where('id', $od->product_id)->first();
                                                                    @endphp
                                                                    <tr>
                                                                        <td width="80">
                                                                            <img src="{{ url(json_decode($product->photos)[0]) }}" class="img-fluid" width="50">
                                                                        </td>
                                                                        <td width="250"> 
                                                                            {{ $product->name }} <br>
                                                                            {{ $od->variation }} 
                                                                            <small>
                                                                                ( {{ date('d M Y', strtotime($od->start_date)) }} - {{ date('d M Y', strtotime($od->end_date)) }} )
                                                                            </small>
                                                                        </td>
                                                                        <td width="200">
                                                                            QTY: {{ $od->quantity }} <br>
                                                                            {{ single_price($od->price) }}
                                                                        </td>
                                                                        <td>
                                                                            Status: 
                                                                            @if ($od->status === 100)
                                                                                <div class="badge badge-danger">
                                                                                    Rejected
                                                                                </div>
                                                                            @endif
                                                                        </td>
                                                                        <td align="right">
                                                                            <a href="#" class="btn btn-light"><i class="fa fa-eye"></i> Details</a> 
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </article>
                                                    @endif
                                                @endforeach
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

    <div class="modal fade" id="order_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="c-preloader">
                    <i class="fa fa-spin fa-spinner"></i>
                </div>
                <div id="order-details-modal-body">

                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('#startDate').datepicker({
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            minDate: today,
            format: 'dd mmm yyyy',
            maxDate: function () {
                return $('#endDate').val();
            }
        });
        $('#endDate').datepicker({
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            format: 'dd mmm yyyy',
            minDate: function () {
                return $('#startDate').val();
            }
        });
    </script>
@endsection
