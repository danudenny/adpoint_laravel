<div class="modal-header">
    <h5 class="modal-title strong-600 heading-5">
        # {{ \App\Product::where('id', $query->item_name)->first()->name }} |
        @if ($query->payment_status === 1)
            <span class="badge badge-success"><i class="fa fa-money"></i> Paid</span>
        @else 
            <span class="badge badge-danger"><i class="fa fa-money"></i> Unpaid</span>
        @endif
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body px-3 pt-0">
    <div class="row">
        <div class="col-md-6">
            <table class="details-table table">
                <tbody>
                    <tr>
                        <th>{{__('Customer')}}</td>
                        <td>
                            <span>: {{ json_decode($query->address)->name }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>{{__('Email')}}</th>
                        <td>
                            <span>: {{ json_decode($query->address)->email }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>{{__('Address')}}</th>
                        <td>
                            <span>: {{ json_decode($query->address)->address }}, {{ json_decode($query->address)->city }}, {{ json_decode($query->address)->country }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>File Advertising</th>
                        <td>
                            :
                            @php
                                $file = json_decode($query->od_file_advertising);
                            @endphp
                            @if ($file !== null)
                                @if ($file->gambar !== null)
                                    @foreach ($file->gambar as $key => $g)
                                        <b><a href="{{ url($g) }}" download>Gambar {{ $key+1 }} <i class="fa fa-download"></i></a></b> <br>
                                    @endforeach
                                @endif
                                @if ($file->video !== null)
                                    @foreach ($file->video as $key => $v)
                                        <b><a href="{{ url($v) }}" download>Video {{ $key+1 }} <i class="fa fa-download"></i></a></b> <br>
                                    @endforeach
                                @endif
                                @if ($file->link !== null)
                                    @foreach ($file->link as $key => $l)
                                        <b><a href="{{ $l }}" target="_blank">Link {{ $key+1 }} <i class="fa fa-download"></i></a></b> <br>
                                    @endforeach
                                @endif
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <table class="table details-table">
                <tbody>
                    <tr>
                        <th>{{__('Transaction Number')}}</th>
                        <td>
                            <span>: {{ $query->code_trx }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>{{__('Order Number')}}</th>
                        <td>
                            <span>: {{ $query->code_order }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>{{__('Order Date')}}</th>
                        <td>
                            <span>: {{ date('d M Y H:i:s', strtotime($query->order_date)) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>{{__('Order Status')}}</th>
                        <td>
                            <span>: 
                                @if ($query->od_status == 0)
                                    <i class="text-black">Placed</i>
                                @elseif ($query->od_status == 1)
                                    <i class="text-default">On Review</i>
                                @elseif ($query->od_status == 2)
                                    <i class="text-danger">Cancelled</i>
                                    @php
                                        $reject_by_admin = \App\Transaction::where('code', $query->code_trx)->first()->is_rejected;
                                    @endphp
                                    @if ($reject_by_admin !== null)
                                        <div>Reject by seller: <b class="text-danger">{{ $reject_by_admin }}</b></div> 
                                    @else 
                                        @if ($query->od_rejected !== null)
                                            <div>Reject by seller: <b class="text-danger">{{ $query->od_rejected }}</b></div> 
                                        @endif
                                    @endif
                                @elseif ($query->od_status == 3)
                                    <i class="text-primary">Actived</i>
                                @elseif ($query->od_status == 4)
                                    <i class="text-success">Completed</i>
                                @elseif ($query->od_status == 100)
                                    <i class="text-danger">Cancelled</i>
                                @endif
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

