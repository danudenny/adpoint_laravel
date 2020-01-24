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
                                    <td>Code Transaction</td>
                                    <td>{{ $confirm_payment->code_trx }}</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>{{ $confirm_payment->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Bank</td>
                                    <td>{{ $confirm_payment->nama_bank }}</td>
                                </tr>
                                <tr>
                                    <td>No Rekening</td>
                                    <td>{{ $confirm_payment->no_rek }}</td>
                                </tr>
                                <tr>
                                    <td>Total Pembayaran</td>
                                    @php
                                        $orders = $trx->orders;
                                        $total = 0;
                                        foreach ($orders as $key => $o) {
                                            $total+=$o->grand_total;
                                        }
                                    @endphp
                                    <td>Rp {{ number_format($total) }}</td>
                                </tr>
                                <tr>
                                    <td>Bukti Pembayaran</td>
                                    <td><a target="_blank" href="{{ url($confirm_payment->bukti) }}"><span class="badge badge-success">Lihat</span></a></td>
                                </tr>
                            </table>
                            @if ($confirm_payment->payment_status === 1)
                                <div class="alert alert-success">Paid</div>
                            @else 
                                <a href="{{ route('transaction.change.to.paid', $confirm_payment->code) }}" class="btn btn-primary"><i class="fa fa-check"></i> Change To Paid</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
