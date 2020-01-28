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
                                        {{__('Pay')}}
                                    </h2>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li class="active"><a href="{{ route('confirm.payment') }}">{{__('Pay')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <form action="{{ route('insert.confirm.payment') }}" method="POST" enctype="multipart/form-data">
                                    <div class="card">
                                        <div class="card-body">
                                            @csrf
                                            <div class="form-group">
                                                <label>Code Transaction</label>
                                                <input type="text" class="form-control" name="trx_code" value="{{ $trx->code }}" readonly>
                                            </div>
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                            <div class="form-group">
                                                <label>Nama</label>
                                                <input type="text" class="form-control" id="name" name="nama" value="{{ Auth::user()->name }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Nama Bank</label>
                                                <select class="form-control selectpicker" name="nama_bank" data-show-subtext="true" data-live-search="true">
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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection