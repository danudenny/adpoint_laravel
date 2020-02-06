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
                                    <a href="{{ route('confirm.payment.id', encrypt($t->id)) }}" class="btn btn-sm btn-circle btn-outline-warning pull-right">Confirm Payment</a>
                                @endif
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