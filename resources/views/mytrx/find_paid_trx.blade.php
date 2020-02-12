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
                                @if ($t->status === "confirmed")
                                    <a href="{{ route('confirm.payment.id', encrypt($t->id)) }}" class="btn btn-sm btn-circle btn-outline-warning pull-right">Confirm Payment</a>
                                @endif
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
                                <small>Bukti Transfer:</small><br>
                                @php
                                    $cp = \App\ConfirmPayment::where('code_trx', $t->code)->first();
                                @endphp
                                @if ($cp !== null)
                                    <b><a href="{{ url($cp->bukti) }}" download=""><i class="fa fa-download"></i> Bukti Transfer</a></b>
                                @endif
                            </td>
                            <td>
                                <button onclick="trxDetails({{ $t->id }})" class="btn btn-sm btn-circle btn-outline-info pull-right"><i class="fa fa-eye"></i> Details</button>
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