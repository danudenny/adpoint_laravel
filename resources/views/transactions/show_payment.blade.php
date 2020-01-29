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
                                <button data-toggle="modal" data-target="#sure" class="btn btn-primary"><i class="fa fa-check"></i> Change To Paid</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="sure" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <h5>Are you sure?. click yes to continue</h5>
                <a href="{{ route('transaction.change.to.paid', $confirm_payment->code) }}" class="btn btn-primary">Yes</a>
            </div>
        </div>
        </div>
    </div>
@endsection
