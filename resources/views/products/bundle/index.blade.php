@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('products.bundle.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Media Bundles')}}</a>
        </div>
    </div>
    <br>
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Media Bundles')}}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Bundle Name')}}</th>
                    <th>{{__('Seller')}}</th>
                    <th>{{__('Category')}}</th>
                    <th>{{__('List Products')}}</th>
                    <th>{{__('Price')}}</th>
                    <th width="10%">{{__('Options')}}</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>

@endsection
