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
                                        {{__('Transaction')}}
                                    </h2>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li class="active"><a href="{{ route('trx.page.buyer') }}">{{__('Transaction')}}</a></li>
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
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-unpaid-tab" data-toggle="tab" href="#nav-unpaid" role="tab" aria-controls="nav-unpaid" aria-selected="true">Unpaid</a>
                                    <a class="nav-item nav-link" id="nav-paid-tab" data-toggle="tab" href="#nav-paid" role="tab" aria-controls="nav-paid" aria-selected="false">Paid</a>
                                    </div>
                                </nav>
                                <div class="tab-content mt-2" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-unpaid" role="tabpanel" aria-labelledby="nav-unpaid-tab">
                                        <div class="row">
                                            <div class="accordion col-md-12" id="accordionExample">
                                                <article class="card">
                                                    @foreach ($trx as $no => $t)
                                                        @if ($t->payment_status == 0)
                                                        <header style="height: 50px; background: #0f355a; color: white; border-bottom: 2px solid #fd7e14" id="headingOne{{$no}}">
                                                            <a style="cursor: pointer; line-height: 50px; margin-left: 15px" data-toggle="collapse" data-target="#collapseOne{{$no}}" aria-expanded="true" aria-controls="collapseOne{{$no}}">
                                                                Transaction ID: <b>{{ $t->code }}</b> |  <i>{{ date('d M Y h:i:s', strtotime($t->created_at)) }}</i>
                                                            </a>
                                                        </header>
                                                        <div id="collapseOne{{$no}}" class="collapse show" aria-labelledby="headingOne{{$no}}" data-parent="#accordionExample">
                                                            
                                                            <div class="table-responsive">
                                                                <table class="table table-hover">
                                                                    @php
                                                                        $list_order = \App\Order::where(['transaction_id' => $t->id])->get();
                                                                    @endphp
                                                                    @foreach ($list_order as $key => $lo)
                                                                        <tr>
                                                                            <td>
                                                                                {{ $key+1 }}
                                                                            </td>
                                                                            <td> 
                                                                                <p class="title mb-0">Order code: {{ $lo->code }}</p>
                                                                                <var class="price text-muted">Subtotal: Rp. {{ number_format($lo->grand_total,2,",",".") }}</var>
                                                                            </td>
                                                                            <td>
                                                                                Order Status:
                                                                                <br> 
                                                                                @if ($lo->status_order == 0)
                                                                                    <span class="badge badge-warning">Pending</span>
                                                                                @elseif ($lo->status_order == 1)
                                                                                    <span class="badge badge-secondary">Reviewed</span>
                                                                                @elseif ($lo->status_order == 2)
                                                                                    <span class="badge badge-primary">Approved</span>
                                                                                @elseif ($lo->status_order == 3)
                                                                                    <span class="badge badge-warning">Disapproved</span>
                                                                                @elseif ($lo->status_order == 4)
                                                                                    <span class="badge badge-info">Aired</span>
                                                                                @elseif ($lo->status_order == 5)
                                                                                    <span class="badge badge-success">Complete</span>
                                                                                @elseif ($lo->status_order == 6)
                                                                                    <span class="badge badge-danger">Cancelled</span>
                                                                                @endif
                                                                            </td>
                                                                            <td align="right">
                                                                                <a href="#" class="btn btn-outline-primary">Details</a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </table>
                                                            </div> <!-- table-responsive .end// -->
                                                        </div> 
                                                        @endif
                                                    @endforeach
                                                </article>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-paid" role="tabpanel" aria-labelledby="nav-paid-tab">
                                        <div class="row">
                                            <div class="accordion col-md-12" id="accordionExample">
                                                <article class="card">
                                                    @foreach ($trx as $no => $t)
                                                        @if ($t->payment_status == 1)
                                                        <header style="height: 50px; background: #0f355a; color: white; border-bottom: 2px solid #fd7e14" id="headingOne{{$no}}">
                                                            <a style="cursor: pointer; line-height: 50px; margin-left: 15px" data-toggle="collapse" data-target="#collapseOne{{$no}}" aria-expanded="true" aria-controls="collapseOne{{$no}}">
                                                                Transaction ID: <b>{{ $t->code }}</b> |  <i>{{ date('d M Y h:i:s', strtotime($t->created_at)) }}</i>
                                                            </a>
                                                        </header>
                                                        <div id="collapseOne{{$no}}" class="collapse show" aria-labelledby="headingOne{{$no}}" data-parent="#accordionExample">
                                                            
                                                            <div class="table-responsive">
                                                                <table class="table table-hover">
                                                                    @php
                                                                        $list_order = \App\Order::where(['transaction_id' => $t->id])->get();
                                                                    @endphp
                                                                    @foreach ($list_order as $key => $lo)
                                                                        <tr>
                                                                            <td>
                                                                                {{ $key+1 }}
                                                                            </td>
                                                                            <td> 
                                                                                <p class="title mb-0">Order code: {{ $lo->code }}</p>
                                                                                <var class="price text-muted">Subtotal: Rp. {{ number_format($lo->grand_total,2,",",".") }}</var>
                                                                            </td>
                                                                            <td>
                                                                                Order Status:
                                                                                <br> 
                                                                                @if ($lo->status_order == 0)
                                                                                    <span class="badge badge-warning">Pending</span>
                                                                                @elseif ($lo->status_order == 1)
                                                                                    <span class="badge badge-secondary">Reviewed</span>
                                                                                @elseif ($lo->status_order == 2)
                                                                                    <span class="badge badge-primary">Approved</span>
                                                                                @elseif ($lo->status_order == 3)
                                                                                    <span class="badge badge-warning">Disapproved</span>
                                                                                @elseif ($lo->status_order == 4)
                                                                                    <span class="badge badge-info">Aired</span>
                                                                                @elseif ($lo->status_order == 5)
                                                                                    <span class="badge badge-success">Complete</span>
                                                                                @elseif ($lo->status_order == 6)
                                                                                    <span class="badge badge-danger">Cancelled</span>
                                                                                @endif
                                                                            </td>
                                                                            <td align="right">
                                                                                <a href="#" class="btn btn-outline-primary">Details</a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </table>
                                                            </div> <!-- table-responsive .end// -->
                                                        </div> 
                                                        @endif
                                                    @endforeach
                                                </article>
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
