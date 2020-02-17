@extends('layouts.app')

@section('content')

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Seller Details')}}</h3>
    </div>
    <div class="panel-body">
        <div class="col-md-4">
            <div class="panel-heading">
                <h3 class="text-lg">{{__('User Info')}}</h3>
            </div>
            <div class="row">
                <label class="col-sm-3 control-label" for="name">{{__('Name')}}</label>
                <div class="col-sm-9">
                    <p>: {{ $seller->user->name }}</p>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 control-label" for="name">{{__('Email')}}</label>
                <div class="col-sm-9">
                    <p>: {{ $seller->user->email }}</p>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 control-label" for="name">{{__('Address')}}</label>
                <div class="col-sm-9">
                    <p>: {{ $seller->user->address }}</p>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 control-label" for="name">{{__('Phone')}}</label>
                <div class="col-sm-9">
                    <p>: {{ $seller->user->phone }}</p>
                </div>
            </div>


            <div class="panel-heading">
                <h3 class="text-lg">{{__('Commission Details')}}</h3>
            </div>

            <div class="row">
                <label class="col-sm-3 control-label" for="name">{{__('Media Name')}}</label>
                <div class="col-sm-9">
                    <p>: {{ $seller->user->shop->name }}</p>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 control-label" for="name">{{__('Commission')}}</label>
                <div class="col-sm-9">
                    <p>: {{ $seller->commission }}% <a href="#"><i class="fa fa-edit text-danger"></i></a></p>
                </div>
            </div>
            <div class="row">
                <label class="col-sm-3 control-label" for="name">{{__('Total Sales')}}</label>
                <div class="col-sm-9">
                    <p>: {{ single_price(abs($seller->admin_to_pay)) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel-heading">
                <h3 class="text-lg">{{__('Verification Info')}}</h3>
            </div>
            <table class="table table-striped table-bordered" cellspacing="0" width="100%">
                <tbody>
                    @foreach (json_decode($seller->verification_info) as $key => $info)
                        <tr>
                            <th>{{ $info->label }}</th>
                            @if ($info->type == 'text' || $info->type == 'select' || $info->type == 'radio')
                                <td>{{ $info->value }}</td>
                            @elseif ($info->type == 'multi_select')
                                <td>
                                    {{ implode(json_decode($info->value), ', ') }}
                                </td>
                            @elseif ($info->type == 'file')
                                <td>
                                    <a href="{{ asset($info->value) }}" target="_blank" class="btn btn-info">{{__('Click here')}}</a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Seller Products')}} <a href="{{route('sellers.assignproduct')}}" class="btn btn-success btn-sm"><i class="fa fa-download"></i> Assign Product</a></h3>
    </div>
    <div class="panel-body">
        @php
        $sellerProduct = DB::table('products as p')
                        -> join('sellers as s', 'p.user_id', '=', 's.user_id')
                        -> where('s.id', $seller->id)
                        ->get();
        @endphp
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Price')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sellerProduct as $key => $value)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td><a href="{{ url('/product/'. $value->slug) }}" target="blank">{{$value->name}}</a></td>
                        <td>{{single_price($value->unit_price)}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
