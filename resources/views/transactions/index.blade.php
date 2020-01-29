@extends('layouts.app')

@section('content')

<!-- Basic Data Tables -->
<!--===================================================-->
@if (Session::has('message'))
    <div class="alert alert-success">
        {!! session('message') !!}
    </div>
@endif
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Transaction')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Transaction Code</th>
                    <th>Payment Status</th>
                    <th>Payment Type</th>
                    <th width="10%">{{__('options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $key => $transaction)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td><a data-toggle="tooltip" data-placement="top" title="click to details" href="{{ route('transaction.details', encrypt($transaction->id)) }}"><strong class="text-primary">{{ $transaction->code }}</strong></a></td>
                        <td>
                            @if ($transaction->payment_status == 1)
                                <span class="badge badge-success">Paid</span>
                            @else
                                <span class="badge badge-danger">Unpaid</span>
                            @endif
                        </td>
                        <td>
                            {{ $transaction->payment_type }}
                        </td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('transaction.details', encrypt($transaction->id)) }}">{{__('Details')}}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            
        </table>

    </div>
</div>


@endsection

