@extends('layouts.app')

@section('content')

    <div class="panel">
    	<div class="panel-body">
    		<div class="invoice-masthead">
    			<div class="invoice-text">
    				<h3 class="h1 text-thin mar-no text-primary">{{ __('Invoice') }}</h3>
    			</div>
    		</div>
    		<div class="invoice-bill row">
    			<div class="col-sm-6 text-xs-center">
    				<address>
        				<strong class="text-main"></strong><br><br>
                    </address>
    			</div>
    			<div class="col-sm-6 text-xs-center">
    				<table class="invoice-details">
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
						@php
							$trx = \App\Transaction::where('id', $inv->transaction_id)->first();
						@endphp
    					<td class="text-main text-bold">
    						{{__('Order Date')}}
    					</td>
    					<td class="text-right">
    						{{ $trx->created_at }}
    					</td>
					</tr>
					@php
						$total = 0;
						foreach ($trx->orders as $key => $o) {
							$total+=$o->grand_total;
						}
					@endphp
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
    		<div class="row">
    			<div class="col-lg-12 table-responsive">
    				<table class="table table-bordered invoice-summary">

						@php
							$grand_total = 0;
						@endphp
        				@foreach ($trx->orders as $key => $o)
							@php
								$seller = \App\User::where('id', $o->seller_id)->first();
							@endphp
							<tr class="bg-trans-dark">
								<th class="text-uppercase" colspan="6">
									#{{ $o->code }} <div class="badge badge-info">{{ $seller->name }}</div>
								</th>
							</tr>
							@php
								$subtotal = 0;
								$tax = 0.1;
							@endphp
							@foreach ($o->orderDetails as $key => $od)
								@php
									$product = \App\Product::where('id', $od->product->id)->first();
									$subtotal += $od->price;
								@endphp
								<tr>
									<td>{{ $key+1 }}</td>
									<td>
										<small>Name: </small>
										<strong>{{ $product->name }}</strong>
									</td>
									<td>
										<small>Qty: </small>
										<strong>{{ $od->quantity }}</strong>
									</td>
									<td>
										<small>Periode: </small>
										<strong>{{ $od->variation }}</strong>
									</td>
									<td>
										<small>Price: </small>
										<strong>{{ single_price($product->unit_price) }}</strong>
									</td>
									<td align="right">
										<small>Total: </small>
										<strong>{{ single_price($od->price) }}</strong>
									</td>
								</tr>
							@endforeach
							<tr>
								<td colspan="5" align="right">Total</td>
								<td align="right"><strong>{{ single_price($subtotal) }}</strong></td>
							</tr>
							<tr>
								<td colspan="5" align="right">Tax: (10%) </td>
								<td align="right"><strong>{{ single_price($subtotal*$tax) }}</strong></td>
							</tr>
							<tr>
								<td colspan="5" align="right">Subtotal: </td>
								<td align="right"><strong>{{ single_price(($subtotal*$tax)+$subtotal) }}</strong></td>
							</tr>
						@php
							$grand_total+=($subtotal*$tax)+$subtotal;
						@endphp
						@endforeach
    				</table>
    			</div>
    		</div>
    		<div class="clearfix">
    			<table class="table invoice-total">
    			<tbody>
    			<tr>
    				<td>
    					<strong>{{__('Grand Total')}} :</strong>
    				</td>
    				<td class="text-bold h4" align="right">
						{{ single_price($grand_total) }}
    				</td>
    			</tr>
    			</tbody>
    			</table>
    		</div>
    		<div class="text-right no-print">
    			<a href="#" class="btn btn-default"><i class="demo-pli-printer icon-lg"></i></a>
    		</div>
    	</div>
    </div>
@endsection
