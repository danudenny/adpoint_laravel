@extends('layouts.app')

@section('content')

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('All Products')}}</h3>
    </div>
    <div class="panel-body">
        @php
        $sellerProduct = DB::table('products as p')
                        -> join('users as s', 'p.user_id', '=', 's.id')
                    -> where('s.user_type', 'seller')
                        ->get();
        @endphp
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Media Owner')}}</th>
                    <th>{{__('Provinsi')}}</th>
                    <th>{{__('Price')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prod as $key => $value)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td><a href="{{ url('/product/'. $value->slug) }}" target="blank">{{$value->name}}</a></td>
                        <td>{{$value->user->name}}</td>
                        <td>{{$value->provinsi}}</td>
                        <td>Rp <span class="pull-right">{{number_format($value->unit_price, 0, ',', '.')}}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
