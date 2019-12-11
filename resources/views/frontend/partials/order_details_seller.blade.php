<div class="modal-header">
    <h5 class="modal-title strong-600 heading-5">{{__('Order id')}}: {{ $order->code }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

@php
    $status = $order->orderDetails->first()->delivery_status;
    $payment_status = $order->orderDetails->first()->payment_status;
@endphp

<div class="modal-body gry-bg px-5 pt-0">
    <div class="pt-4">
        <ul class="process-steps clearfix">
            <li @if($order->status_order == 0) class="active" @else class="done" @endif>
                <div class="icon">1</div>
                <div class="title">{{__('Order placed')}}</div>
            </li>
            <li @if($order->status_order == 1) class="active" @elseif($order->status_order == 2 || $order->status_order == 4) class="done" @endif>
                <div class="icon">2</div>
                <div class="title">{{__('On review')}}</div>
            </li>
            <li @if($order->status_order == 2) class="active" @elseif($order->status_order == 4) class="done" @endif>
                <div class="icon">3</div>
                <div class="title">{{__('Active')}}</div>
            </li>
            <li @if($order->status_order == 4) class="done" @endif>
                <div class="icon">4</div>
                <div class="title">{{__('Completed')}}</div>
            </li>
        </ul>
    </div>
    <div class="card mt-3">
        <div class="card-header py-2 px-3 ">
        <div class="heading-6 strong-600">{{__('Order Summary')}}</div>
        </div>
        <div class="card-body pb-0">
            <div class="row">
                <div class="col-lg-6">
                    <table class="details-table table">
                        <tr>
                            <td class="w-50 strong-600">{{__('Order Number')}}:</td>
                            <td>{{ $order->code }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 strong-600">{{__('Customer')}}:</td>
                            <td>{{ json_decode($order->shipping_address)->name }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 strong-600">{{__('Email')}}:</td>
                            @if ($order->user_id != null)
                                <td>{{ $order->user->email }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td class="w-50 strong-600">{{__('Address')}}:</td>
                            <td>{{ json_decode($order->shipping_address)->address }}, {{ json_decode($order->shipping_address)->city }}, {{ json_decode($order->shipping_address)->country }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-6">
                    <table class="details-table table">
                        <tr>
                            <td class="w-50 strong-600">{{__('Order date')}}:</td>
                            <td>{{ date('d-m-Y H:m A', $order->date) }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 strong-600">{{__('Order status')}}:</td>
                            <td>
                                @if ($order->status_order == 0)
                                    <span class="badge badge-warning">Disapproved</span>
                                @elseif($order->status_order == 1)
                                    <span class="badge badge-secondary">Reviewed</span>
                                @elseif($order->status_order == 2)
                                    <span class="badge badge-primary">Approved</span>
                                @elseif($order->status_order == 3)
                                    <span class="badge badge-warning">Disapproved</span>
                                @elseif($order->status_order == 4)
                                    <span class="badge badge-success">Completed</span>
                                @elseif($order->status_order == 4)
                                    <span class="badge badge-danger">Completed</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="w-50 strong-600">{{__('Payment status')}}:</td>
                            <td>
                                @if ($order->payment_status == 'unpaid')
                                    <span class="badge badge-danger">Unpaid</span>
                                @else 
                                    <span class="badge badge-success">Paid</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="w-50 strong-600">{{__('Total order amount')}}:</td>
                            <td>Rp {{ number_format($order->orderDetails->where('seller_id', Auth::user()->id)->sum('price') + $order->orderDetails->where('seller_id', Auth::user()->id)->sum('tax')) }}</td>
                        </tr>
                        <tr>
                            <td class="w-50 strong-600">{{__('Payment method')}}:</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $order->payment_type)) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card mt-4">
                <div class="card-header py-2 px-3 heading-6 strong-600">{{__('Order Details')}}</div>
                <div class="card-body pb-0">
                    <table class="details-table table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align:center;">No.</th>
                                <th style="text-align:center;">{{__('Product')}}</th>
                                <th style="text-align:center;">{{__('Periode')}}</th>
                                <th style="text-align:center;">{{__('Quantity')}}</th>
                                <th style="text-align:center;">{{__('Price')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail)
                                <tr>
                                    <td style="text-align:center;">{{ $key+1 }}</td>
                                    <td style="text-align:center;"><a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank">{{ $orderDetail->product->name }}</a></td>
                                    <td style="text-align:center;">
                                        {{ $orderDetail->variation }}
                                    </td>
                                    <td style="text-align:center;">
                                        {{ $orderDetail->quantity }}
                                    </td>
                                    <td style="text-align:center;">Rp {{ number_format($orderDetail->price) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mt-4">
                <div class="card-header py-2 px-3 heading-6 strong-600">{{__('Order Ammount')}}</div>
                <div class="card-body pb-0">
                    <table class="table details-table">
                        <tbody>
                            <tr>
                                <th>{{__('Subtotal')}}</th>
                                <td class="text-right">
                                    <span class="strong-600">{{ number_format($order->orderDetails->where('seller_id', Auth::user()->id)->sum('price')) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>{{__('Tax 10%')}}</th>
                                <td class="text-right">
                                    <span class="text-italic">{{ single_price($order->orderDetails->where('seller_id', Auth::user()->id)->sum('tax')) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th><span class="strong-600">{{__('Total')}}</span></th>
                                <td class="text-right">
                                    <strong>
                                        <span>{{ single_price($order->orderDetails->where('seller_id', Auth::user()->id)->sum('price') + $order->orderDetails->where('seller_id', Auth::user()->id)->sum('tax') + $order->orderDetails->where('seller_id', Auth::user()->id)->sum('shipping_cost')) }}
                                        </span>
                                    </strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#update_delivery_status').on('change', function(){
        var order_id = {{ $order->id }};
        var status = $('#update_delivery_status').val();
        $.post('{{ route('orders.update_delivery_status') }}', {_token:'{{ @csrf_token() }}',order_id:order_id,status:status}, function(data){
            $('#order_details').modal('hide');
            showFrontendAlert('success', 'Order status has been updated');
            location.reload().setTimeOut(500);
        });
    });

    $('#update_payment_status').on('change', function(){
        var order_id = {{ $order->id }};
        var status = $('#update_payment_status').val();
        $.post('{{ route('orders.update_payment_status') }}', {_token:'{{ @csrf_token() }}',order_id:order_id,status:status}, function(data){
            $('#order_details').modal('hide');
            //console.log(data);
            showFrontendAlert('success', 'Payment status has been updated');
            location.reload().setTimeOut(500);
        });
    });
</script>
