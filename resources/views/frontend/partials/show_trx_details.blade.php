<div class="modal-header">
    <h5 class="modal-title strong-600 heading-5">
        Code Transaction: {{ $transaction->code }} | 
        @if ($transaction->payment_status == 1)
            <span class="badge badge-success">Paid</span>
        @else 
            <span class="badge badge-danger">Unpaid</span>
        @endif
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body px-3 pt-0">
    <div class="row">
        <div class="col-md-6">
            <b>{{__('File Advertising')}} :</b>
            <p>
                @php
                $file = json_decode($transaction->file_advertising);
                @endphp
                @if ($file->gambar !== null)
                    @foreach ($file->gambar as $key => $g)
                        <a href="{{ url($g) }}" download>Gambar {{ $key+1 }}</a><br>
                    @endforeach
                @endif

                @if ($file->video !== null)
                    @foreach ($file->video as $key => $v)
                        <a href="{{ url($v) }}" download>Video {{ $key+1 }}</a><br>
                    @endforeach
                @endif
            </p>
        </div>
    </div>
    <table class="table table-bordered mt-2">
        @php
            $grand_total = 0;
        @endphp
        @foreach ($transaction->orders as $key => $o)
            @php
                $seller = \App\User::where('id', $o->seller_id)->first();
            @endphp
            <tr>
                <th colspan="6">
                    Order Number: {{ $o->code }} - <span class="badge badge-primary"># {{ $seller->name }}</span>
                </th>
            </tr>
            @foreach ($o->orderDetails as $key => $od)
                @php
                    $product = \App\Product::where('id', $od->product_id)->first();
                @endphp
                @if ($od->status == 2)
                    <tr style="text-decoration: line-through">
                        <td>{{ $key+1 }}</td>
                        <td>
                            <i class="fa fa-fw fa-times text-danger"></i>
                            <small>Name: </small><br>
                            <strong>{{ $product->name }}</strong> / <i class="text-primary">{{ date('d M Y', strtotime($od->start_date)) }} - {{ date('d M Y', strtotime($od->start_date)) }}</i>
                        </td>
                        <td>
                            <small>Qty: </small><br>
                            <strong>{{ $od->quantity }}</strong>
                        </td>
                        <td>
                            <small>Periode: </small><br>
                            <strong>{{ $od->variation }}</strong>
                        </td>
                        <td>
                            <small>Price: </small><br>
                            <strong>{{ single_price($od->price) }}</strong>
                        </td>
                        <td align="right">
                            <small>Total: </small><br>
                            <strong>{{ single_price($od->total) }}</strong>
                        </td>
                    </tr>
                @else 
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            <i class="fa fa-fw fa-check text-success"></i>
                            <small>Name: </small><br>
                            <strong>{{ $product->name }}</strong> / <i class="text-primary">{{ date('d M Y', strtotime($od->start_date)) }} - {{ date('d M Y', strtotime($od->start_date)) }}</i>
                        </td>
                        <td>
                            <small>Qty: </small><br>
                            <strong>{{ $od->quantity }}</strong>
                        </td>
                        <td>
                            <small>Periode: </small><br>
                            <strong>{{ $od->variation }}</strong>
                        </td>
                        <td>
                            <small>Price: </small><br>
                            <strong>{{ single_price($od->price) }}</strong>
                        </td>
                        <td align="right">
                            <small>Total: </small><br>
                            <strong>{{ single_price($od->total) }}</strong>
                        </td>
                    </tr>
                @endif
            @endforeach
            <tr>
                <td colspan="5" align="right">Total</td>
                <td align="right"><strong>{{ single_price($o->total) }}</strong></td>
            </tr>
            <tr>
                <td colspan="5" align="right">Tax: (10%) </td>
                <td align="right"><strong>{{ single_price($o->tax) }}</strong></td>
            </tr>
            <tr>
                <td colspan="5" align="right">Subtotal: </td>
                <td align="right"><strong>{{ single_price($o->grand_total) }}</strong></td>
            </tr>
            @php
                $grand_total += $o->grand_total;
            @endphp
        @endforeach
        <tr>
            <td align="right" colspan="5">
                <h4>{{__('Grand Total')}} :</h4>
            </td>
            <td align="right">
                <h4>{{ single_price($grand_total) }}</h4>
            </td>
        </tr>
    </table>
</div>

