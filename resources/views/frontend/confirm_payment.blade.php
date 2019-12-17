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
                                        {{__('Confirm Payment')}}
                                    </h2>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li class="active"><a href="{{ route('confirm.payment', encrypt($order_id)) }}">{{__('Confirm Payment')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                @if ($order[0]->status_confirm == 0)
                                <form action="{{ route('insert.confirm.payment') }}" method="POST" enctype="multipart/form-data">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    @csrf
                                                    <input type="hidden" name="order_id" value="{{ $order_id }}">
                                                    <div class="form-group">
                                                        <label>No Order</label>
                                                        <input type="text" class="form-control" name="no_order" readonly value="{{ $order[0]->code }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Nama</label>
                                                        <input type="text" class="form-control" name="nama" value="{{ $order[0]->buyer_name }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Nama Bank</label>
                                                        <select class="form-control selectpicker" name="nama_bank" ata-show-subtext="true" data-live-search="true">
                                                            @foreach (App\Bank::all() as $key => $b)
                                                                <option data-subtext="{{$b->name}}" value="{{ $b->name }}">{{ $b->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group{{ $errors->has('no_rek') ? 'has-error' : ''}}">
                                                        <label>No Rekening</label>
                                                        <input type="number" class="form-control" name="no_rek">
                                                        <strong class="text-danger mt-1">{!! $errors->first('no_rek', '<p class="help-block">:message</p>') !!}</strong>
                                                    </div>
                                                    <div class="form-group{{ $errors->has('bukti') ? 'has-error' : ''}}">
                                                        <label>Bukti Transfer</label>
                                                        <input type="file" class="form-control" name="bukti">
                                                        <strong class="text-danger mt-1">{!! $errors->first('bukti', '<p class="help-block">:message</p>') !!}</strong>
                                                    </div>
                                                    <button type="submit" class="btn btn-success btn-block">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @else 
                                <div class="card">
                                    <div class="card-body">
                                        <div class="alert alert-info">
                                            <h5><i class="fa fa-check-circle-o"></i> Anda telah melakukan konfirmasi pembayaran. <i><a href="{{ route('home') }}">Kembali</a></i></h5>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
