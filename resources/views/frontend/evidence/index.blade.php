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
                                    {{__('Broadcast Proof')}}
                                </h2>
                            </div>
                            <div class="col-md-6">
                                <div class="float-md-right">
                                    <ul class="breadcrumb">
                                        <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                        <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                        <li class="active"><a href="{{ route('broadcast_proof.index') }}">{{__('Broadcast Proof')}}</a></li>
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
                                    <div class="table-responsive">
                                        <table class="table table-bordered" style="width:100%" id="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Order Number</th>
                                                    <th>Status Order</th>
                                                    <th>Status Payment</th>
                                                    <th>Option</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $key => $o)
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ $o->code }}</td>
                                                        <td>
                                                            @if ($o->status_order == 0)
                                                                <span class="badge badge-warning">Disapproved</span>
                                                            @elseif ($o->status_order == 1)
                                                                <span class="badge badge-secondary">Reviewed</span>
                                                            @elseif ($o->status_order == 2)
                                                                <span class="badge badge-primary">Approved</span>
                                                            @elseif ($o->status_order == 3)
                                                                <span class="badge badge-warning">Disapproved</span>
                                                            @elseif ($o->status_order == 4)
                                                                <span class="badge badge-info">Aired</span>
                                                            @elseif ($o->status_order == 5)
                                                                <span class="badge badge-success">Complete</span>
                                                            @elseif ($o->status_order == 6)
                                                                <span class="badge badge-danger">Cancelled</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($o->payment_status == 'unpaid')
                                                                <span class="badge badge-danger">Unpaid</span>
                                                            @else 
                                                                <span class="badge badge-success">Paid</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($o->status_order == 4)
                                                                <button class="btn btn-sm btn-primary clickable" style="cursor: pointer" data-toggle="collapse" data-target="#group-of-rows-{{$key}}" aria-expanded="false" aria-controls="group-of-rows-{{$key}}">Lihat Detail</button>
                                                                {{-- <a href="{{ route('bukti.tayang', encrypt($o->id)) }}" class="btn btn-info btn-sm"><i class="fa fa-upload"></i> Bukti Tayang</a> --}}
                                                            @elseif ($o->status_order == 5)
                                                                <button class="btn btn-sm btn-success clickable" style="cursor: pointer" data-toggle="collapse" data-target="#group-of-rows-{{$key}}" aria-expanded="false" aria-controls="group-of-rows-{{$key}}">Selesai</button>
                                                            @elseif ($o->status_order == 2)
                                                                <a href="{{ route('aktifkan', encrypt($o->id)) }}" class="btn btn-info btn-sm text-white"  data-toggle="tooltip" data-placement="bottom" title="Aktifkan Untuk Upload Bukti Tayang"><i class="fa fa-check"></i> Aktifkan</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @php
                                                        $orderDetail = \App\OrderDetail::where('order_id', $o->id)->get();
                                                    @endphp
                                                    <tbody id="group-of-rows-{{$key}}" class="collapse">
                                                        <tr class="bg-dark">
                                                            <td>#</td>
                                                            <td>Product Name</td>
                                                            <td>Periode</td>
                                                            <td>Durasi</td>
                                                            <td>Status tayang</td>
                                                        </tr>
                                                        @foreach ($orderDetail as $key2 => $od)
                                                            <tr>
                                                                <td>-</td>
                                                                <td>{{ \App\Product::where('id',$od->product_id)->first()->name }}</td>
                                                                <td>{{ $od->variation }}</td>  
                                                                <td>{{ date('d M Y', strtotime($od->start_date)).' s/d '.date('d M Y', strtotime($od->end_date)) }}</td>
                                                                <td>
                                                                    @if ($od->status_tayang == 1)
                                                                        <div class="badge badge-info">Sudah diupload</div>
                                                                        <a href="{{ route('bukti.tayang', encrypt($o->id)) }}" href="#" class="card-link">Lihat</a>
                                                                    @else 
                                                                        <div class="badge badge-warning">Belum diupload</div>
                                                                        <a href="{{ route('bukti.tayang', encrypt($o->id)) }}" class="card-link">Upload</a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{-- @foreach ($orders as $key => $o)
                                        <div class="accordion" id="accordionExample{{$key}}">
                                            <div class="card">
                                            <div class="card-header" id="headingOne{{$key}}">
                                                <button class="btn btn-sm btn-info" type="button" data-toggle="collapse" data-target="#collapseOne{{$key}}" aria-expanded="true" aria-controls="collapseOne">
                                                    No Order: #{{ $o->code }}
                                                </button>
                                            </div>
                                        
                                            <div id="collapseOne{{$key}}" class="collapse" aria-labelledby="headingOne{{$key}}" data-parent="#accordionExample{{$key}}">
                                                <div class="card-body">
                                                    <ul class="list-group">
                                                        @php
                                                            $orderDetail = \App\OrderDetail::where('order_id', $o->id)->get();
                                                        @endphp
                                                        <div class="row mt-2">
                                                        @foreach ($orderDetail as $key => $od)
                                                            <div class="col-md-6">
                                                                <div class="card bg-dark text-white" style="width: 18rem; border-radius: 2%">
                                                                <div class="card-body">
                                                                    <h5 class="card-title">{{ \App\Product::where('id',$od->product_id)->first()->name }}</h5>
                                                                    <h6 class="card-subtitle mb-2 text-italic">{{ $od->variation }}</h6>
                                                                    <p class="card-text">{{ date('d M Y', strtotime($od->start_date)).' s/d '.date('d M Y', strtotime($od->end_date)) }}</p>
                                                                    @if ($od->status_tayang == 1)
                                                                        <div class="badge badge-info">Sudah diupload</div>
                                                                    @else 
                                                                        <div class="badge badge-warning">Belum diupload</div>
                                                                        <a href="#" class="card-link">Upload</a>
                                                                    @endif
                                                                </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        </div>
                                                    </ul>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    @endforeach --}}
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