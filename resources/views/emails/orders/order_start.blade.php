@extends('emails.template')
@section('content')
<tr>
    <td class="email-body" width="100%">
        <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0">
            <!-- Body content -->
            <tr>
                <td class="content-cell">
                    <div class="f-fallback">
                        <h4>Dear {{ \App\user::where('id', $trx->user_id)->first()->name }},</h4>
                        
                        <p>Terimakasih.<br>
                            Anda sudah melakukan order. Mohon menunggu orderan di review admin.
                        </p>
                        <p>Berikut rinciannya :</p>
                        <table class="purchase" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td colspan="2">
                                    <table class="purchase_content" width="100%" cellpadding="0" cellspacing="0">
                                        @php
                                            $grand_total = 0;
                                        @endphp
                                        @foreach ($trx->orders as $key => $o)
                                            <tr style="background-color: #FBFBFB">
                                                <td align="left">
                                                    <h6 class="f-fallback">Order Code: {{ $o->code }}</h6>
                                                </td>
                                                <td align="right">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="purchase_heading" align="left">
                                                    <p class="f-fallback">Description</p>
                                                </th>
                                                <th class="purchase_heading" align="right">
                                                    <p class="f-fallback">Amount</p>
                                                </th>
                                            </tr>
                                            @foreach ($o->orderDetails as $key => $od)
                                                @php
                                                    $product = \App\Product::where('id', $od->product_id)->first();
                                                @endphp
                                                <tr>
                                                    <td width="60%" class="purchase_item">
                                                        <span class="f-fallback" style="font-size: 12px">{{ $product->name }} ( <i>{{ $od->quantity }} - {{ $od->variation }}</i> )</span>
                                                    </td>
                                                    <td class="align-right" width="40%" class="purchase_item">
                                                        <span class="f-fallback" style="font-size: 12px">{{ single_price($od->total) }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td align="left" class="purchase_item">
                                                    <p class="f-fallback" style="font-size: 12px">Tax: (10%)</p>
                                                </td>
                                                <td align="right" class="purchase_item">
                                                    <p class="f-fallback" style="font-size: 12px">{{ single_price($o->tax) }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" class="purchase_item">
                                                    <p class="f-fallback" style="font-size: 12px">Subtotal: </p>
                                                </td>
                                                <td align="right" class="purchase_item">
                                                    <p class="f-fallback" style="font-size: 12px">{{ single_price($o->grand_total) }}</p>
                                                </td>
                                            </tr>
                                        @php
                                            $grand_total += $o->grand_total;
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
                                        <h2>Grantotal: {{ single_price($grand_total) }}</h2>
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <!-- Action -->

                        <p>Terimakasih</p>
                        <p>Regards,<br>Adpoint</p>
                    </div>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection