@if (count($trx) > 0)
    @foreach ($trx as $no => $t)
        <div style="border-bottom: 1px solid #ccc">
            <div class="card no-border mt-2">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td>
                                Code: <b>{{ $t->code }}</b> | Order Date: <i class="fa fa-clock-o"></i> <i>{{ date('d M Y H:i:s', strtotime($t->created_at)) }}</i>
                                @if ($t->status === "confirmed")
                                    <a href="{{ route('confirm.payment.id', encrypt($t->id)) }}" class="btn btn-sm btn-circle btn-outline-warning pull-right"><i class="fa fa-money"></i> Pay</a>
                                @endif
                                <button onclick="trxDetails({{ $t->id }})" class="btn btn-sm btn-circle btn-outline-info pull-right mr-2"><i class="fa fa-eye"></i> Details</button>
                                @if ($t->status === "confirmed")
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="text-info">
                                                Silahkan melakukan pembayaran sebelum {{ date('d M Y H:i:s', strtotime(\Carbon\Carbon::createFromTimestamp(strtotime($t->created_at))->addHour(24))) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="text-right">
                                                
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($t->status === "cancelled")
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="text-info">
                                                Silahkan melakukan pembayaran sebelum {{ date('d M Y H:i:s', strtotime(\Carbon\Carbon::createFromTimestamp(strtotime($t->created_at))->addHour(24))) }}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="text-right">
                                                
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($t->status === "paid")
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-8">
                                            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="text-right">
                                                @if ($t->status === "paid" || $t->payment_status === 1)
                                                    <span class="badge badge-danger">Waiting approval admin...</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
@else 
    @include('frontend.not_found')
@endif