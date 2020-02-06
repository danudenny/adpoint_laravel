<div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">CODE: {{ $trx->code }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form action="{{ route('proses.confirm.to.buyer') }}" method="POST">
    @csrf
    <input type="hidden" name="trx_id" value="{{ $trx->id }}">
    <div class="confirm-modal-body" style="padding: 15px">
        @php
            $grandtotal = 0;
        @endphp
        @foreach ($trx->orders as $key => $o)
            <div style="height: 40px; background: #ccc; border-bottom: 1px solid #ccc">
                <p style="line-height: 40px; margin-left: 10px">{{ $o->code }}</p>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th width="250">{{__('Item')}}</th>
                        <th width="50">{{__('Qty')}}</th>
                        <th>{{__('Price')}}</th>
                        <th style="text-align: right">{{__('Total')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($o->orderDetails as $key => $od)
                        @php
                            $product = \App\Product::where('id', $od->product_id)->first();
                        @endphp
                        @if ($od->status == 2)
                            <tr style="text-decoration: line-through">
                                <td width="250"> <i class="fa fa-fw fa-times text-danger"></i> {{ $product->name }}</td>
                                <td width="50">{{ $od->quantity }}</td>
                                <td>{{ single_price($od->price) }}</td>
                                <td align="right">{{ single_price($od->total) }}</td>
                            </tr>
                        @else
                            <tr>
                                <td width="250"><i class="fa fa-fw fa-check text-success"></i> {{ $product->name }}</td>
                                <td width="50">{{ $od->quantity }}</td>
                                <td>{{ single_price($od->price) }}</td>
                                <td align="right">{{ single_price($od->total) }}</td>
                            </tr>
                        @endif
                        
                    @endforeach
                </tbody>
                <table class="table">
                    <tfoot>
                        <tr class="cart-subtotal">
                            <td align="right">Tax: (10%)</td>
                            <td align="right" width="200">{{ single_price($o->tax) }}</td>
                        </tr>
                        <tr class="cart-subtotal">
                            <td align="right">Sub Total:</td>
                            <td align="right" width="200">{{ single_price($o->total) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </table>
            @php
                $grandtotal += $o->grand_total;
            @endphp
        @endforeach
        <h3>Grandtotal: {{ single_price($grandtotal) }}</h3>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>