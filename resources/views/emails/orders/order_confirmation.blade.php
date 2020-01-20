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
                                                        $reject += $item['price']*$item['quantity']; 
                                                        $subtotal += ($item['price']*$item['quantity'])-$reject;
                                                    @endphp
                                                    <tr style="text-decoration: line-through">
                                                        <td width="60%" class="purchase_item">
                                                            <span class="f-fallback" style="font-size: 12px">{{ $product->name }} ({{ $item['quantity'] }})</span>
                                                        </td>
                                                        <td class="align-right" width="40%" class="purchase_item">
                                                            <span class="f-fallback" style="font-size: 12px">{{ single_price($item['price']*$item['quantity']) }}</span>
                                                        </td>
                                                    </tr>
                                                @else 
                                                    @php 
                                                        $subtotal += $item['price']*$item['quantity']; 
                                                    @endphp
                                                    <tr>
                                                        <td width="60%" class="purchase_item">
                                                            <span class="f-fallback" style="font-size: 12px">{{ $product->name }} ( <i>{{ $item['quantity'] }} - {{ $item['variation'] }}</i> )</span>
                                                        </td>
                                                        <td class="align-right" width="40%" class="purchase_item">
                                                            <span class="f-fallback" style="font-size: 12px">{{ single_price($item['price']*$item['quantity']) }}</span>
                                                        </td>
                                                    </tr>
                                                @endif 
                                            @endforeach
                                            <tr>
                                                <td align="left" class="purchase_item">
                                                    <p class="f-fallback" style="font-size: 12px">Tax</p>
                                                </td>
                                                <td align="right" class="purchase_item">
                                                    <p class="f-fallback" style="font-size: 12px">0</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" class="purchase_item">
                                                    <p class="f-fallback" style="font-size: 12px">Subtotal</p>
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
                                <td class="purchase_heading" align="left">
                                    <a href="{{ url('/confirm_payment', $user['trx_id']) }}" target="_blank" class="f-fallback button button--green" target="_blank">Ya, Lanjutkan</a>
                                </td>
                                <th class="purchase_heading" align="right">
                                    <a href="#" class="f-fallback button button--red" target="_blank">Tidak</a>
                                </th>
                            </tr>
                        </table>
                        
                    </div>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection




{{-- <tr>
    <td class="email-body" width="100%">
        <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0">
            <!-- Body content -->
            <tr>
                <td class="content-cell">
                    <div class="invoice-box">
                        @php 
                        $grandtotal = 0; 
                        $reject = 0; 
                        $note = DB::table('order_details as od')
                            ->join('orders as o', 'o.id', '=', 'od.order_id')
                            ->join('transactions as t', 't.id', '=', 'o.transaction_id')
                            ->where([ 't.id' => $user['trx_id'], 'od.status' => 2 ])->get();
                        @endphp
                        <p id="#font">{{ $user['buyer_name'] }},<br> Kami sedang mereview Order Anda dengan rincian sebagai berikut. Jika order ini telah disetujui makan kami akan mengirimkan email untuk intruksi transfer. Terimakasih</p>

                        @if (count($note) > 0)
                        <p>note:</p>
                        <ol>
                            @foreach ($note as $key => $item) 
                                @php 
                                    $product = \App\Product::where('id', $item->product_id)->first(); 
                                @endphp
                            <li>{{ $product->name }} - <strong style="color: red">{{ $item->rejected }}</strong> dari seller: {{ \App\User::where('id', $item->seller_id)->first()->name }}</li>
                            @endforeach
                        </ol>
                        @endif
                        @foreach ($user['code_order'] as $key => $co)
                        <div style="height: 30px; background: #0f355a; border-bottom: 2px solid #fd7e14">
                            <p style="line-height: 30px; margin-left: 10px; color: white;">CODE: {{ $key }}</p>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th width="100">Item</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th style="text-align: right">{{__('Total')}}</th>
                                </tr>
                            </thead>
                            <tbody>
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
                                            $reject+=$item['price']*$item['quantity']; 
                                            $subtotal += ($item['price']*$item['quantity'])-$reject;
                                        @endphp
                                        <tr style="text-decoration: line-through;">
                                            <td width="100">{{ $product->name }}</td>
                                            <td>{{ $item['quantity'] }}</td>
                                            <td>{{ single_price($item['price']) }}</td>
                                            <td align="right">{{ single_price($item['price']*$item['quantity']) }}</td>
                                        </tr>
                                    @else 
                                        @php 
                                            $subtotal += $item['price']*$item['quantity']; 
                                        @endphp
                                        <tr>
                                            <td width="100">{{ $product->name }}</td>
                                            <td>{{ $item['quantity'] }}</td>
                                            <td>{{ single_price($item['price']) }}</td>
                                            <td align="right">{{ single_price($item['price']*$item['quantity']) }}</td>
                                        </tr>
                                    @endif 
                                @endforeach
                            </tbody>
                            <tr>
                                <td colspan="2"></td>
                                <td align="right">Tax:</td>
                                <td align="right">0</td>
                            </tr>
                            <tr id="#font">
                                <td colspan="2"></td>
                                <td align="right">Sub Total:</td>
                                <td align="right">{{ single_price($subtotal) }}</td>
                            </tr>
                        </table>
                            @php 
                                $grandtotal += $subtotal;
                            @endphp 
                        @endforeach
                        <div class="center">
                            <span class="button button--orange">Grandtotal: {{ single_price($grandtotal) }}</span>
                        </div>

                        <div style="margin-top: 10px">
                            <table>
                                <tr>
                                    <td>
                                        <div class="center">
                                            <a class="button button--blue">Ya, Lanjutkan</a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="center">
                                            <a class="button button--red">Tidak</a>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>


                        <p>Payment Method,<br>
                            <b>Bank Transfer Payment</b><br> Pembayaran dapat ditransfer melalui rekening bank berikut:
                        </p>

                        <table>
                            <tr>
                                <td>
                                    <p>
                                        BCA<br> Cabang Ampera<br> PT. Adpoint Media Online<br> 585-530-8301
                                    </p>
                                </td>
                                <td align="right">
                                    <p>
                                        Mandiri<br> Cabang Ampera<br> PT. Adpoint Media Online<br> 585-530-8301
                                    </p>
                                </td>
                            </tr>
                        </table>
                        <p>Terimakasih</p>
                        <p>Regards,<br>Adpoint</p>
                    </div>
                </td>

            </tr>

        </table>
    </td>
</tr> --}}