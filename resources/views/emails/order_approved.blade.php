@extends('emails.template')
@section('content')
<tr>
    <td class="email-body" width="100%">
        <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0">
            <!-- Body content -->
            <tr>
                <td class="content-cell">
                    <div class="invoice-box">
                        <p>Dear {{$user['buyer_name']}},<br> Kami sedang mereview Order Anda dengan rincian sebagai berikut. Jika order ini telah disetujui makan kami akan mengirimkan email untuk intruksi transfer. Terimakasih</p>
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td colspan="4">
                                    <h2>Order Number {{$user['code']}}</h2>
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    Placed on: {{ $user['created_at'] }}
                                    <br>
                                    <br>
                                </td>
                            </tr>
                            <tr class="heading" align="center">
                                <th>Items</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Price</th>
                            </tr>
                            @php
                                $product = $user['product'];
                            @endphp
                            @foreach ($product as $key => $p)
                                <tr class="details">
                                    <td>{{$product[$key]['name']}}<br>Periode: {{$product[$key]['periode']}}</td>
                                    <td valign="top" align="center">{{$product[$key]['start_date']}}</td>
                                    <td valign="top" align="center">{{$product[$key]['end_date']}}</td>
                                    <td valign="top" align="center">Rp {{$product[$key]['price']}}</td>
                                </tr>
                                <tr>
                                    <td><hr></td>
                                    <td><hr></td>
                                    <td><hr></td>
                                    <td><hr></td>
                                </tr>
                            @endforeach
                            
                            {{-- detail price --}}
                            <tr style="background: #eaeaea;">
                                <td></td>
                                <td></td>
                                <td align="right">Subtotal :</td>
                                <td align="center">Rp {{ $user['grand_total'] }}</td>
                            </tr>
                            <tr style="background: #eaeaea;">
                                <td></td>
                                <td></td>
                                <td align="right">Tax :</td>
                                <td align="center">Rp {{ $user['tax'] }}</td>
                            </tr>
                            <tr style="background: #eaeaea;">
                                <td></td>
                                <td></td>
                                <td align="right">Grand Total :</td>
                                <td align="center">Rp {{ $user['grand_total'] }}</td>
                            </tr>
                        </table>
                        <p>Payment Method,<br>
                            <b>Bank Transfer Payment</b><br> Pembayaran dapat ditransfer melalui rekening bank berikut:</p>
                        <p>
                            BCA<br> Cabang Ampera<br> PT. Adpoint Media Online<br> 585-530-8301
                        </p>
                        <p>
                            Mandiri<br> Cabang Ampera<br> PT. Adpoint Media Online<br> 585-530-8301
                        </p>
                        <p>Terimakasih</p>
                        <p>Regards,<br>Adpoint</p>
                    </div>

                </td>

            </tr>

        </table>
    </td>
</tr>
@endsection
