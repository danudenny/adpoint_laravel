<div class="modal-header">
    <h5 class="modal-title strong-600 heading-5">
        # {{ \App\Product::where('id', $query->item_name)->first()->name }}
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body px-3 pt-0">
    <table class="table details-table">
        <tbody>
            <tr>
                <th>{{__('Transaction Number')}}</th>
                <td class="text-right">
                    <span class="strong-600">{{ $query->code_trx }}</span>
                </td>
            </tr>
            <tr>
                <th>{{__('Order Number')}}</th>
                <td class="text-right">
                    <span class="strong-600">{{ $query->code_order }}</span>
                </td>
            </tr>
            <tr>
                <th>{{__('Order Date')}}</th>
                <td class="text-right">
                    <span class="strong-600">{{ $query->order_date }}</span>
                </td>
            </tr>
            <tr>
                <th>{{__('Order Status')}}</th>
                <td class="text-right">
                    <span class="strong-600">
                        @if ($query->od_status == 0)
                            <i class="text-black">Placed</i>
                        @elseif ($query->od_status == 1)
                            <i class="text-default">On Review</i>
                        @elseif ($query->od_status == 2)
                            <i class="text-danger">Cancelled</i>
                        @elseif ($query->od_status == 3)
                            <i class="text-primary">Actived</i>
                        @elseif ($query->od_status == 4)
                            <i class="text-success">Completed</i>
                        @endif
                    </span>
                </td>
            </tr>
            <tr>
                <th>{{__('Payment Status')}}</th>
                <td class="text-right">
                    <span class="strong-600">
                        @if ($query->payment_status === 1)
                            <span class="badge badge-success"><i class="fa fa-money"></i> Paid</span>
                        @else 
                            <span class="badge badge-danger"><i class="fa fa-money"></i> Unpaid</span>
                        @endif
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
</div>
