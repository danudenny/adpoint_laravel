@if (count($trx) > 0)
    @foreach ($trx as $no => $t)
        <div class="card mt-2" style="background: #fff; 
                                color: black; border-radius: 0%; 
                                border-bottom: 2px solid #fd7e14; 
                                border-top: 0;
                                border-left: 0;
                                border-right: 0;">
            <div class="card-header">
                Code: <b>{{ $t->code }}</b> | Order Date: <i class="fa fa-clock-o"></i> <i>{{ date('d M Y H:i:s', strtotime($t->created_at)) }}</i>
                @if ($t->status === "confirmed")
                    <a href="{{ route('confirm.payment.id', encrypt($t->id)) }}" class="btn btn-sm btn-circle btn-outline-warning pull-right">Confirm Payment</a>
                @endif
                <button onclick="trxDetails({{ $t->id }})" class="btn btn-sm btn-circle btn-outline-info pull-right"><i class="fa fa-eye"></i> Details</button>
            </div>
        </div>
    @endforeach
@else 
    @include('frontend.not_found')
@endif