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
                                        {{__('Purchase History')}}
                                    </h2>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li class="active"><a href="{{ route('purchase_history.index') }}">{{__('Purchase History')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="card no-border mt-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div>
                                            <table class="table table-sm table-hover table-responsive-md" id="table">
                                                <thead>
                                                    <tr>
                                                        <th>{{__('Order No.')}}</th>
                                                        <th>{{__('Date')}}</th>
                                                        <th>{{__('Amount')}}</th>
                                                        <th>{{__('Order Status')}}</th>
                                                        <th>{{__('Payment Status')}}</th>
                                                        <th>{{__('Options')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($orders as $key => $order)
                                                        <tr>
                                                            <td>
                                                                <a href="#{{ $order->code }}" onclick="show_purchase_history_details({{ $order->id }})">{{ $order->code }}</a>
                                                                {{-- <a href="{{ route('my.order', encrypt($order->id)) }}">{{ $order->code }}</a> --}}
                                                            </td>
                                                            <td>{{ date('d M Y', $order->date) }}</td>
                                                            <td>
                                                                {{ single_price($order->grand_total) }}
                                                            </td>
                                                            <td>
                                                                @if ($order->status_order == 0)
                                                                    <span class="badge badge-warning">Disapproved</span>
                                                                @elseif ($order->status_order == 1)
                                                                    <span class="badge badge-secondary">Reviewed</span>
                                                                @elseif ($order->status_order == 2)
                                                                    <span class="badge badge-primary">Approved</span>
                                                                @elseif ($order->status_order == 3)
                                                                    <span class="badge badge-warning">Disapproved</span>
                                                                @elseif ($order->status_order == 4)
                                                                    <span class="badge badge-info">Aired</span>
                                                                @elseif ($order->status_order == 5)
                                                                    <span class="badge badge-success">Complete</span>
                                                                @elseif ($order->status_order == 6)
                                                                    <span class="badge badge-danger">Cancelled</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span class="badge badge--2 mr-4">
                                                                    @if ($order->payment_status == 'paid')
                                                                        <i class="bg-green"></i> {{__('Paid')}}
                                                                    @else
                                                                        <i class="bg-red"></i> {{__('Unpaid')}}
                                                                    @endif
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <button class="btn" type="button" id="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <i class="fa fa-ellipsis-v"></i>
                                                                    </button>
        
                                                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="">
                                                                        <button onclick="show_purchase_history_details({{ $order->id }})" class="dropdown-item">{{__('Order Details')}}</button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <div class="pagination-wrapper py-4">
                            <ul class="pagination justify-content-end">
                                {{ $orders->links() }}
                            </ul>
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
