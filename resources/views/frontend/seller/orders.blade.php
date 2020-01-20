@extends('frontend.layouts.app')

@section('content')

    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @include('frontend.inc.seller_side_nav')
                </div>

                <div class="col-lg-9">
                    <div class="main-content">
                        <!-- Page title -->
                        <div class="page-title">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                        {{__('Orders')}}
                                    </h2>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li class="active"><a href="{{ route('orders.index') }}">{{__('Orders')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order history table -->
                        
                        <div class="card no-border mt-4">
                            <div class="card-body">
                               <div class="row">
                                   <div class="accordion col-md-12" id="accordionExample">
                                    @if (Session::has('message'))
                                        <div class="alert alert-success">
                                            {!! session('message') !!}
                                        </div>
                                    @endif
                                    <article class="card">
                                        @foreach ($orders as $no => $o)
                                            @if ($o->approved == 1)
                                                <header style="height: 50px; background: #0f355a; color: white; border-bottom: 2px solid #fd7e14" id="headingOne{{$no}}">
                                                    <div style="line-height: 50px; margin-left: 10px">
                                                        <div style="float: left">
                                                            <a style="cursor: pointer;" data-toggle="collapse" data-target="#collapseOne{{$no}}" aria-expanded="true" aria-controls="collapseOne{{$no}}">
                                                                Order ID: <b>{{ $o->code }}</b> |  <i>{{ date('d M Y h:i:s', strtotime($o->created_at)) }}</i>
                                                            </a>
                                                        </div>
                                                        <div style="float: right; margin-right: 10px;">
                                                            {{-- <a class="btn btn-success btn-sm" href="{{ route('approved.all.by.seller', encrypt($o->id)) }}">Approve All</a> --}}
                                                        </div>
                                                    </div>
                                                </header>
                                                <div id="collapseOne{{$no}}" class="collapse show" aria-labelledby="headingOne{{$no}}" data-parent="#accordionExample">
                                                    
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            @php
                                                                $order_details = \App\OrderDetail::where('order_id',$o->id)->get();
                                                            @endphp
                                                            @foreach ($order_details as $key => $od)
                                                                @php
                                                                    $product = \App\Product::where('id', $od->product_id)->first();
                                                                @endphp
                                                                <tr>
                                                                    <td>
                                                                        <img src="{{ url(json_decode($product->photos)[0]) }}" class="img-fluid" width="50">
                                                                    </td>
                                                                    <td>
                                                                        <a target="_blank" href="{{ route('product', $product->slug) }}">{{ $product->name }}</a>
                                                                        <br>
                                                                        {{ $od->variation }} 
                                                                        <small class="text-info text-bold">
                                                                            ( {{ date('d M Y', strtotime($od->start_date)) }} - {{ date('d M Y', strtotime($od->end_date)) }} )
                                                                        </small> 
                                                                    </td>
                                                                    <td>
                                                                        Price: <br>
                                                                        <b>{{ single_price($od->price) }}</b>
                                                                    </td>
                                                                    <td>
                                                                        Qty: <br>
                                                                        <div class="badge badge-info">{{ $od->quantity }}</div>
                                                                    </td>
                                                                    <td>
                                                                        Total: <br>
                                                                        @php
                                                                            $total = $od->price * $od->quantity;
                                                                        @endphp
                                                                        <b>{{ single_price($total) }}</b>
                                                                    </td>
                                                                    <td>
                                                                        @if ($od->status === 1)
                                                                            <div class="badge badge-success">Approved</div>
                                                                        @elseif($od->status === 2)
                                                                            <div class="badge badge-danger">Rejected</div>
                                                                        @else 
                                                                        <a href="{{ route('approve.by.seller', encrypt($od->id)) }}" data-toggle="tooltip" data-placement="top" title="Approve" class="btn btn-sm btn-success">
                                                                            <i class="fa fa-check"></i>
                                                                        </a>
                                                                        <a data-toggle="modal" data-target="#reject{{$od->id}}" style="cursor: pointer; color: white" class="btn btn-sm btn-danger">
                                                                            <i class="fa fa-times"></i>
                                                                        </a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <div class="modal fade" id="reject{{ $od->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLongTitle">Reject item {{ $product->name }}</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <form action="{{ route('disapprove.by.seller') }}" method="POST">
                                                                            <div class="modal-body">
                                                                                <div class="form-group">
                                                                                    @csrf
                                                                                    <input type="hidden" name="od_id" value="{{$od->id}}">
                                                                                    <label>Alasan</label>
                                                                                    <textarea name="alasan" class="form-control" placeholder="Tuliskan alasan" cols="20" rows="5"></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            @endforeach
                                                        </table>
                                                    </div> <!-- table-responsive .end// -->
                                                </div>
                                            @else
                                                <h5 class="text-center">Nothing!</h5>
                                            @endif
                                        @endforeach
                                    </article> <!-- order-group.// --> 
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