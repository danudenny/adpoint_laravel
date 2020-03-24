@extends('emails.template') 

@section('content')
<tr>
    <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
        <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
            <!-- Body content -->
            <tr>
                <td class="content-cell">
                    <div class="f-fallback">
                        @php 
                            $grandtotal = 0;  
                            $note = DB::table('order_details as od')
                                ->join('orders as o', 'o.id', '=', 'od.order_id')
                                ->join('transactions as t', 't.id', '=', 'o.transaction_id')
                                ->where([ 't.id' => $trx->id, 'od.status' => 2 ])->get();
                            $user = \App\User::where('id', $trx->user_id)->first();
                        @endphp
                        <h4>Dear {{$user->name}},</h4>
                        @php
                            $email = \App\BusinessSetting::where('type','email_settings')->first()->value;
                            $value = json_decode($email);
                            $content = "";
                            foreach ($value->data as $key => $d) {
                                if ($d->judul == "Order Confirmation Admin") {
                                    $content = $d->content;
                                }
                            }
                        @endphp
                        {!! $content !!}
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
                                        @foreach ($trx->orders as $key => $o)
                                            <tr>
                                                <th class="purchase_heading" align="left">
                                                    <h5 class="f-fallback">{{ $o->code }}</h5>
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
                                            @foreach ($o->orderDetails as $key => $od)
                                                @php 
                                                    $product = \App\Product::where('id', $od->product_id)->first();
                                                @endphp
                                                @if ($od->status == 2)
                                                    <tr style="text-decoration: line-through">
                                                        <td width="60%" class="purchase_item">
                                                            <span class="f-fallback" style="font-size: 12px">{{ $product->name }} (<i>{{ $od->quantity }} - {{ $od->variation}}</i>)</span>
                                                        </td>
                                                        <td class="align-right" width="40%" class="purchase_item">
                                                            <span class="f-fallback" style="font-size: 12px">{{ single_price($od->price) }}</span>
                                                        </td>
                                                    </tr>
                                                @else 
                                                    <tr>
                                                        <td width="60%" class="purchase_item">
                                                            <span class="f-fallback" style="font-size: 12px">{{ $product->name }} ( <i>{{ $od->quantity }} - {{ $od->variation}}</i> )</span>
                                                        </td>
                                                        <td class="align-right" width="40%" class="purchase_item">
                                                            <span class="f-fallback" style="font-size: 12px">{{ single_price($od->price) }}</span>
                                                        </td>
                                                    </tr>
                                                @endif 
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
                                                    <p class="f-fallback" style="font-size: 12px">{{ single_price($o->total) }}</p>
                                                </td>
                                            </tr>
                                            @php 
                                                $grandtotal += $o->grand_total;
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
                                    <a href="{{ url('/continue_payment', encrypt($trx->id)) }}" target="_blank" class="f-fallback button button--green" target="_blank">Ya, Lanjutkan</a>
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