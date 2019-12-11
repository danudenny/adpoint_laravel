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
                                        {{__('Upload Bukti Tayang')}}
                                    </h2>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li class="active"><a href="{{ route('bukti.tayang', encrypt($order_id)) }}">{{__('Bukti Tayang')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <!-- Order history table -->
                        <div class="card no-border mt-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        @foreach ($query as $key => $bukti)
                                            <div class="accordion">
                                                <div class="card">
                                                    <div class="card-header" id="headin{{ $key }}">
                                                        <strong class="mb-0">
                                                            @php
                                                                $nomor = strtotime(date('Ymd'))+$key;
                                                                $evidence = \App\Evidence::where('no_bukti', $order_id.'-'.$nomor)->first();    
                                                            @endphp
                                                            @if ($evidence != null)
                                                                @if ($evidence->status == 1)
                                                                    <a class="btn btn-info text-white" data-toggle="collapse" data-target="#collapseActive{{ $key }}" aria-expanded="true" aria-controls="collapseOne">
                                                                        {{ $bukti->name }}
                                                                    </a>
                                                                    <span class="pull-right">
                                                                        <img src="{{ url('img/label/activated.png') }}" alt="" width="65">
                                                                    </span>
                                                                @endif
                                                            @else
                                                            <a class="btn btn-info text-white" data-toggle="collapse" data-target="#collapse{{ $key }}" aria-expanded="true" aria-controls="collapseOne">
                                                            {{ $bukti->name }}
                                                            </a> 
                                                            <span class="pull-right">
                                                                <img src="{{ url('img/label/not_activated.png') }}" alt="" width="65">
                                                            </span>
                                                            @endif
                                                            
                                                        </strong>
                                                    </div>
                                                    
                                                    <div id="collapseActive{{ $key }}" class="collapse" aria-labelledby="headingActive{{ $key }}" data-parent="#accordion">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                   <div class="alert alert-success">
                                                                       <i class="fa fa-check"></i> Activated
                                                                   </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="collapse{{ $key }}" class="collapse" aria-labelledby="heading{{ $key }}" data-parent="#accordion">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <form action="{{ route('upload.bukti.tayang') }}" method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <label>No Bukti Tayang</label>
                                                                            <input type="hidden" name="order_id" value="{{ $order_id }}">
                                                                            <input type="text" value="{{ $order_id }}-{{ strtotime(date('Ymd'))+$key }}" name="no_bukti" class="form-control" readonly>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>No Order</label>
                                                                            <input type="text" value="{{ $bukti->code }}" name="no_order" class="form-control" readonly>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="row">
                                                                                <div class="col-md-5">
                                                                                    <label>Bukti Tayang</label>
                                                                                </div>
                                                                            </div>
                                                                            <input type="file" name="photos[]" id="photos-one-{{ $key }}" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" accept="image/*" />
                                                                            <label for="photos-one-{{ $key }}" class="mw-100 mb-3">
                                                                                <span></span>
                                                                                <strong>
                                                                                    <i class="fa fa-upload"></i>
                                                                                    {{__('Choose image')}}
                                                                                </strong>
                                                                            </label>

                                                                            <input type="file" name="photos[]" id="photos-two-{{ $key }}" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" accept="image/*" />
                                                                            <label for="photos-two-{{ $key }}" class="mw-100 mb-3">
                                                                                <span></span>
                                                                                <strong>
                                                                                    <i class="fa fa-upload"></i>
                                                                                    {{__('Choose image')}}
                                                                                </strong>
                                                                            </label>

                                                                            <input type="file" name="photos[]" id="photos-three-{{ $key }}" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" accept="image/*" />
                                                                            <label for="photos-three-{{ $key }}" class="mw-100 mb-3">
                                                                                <span></span>
                                                                                <strong>
                                                                                    <i class="fa fa-upload"></i>
                                                                                    {{__('Choose image')}}
                                                                                </strong>
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <button type="submit" class="btn btn-info">Submit Data</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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

@section('script')
    <script>
        
    </script>
@endsection


