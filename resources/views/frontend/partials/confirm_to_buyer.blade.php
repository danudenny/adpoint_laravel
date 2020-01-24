<div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">CODE: {{ $invoice['code_trx'] }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form action="{{ route('proses.confirm.to.buyer') }}" method="POST">
    @csrf
    <input type="hidden" name="trx_id" value="{{ $invoice['trx_id'] }}">
    <div class="confirm-modal-body" style="padding: 15px">
        @php
            $grandtotal = 0;
            $reject = 0;
        @endphp
        @foreach ($invoice['code_order'] as $key => $co)
            <div style="height: 40px; background: #0f355a; color: white; border-bottom: 2px solid #fd7e14">
                <p style="line-height: 40px; margin-left: 10px">{{ $key }}</p>
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
                    @php
                        $subtotal = 0;
                    @endphp
                    @foreach ($co as $key => $item)
                        @php
                            $product = \App\Product::where('id', $item['product_id'])->first();
                        @endphp
                        @if ($item['status'] == 2)
                            @php
                                $reject+=$item['price'];
                                $subtotal += ($item['price'])-$reject;
                            @endphp
                            <tr style="text-decoration: line-through">
                                <td width="250"> <i class="fa fa-fw fa-times text-danger"></i> {{ $product->name }}</td>
                                <td width="50">{{ $item['quantity'] }}</td>
                                <td>{{ single_price($product->unit_price) }}</td>
                                <td align="right">{{ single_price($item['price']) }}</td>
                            </tr>
                        @else
                            @php
                                $subtotal += $item['price'];
                            @endphp
                            <tr>
                                <td width="250"><i class="fa fa-fw fa-check text-success"></i> {{ $product->name }}</td>
                                <td width="50">{{ $item['quantity'] }}</td>
                                <td>{{ single_price($product->unit_price) }}</td>
                                <td align="right">{{ single_price($item['price']) }}</td>
                            </tr>
                        @endif
                        
                    @endforeach
                </tbody>
                <table class="table">
                    <tfoot>
                        <tr class="cart-subtotal">
                            @php
                                $tax = $subtotal*0.1;
                                $subtotal = $tax+$subtotal;
                            @endphp
                            <td align="right">Tax: (10%)</td>
                            <td align="right" width="200">{{ single_price($tax) }}</td>
                        </tr>
                        <tr class="cart-subtotal">
                            <td align="right">Sub Total:</td>
                            <td align="right" width="200">{{ single_price($subtotal) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </table>
            @php
                $grandtotal += $subtotal;
            @endphp
        @endforeach
        <h3>Grandtotal: {{ single_price($grandtotal) }}</h3>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>