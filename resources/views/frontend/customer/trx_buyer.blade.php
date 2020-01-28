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
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group mb-3">
                                        <input type="text" class="form-control" placeholder="Type transaction number" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <button class="btn btn-secondary" type="button"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
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
                                        @foreach ($trx as $no => $t)
                                            @if ($t->payment_status == 0)
                                            <div class="card" style="background: #fff; 
                                                                    color: black; border-radius: 0%; 
                                                                    border-bottom: 1px solid #fd7e14; 
                                                                    border-top: 0;
                                                                    border-left: 0;
                                                                    border-right: 0;">
                                                <div class="card-header">
                                                    Code: <b>{{ $t->code }}</b> | Order Date: <i class="fa fa-clock-o"></i> <i>{{ date('d M Y h:i:s', strtotime($t->created_at)) }}</i>
                                                    @if ($t->status === "confirmed")
                                                        <a href="{{ route('confirm.payment.id', encrypt($t->id)) }}" class="btn btn-sm btn-circle btn-outline-warning pull-right"><i class="fa fa-money"></i> Pay</a>
                                                    @endif
                                                    <button onclick="trxDetails({{ $t->id }})" class="btn btn-sm btn-circle btn-outline-info pull-right mr-2"><i class="fa fa-eye"></i> Details</button>
                                                    @if ($t->status === "confirmed")
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <div class="text-info">
                                                                    Silahkan melakukan pembayaran sebelum 12/08/2019 11:00:22
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="text-right">
                                                                    @if ($t->status === "paid" || $t->payment_status === 1)
                                                                        <span class="badge badge-danger">Waiting approval admin...</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="tab-pane fade" id="nav-paid" role="tabpanel" aria-labelledby="nav-paid-tab">
                                        @foreach ($trx as $no => $t)
                                            @if ($t->payment_status == 1)
                                                <div class="card" style="background: #fff; 
                                                                        color: black; border-radius: 0%; 
                                                                        border-bottom: 2px solid #fd7e14; 
                                                                        border-top: 0;
                                                                        border-left: 0;
                                                                        border-right: 0;">
                                                    <div class="card-header">
                                                        Code: <b>{{ $t->code }}</b> | Order Date: <i class="fa fa-clock-o"></i> <i>{{ date('d M Y h:i:s', strtotime($t->created_at)) }}</i>
                                                        @if ($t->status === "confirmed")
                                                            <a href="{{ route('confirm.payment.id', encrypt($t->id)) }}" class="btn btn-sm btn-circle btn-outline-warning pull-right">Confirm Payment</a>
                                                        @endif
                                                        <button onclick="trxDetails({{ $t->id }})" class="btn btn-sm btn-circle btn-outline-info pull-right"><i class="fa fa-eye"></i> Details</button>
                                                    </div>
                                                </div>
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
    </section>

    <div class="modal fade" id="trxDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="c-preloader">
                    <i class="fa fa-spin fa-spinner"></i>
                </div>
                <div id="trxDetails-body">

                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        function trxDetails(id) {
            $('#trxDetails-body').html(null);
            $('#trxDetails').modal();
            $('.c-preloader').show();
            $.post('{{ route('show.transaction.details') }}', {_token:'{{ csrf_token() }}', trx_id:id}, function(data){
                $('.c-preloader').hide();
                $('#trxDetails-body').html(data);
            });
        }
    </script>
@endsection
