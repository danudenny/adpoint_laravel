@extends('emails.template') @section('content')
<tr>
    <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
        <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
            <!-- Body content -->
            <tr>
                <td class="content-cell">
                    <div class="f-fallback">
                        @php 
                            $grandtotal = 0; 
                            $reject = 0; 
                            $note = DB::table('order_details as od')
                                ->join('orders as o', 'o.id', '=', 'od.order_id')
                                ->join('transactions as t', 't.id', '=', 'o.transaction_id')
                                ->where([ 't.id' => $user['trx_id'], 'od.status' => 2 ])->get();
                        @endphp
                        <h4>Dear {{$user['buyer_name']}},</h4>
                        <p>Terimakasih sudah melakukan order. rincian sebagai berikut.</p>
                        @if (count($note) > 0)
                            @foreach ($note as $key => $item) 
                                @php 
                                    $product = \App\Product::where('id', $item->product_id)->first(); 
                                @endphp
                                <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                    <tr>
                                        <td class="attributes_content">
                                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                                <tr>
                                                    <td class="attributes_item">
                                                        <span class="f-fallback">
                                                            <strong>{{ $product->name }}</strong> <i>"{{ $item->rejected }}"</i>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            @endforeach
                        @endif
                        <table class="purchase" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td colspan="2">
                                    <table class="purchase_content" width="100%" cellpadding="0" cellspacing="0">
                                        @foreach ($user['code_order'] as $key => $co)
                                            <tr>
                                                <th class="purchase_heading" align="left">
                                                    <h5 class="f-fallback">{{ $key }}</h5>
                                                </th>
                                                <th class="purchase_heading" align="right">
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="purchase_heading" align="left">
                                                    <p class="f-fallback">Description</p>
                                                </th>
                                                <th class="purchase_heading" align="right">
                                                    <p class="f-fallback">Amount</p>
                                                </th>
                                            </tr>
                                            @php 
                                                $subtotal = 0; 
                                                $tax = 0; 
                                            @endphp 
                                            @foreach ($co as $key => $item)
                                                @php 
                                                    $product = \App\Product::where('id', $item['product_id'])->first();
                                                @endphp
                                                @if ($item['status'] == 2)
                                                    @php
                                                        $reject += $item['price']; 
                                                        $subtotal += ( $item['price'])-$reject;
                                                    @endphp
                                                    <tr style="text-decoration: line-through">
                                                        <td width="60%" class="purchase_item">
                                                            <span class="f-fallback" style="font-size: 12px">{{ $product->name }} ({{ $item['quantity'] }})</span>
                                                        </td>
                                                        <td class="align-right" width="40%" class="purchase_item">
                                                            <span class="f-fallback" style="font-size: 12px">{{ single_price( $item['price']) }}</span>
                                                        </td>
                                                    </tr>
                                                @else 
                                                    @php 
                                                        $subtotal +=  $item['price']; 
                                                    @endphp
                                                    <tr>
                                                        <td width="60%" class="purchase_item">
                                                            <span class="f-fallback" style="font-size: 12px">{{ $product->name }} ( <i>{{ $item['quantity'] }} - {{ $item['variation'] }}</i> )</span>
                                                        </td>
                                                        <td class="align-right" width="40%" class="purchase_item">
                                                            <span class="f-fallback" style="font-size: 12px">{{ single_price($item['price']) }}</span>
                                                        </td>
                                                    </tr>
                                                @endif 
                                            @endforeach
                                            @php
                                                $tax = $subtotal*0.1;
                                                $subtotal = $tax+$subtotal;
                                            @endphp
                                            <tr>
                                                <td align="left" class="purchase_item">
                                                    <p class="f-fallback" style="font-size: 12px">Tax: (10%)</p>
                                                </td>
                                                <td align="right" class="purchase_item">
                                                    <p class="f-fallback" style="font-size: 12px">{{ single_price($tax) }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" class="purchase_item">
                                                    <p class="f-fallback" style="font-size: 12px">Subtotal: </p>
                                                </td>
                                                <td align="right" class="purchase_item">
                                                    <p class="f-fallback" style="font-size: 12px">{{ single_price($subtotal) }}</p>
                                                </td>
                                            </tr>
                                            @php 
                                                $grandtotal += $subtotal;
                                            @endphp 
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                            <tr>
                                <td class="attributes_item" valign="middle">
                                    <span class="f-fallback">
                                        <h2>Grantotal: {{ single_price($grandtotal) }}</h2>
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <!-- Action -->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
                            <tr>
                                <p>Terimakasih.<br>
                                    Anda sudah melakukan order. Mohon segera melakukan pembayaran
                                </p>
                            </tr>
                            <tr>
                                <td class="purchase_heading" align="left">
                                    <a href="{{ route('confirm.payment.id', encrypt($user['trx_id'])) }}" target="_blank" class="f-fallback button button--green" target="_blank">Confirm</a>
                                </td>
                            </tr>
                        </table>
                        
                    </div>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection