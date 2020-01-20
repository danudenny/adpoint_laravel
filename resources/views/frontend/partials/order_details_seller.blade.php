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
        @php
            $order_detail = \App\OrderDetail::where('order_id', $order->id)->count();
            $order_detail_complete = \App\OrderDetail::where(['order_id' => $order->id, 'complete' => 1])->count();
        @endphp
        <ul class="process-steps clearfix">
            <li @if($order->status_order == 0) class="active" @else class="done" @endif>
                <div class="icon">1</div>
                <div class="title">{{__('Order placed')}}</div>
            </li>
            <li @if($order->status_order == 1) class="active" @elseif($order->status_order == 2 || $order->status_order == 4 || ($order->status_order == 5 && $order_detail == $order_detail_complete)) class="done" @endif>
                <div class="icon">2</div>
                <div class="title">{{__('On review')}}</div>
            </li>
            <li @if($order->status_order == 2) class="active" @elseif($order->status_order == 4 || ($order->status_order == 5 && $order_detail == $order_detail_complete)) class="done" @endif>
                <div class="icon">3</div>
                <div class="title">{{__('Active')}}</div>
            </li>
            <li @if($order->status_order == 5 && $order_detail == $order_detail_complete) class="done" @endif>
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
                                    <span class="badge badge-warning">Disapproved by admin</span>
                                @elseif($order->status_order == 1)
                                    <span class="badge badge-secondary">Reviewed</span>
                                @elseif($order->status_order == 2)
                                    <span class="badge badge-primary">Approved</span>
                                @elseif($order->status_order == 3)
                                    <span class="badge badge-warning">Disapproved by seller</span>
                                @elseif ($order->status_order == 4)
                                    <span class="badge badge-info">Aired</span>
                                @elseif ($order->status_order == 5)
                                    <span class="badge badge-success">Complete</span>
                                @elseif ($order->status_order == 6)
                                    <span class="badge badge-danger">Cancelled</span>
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
                        <tr>
                            <td class="w-50 strong-600">{{__('Materi Advertising')}}</td>
                            <td>
                                @if ($order->file_advertising != null)
                                    @php
                                        $data = json_decode($order->file_advertising);
                                    @endphp                                
                                    @if ($data->gambar != null)
                                        @foreach ($data->gambar as $key => $item)
                                            <span class="badge badge-info"><a target="_blank" href="{{ $item }}" download>Gambar {{ $key+1 }}</a></span>
                                        @endforeach
                                    @endif
                                    @if ($data->video != null)
                                        @foreach ($data->video as $key => $item)
                                            <span class="badge badge-success"><a target="_blank" href="{{ $item }}" download>Video {{ $key+1 }}</a></span>
                                        @endforeach
                                    @endif
                                    @if ($data->zip != null)
                                        @foreach ($data->zip as $key => $item)
                                            <span class="badge badge-danger"><a target="_blank" href="{{ $item }}" download>Zip {{ $key+1 }}</a></span>
                                        @endforeach
                                    @endif
                                @endif
                            </td>
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
                                <th style="text-align:center;">{{__('Option')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderDetails->where('seller_id', Auth::user()->id) as $key => $orderDetail)
                                <tr>
                                    <td style="text-align:center;">{{ $key+1 }}</td>
                                    <td style="text-align:center;"><a href="{{ route('product', $orderDetail->product->slug) }}" target="_blank">{{ $orderDetail->product->name }}</a></td>
                                    <td style="text-align:center;">
                                        <div class="badge badge-primary" style="cursor: pointer" data-toggle="tooltip" data-placement="bottom" title="{{ date('d M Y', strtotime($orderDetail->start_date)).' s/d '.date('d M Y', strtotime($orderDetail->end_date)) }}">
                                            {{ $orderDetail->variation }}
                                        </div>
                                    </td>
                                    <td style="text-align:center;">
                                        {{ $orderDetail->quantity }}
                                    </td>
                                    <td style="text-align:center;">Rp {{ number_format($orderDetail->price) }}</td>
                                    <td>
                                        @php
                                            $end_date = strtotime($orderDetail->end_date);
                                            $end = date('d M Y', $end_date);
                                            $current_date = strtotime('now');
                                            $current = date('d M Y', $current_date);
                                        @endphp
                                        @if ($end == $current)
                                            @if ($orderDetail->complete == 1)
                                                <div class="badge badge-success">Done</div>
                                            @else 
                                                <a href="{{ route('order.complete', encrypt($orderDetail->id)) }}" class="btn btn-primary btn-sm">Complete</a>
                                            @endif
                                        @else 
                                            <button class="btn btn-default btn-sm" style="cursor: not-allowed" disabled>Complete</button>
                                        @endif
                                    </td>
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
