@extends('layouts.app')

@section('content')
<div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Payment Details</h3>
        </div>
        <div class="panel-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tr>
                                    <td>No Order</td>
                                    <td>{{ $query[0]->no_order }}</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>{{ $query[0]->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Bank</td>
                                    <td>{{ $query[0]->nama_bank }}</td>
                                </tr>
                                <tr>
                                    <td>No Rekening</td>
                                    <td>{{ $query[0]->no_rek }}</td>
                                </tr>
                                <tr>
                                    <td>Total Pembayaran</td>
                                    <td>Rp {{ number_format($query[0]->grand_total) }}</td>
                                </tr>
                                <tr>
                                    <td>Bukti Pembayaran</td>
                                    <td><a target="_blank" href="{{ url($query[0]->bukti) }}"><span class="badge badge-success">Lihat</span></a></td>
                                </tr>
                            </table>
                            @if ($query[0]->payment_status == 'paid')
                                <div class="alert alert-success">Paid</div>
                            @else 
                                <a href="{{ route('change.to.paid', encrypt($order_id)) }}" class="btn btn-primary"><i class="fa fa-check"></i> Confirm To Paid</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
