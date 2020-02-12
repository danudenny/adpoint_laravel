@if (count($trx) > 0)
    @foreach ($trx as $no => $t)
        <div style="border-bottom: 1px solid #ccc">
            <div class="card no-border mt-2">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td>
                                <small>Code:</small><br>
                                <b>{{ $t->code }}</b>
                            </td>
                            <td>
                                <small>Date:</small><br>
                                <i class="fa fa-clock-o"></i> <b>{{ date('d M Y H:i:s', strtotime($t->created_at)) }}</b>
                            </td>
                            <td>
                                <small>Status:</small><br>
                                @if ($t->status == "on proses")
                                    <i class="text-primary">On proses</i>
                                @elseif ($t->status == "approved")
                                    <i class="text-success">Approved</i>
                                @elseif ($t->status == "rejected")
                                    <i class="text-danger">Rejected</i>
                                @elseif ($t->status == "ready")
                                    <i class="text-primary">Checked Seller</i>
                                @elseif ($t->status == "confirmed")
                                    <i class="text-primary">Confirmed</i>
                                @elseif ($t->status == "paid")
                                    <i class="text-success">Paid</i>
                                @endif
                            </td>
                            <td>
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
                            @if ($t->status === "confirmed")
                                <tr>
                                    <table class="table" style="width: 70%;" align="center">
                                        <tr>
                                            <td>
                                                <div class="row mt-2 bg-pay">
                                                    <div class="col-12">
                                                        <div class="text-info text-center">
                                                            @php
                                                                $orderdate = date('M d, Y H:i:s', strtotime($t->created_at));
                                                                $countdown = date('M d, Y H:i:s', strtotime(\Carbon\Carbon::createFromTimestamp(strtotime($t->created_at))->addHour(24)));
                                                            @endphp
                                                            Silahkan melakukan pembayaran sebelum {{ date('d M Y H:i:s', strtotime(\Carbon\Carbon::createFromTimestamp(strtotime($t->created_at))->addHour(24))) }}
                                                            <br>
                                                            <input type="hidden" id="od" value="{{ $orderdate  }}">
                                                            <input type="hidden" id="cd" value="{{ $countdown  }}">
                                                            <h5 id="demo"></h5>
                                                            <a href="{{ route('confirm.payment.id', encrypt($t->id)) }}" class="btn btn-circle btn-sm btn-outline-warning"><i class="fa fa-money"></i> Pay Now</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </tr>
                            @endif
                            @if ($t->status === "paid")
                                <tr>
                                    <table class="table" style="width: 70%" align="center">
                                        <tr>
                                            <td>
                                                <div class="row mt-2 bg-pay">
                                                    <div class="col-12">
                                                        <div class="text-center">
                                                            @if ($t->status === "paid" || $t->payment_status === 1)
                                                                <h4 class="text-danger">Waiting approval admin...</h4>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </tr>
                            @endif
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
@else 
    @include('frontend.not_found')
@endif