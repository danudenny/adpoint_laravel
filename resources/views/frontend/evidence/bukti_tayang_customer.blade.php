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
                                    {{__('Bukti Tayang')}}
                                </h2>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="float-md-right">
                                    <ul class="breadcrumb">
                                        <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                        <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                        <li class="active"><a href="{{ route('broadcast.index') }}">{{__('Bukti Tayang')}}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card no-border mt-4">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-4 col-md-5">
                                        <div class="sort-by-box">
                                            <div class="form-group">
                                                <label>{{__('Search')}}</label>
                                                <div class="search-widget">
                                                    <input class="form-control input-lg" type="text" name="q" placeholder="{{__('Search')}}">
                                                    <button type="submit" class="btn-inner">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7 offset-lg-1">
                                        <div class="row no-gutters">
                                            <div class="col-6">
                                                <div class="sort-by-box px-1">
                                                    <div class="form-group">
                                                        <label>{{__('Status')}}</label>
                                                        <select class="form-control sortSelect" data-placeholder="{{__('All Seller')}}">
                                                            <option value="">{{__('All Sellers')}}</option>
                                                            @foreach (\App\Seller::all() as $key => $seller)
                                                                <option value="{{ $seller->id }}">{{ $seller->user->shop->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="sort-by-box px-1">
                                                    <div class="form-group">
                                                        <label>{{__('Status')}}</label>
                                                        <select class="form-control sortSelect" data-placeholder="{{__('Status')}}">
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    @foreach ($orderDetail as $key => $od)
                                        <div class="col-md-4">
                                            @if ($od->status_tayang == 1)
                                                <div class="card border-success mb-3" style="max-width: 18rem;">
                                                    <div class="card-body">
                                                        <h6 class="card-title">{{ substr($od->name,0,15) }}</h6>
                                                        <span class="badge badge-success"><i class="fa fa-check"></i> Active</span>
                                                        <p class="text-bold strong-600">{{ $od->seller_name }}</p>
                                                        <button onclick="showGaleriModal({{ $od->od_id }})" class="btn btn-block btn-primary"><i class="fa fa-eye"></i> Lihat</button>
                                                    </div>
                                                </div>
                                            @else 
                                                <div class="card border-danger mb-3" style="max-width: 18rem;">
                                                    <div class="card-body">
                                                        <h6 class="card-title">{{ substr($od->name,0,15) }}</h6>
                                                        <span class="badge badge-danger"><i class="fa fa-times-circle"></i> Not Active</span>
                                                        <p class="text-bold strong-600">{{ $od->seller_name }}</p>
                                                        <button style="cursor: not-allowed" disabled="disabled" class="btn btn-block btn-default"><i class="fa fa-eye-slash"></i></button>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
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
@endsection