<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Invoice</title>
</head>

<body>
    <div class="panel">
        <div class="panel-body">
            <div class="invoice-masthead">
                <div class="invoice-text">
                    <h3 class="h1 text-thin mar-no text-primary">{{ __('Invoice') }}</h3>
                </div>
            </div>
            <div class="invoice-bill row">
                <div class="col-sm-6 text-xs-center">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <td class="text-main text-bold">
                                    {{__('Invoice #')}}
                                </td>
                                <td class="text-right text-info text-bold">
                                    {{ $inv->code }}
                                </td>
                            </tr>
                            <tr>
                                @php $trx = \App\Transaction::where('id', $inv->transaction_id)->first(); @endphp
                                <td class="text-main text-bold">
                                    {{__('Order Date')}}
                                </td>
                                <td class="text-right">
                                    {{ $trx->created_at }}
                                </td>
                            </tr>
                            @php $total = 0; foreach ($trx->orders as $key => $o) { $total+=$o->grand_total; } @endphp
                            <tr>
                                <td class="text-main text-bold">
                                    {{__('Total amount')}}
                                </td>
                                <td class="text-right">
                                    {{ single_price($total) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr class="new-section-sm bord-no">
            <div class="invoice-bill row">
                <div class="col-md-12">
                    <table class="table table-sm">
                        @php $grand_total = 0; @endphp @foreach ($trx->orders as $key => $o) @php $seller = \App\User::where('id', $o->seller_id)->first(); @endphp
                        <tr class="bg-trans-dark">
                            <th class="text-uppercase" colspan="5">
                                #{{ $o->code }} {{ $seller->name }}
                            </th>
                        </tr>
                        @foreach ($o->orderDetails as $key => $od) @php $product = \App\Product::where('id', $od->product->id)->first(); @endphp @if ($od->status !== 2)
                        <tr>
                            <td>
                                <small>Decription: </small><br>
                                <strong>{{ $product->name }} - ({{ $od->quantity }} {{ $od->variation }})</strong>
                            </td>
                            <td colspan="3">
                                <small>Price: </small><br>
                                <strong>{{ single_price($od->price) }}</strong>
                            </td>
                            <td align="right">
                                <small>Total: </small><br>
                                <strong>{{ single_price($od->total) }}</strong>
                            </td>
                        </tr>
                        @endif @endforeach
                        <tr>
                            <td colspan="4" align="right">Total: </td>
                            <td align="right"><strong>{{ single_price($o->total) }}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="4" align="right">Tax (10%): </td>
                            <td align="right"><strong>{{ single_price($o->tax) }}</strong></td>
                        </tr>
                        @php $grand_total += $o->grand_total; @endphp @endforeach
                        <tr>
                            <td colspan="4" align="right">
                                Grandtotal:
                            </td>
                            <td align="right">
                                <strong>{{ single_price($grand_total) }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="right">
                                Adpoint Fee:
                            </td>
                            <td align="right">
                                <strong>{{ single_price($o->adpoint_earning) }}</strong>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="text-right no-print">
                <a href="#" class="btn btn-default"><i class="demo-pli-printer icon-lg"></i></a>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>