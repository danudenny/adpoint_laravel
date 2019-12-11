@extends('layouts.app')

@section('content')

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('orders')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Order Code</th>
                    <th>Num. of Products</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Payment Status</th>
                    <th>Order Status</th>
                    <th width="10%">{{__('options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $key => $order)
                    <tr>
                        <td>
                            {{ $key+1 }}
                        </td>
                        <td>
                            {{ $order->code }}
                        </td>
                        <td>
                            {{ count($order->orderDetails) }}
                        </td>
                        <td>
                            @if ($order->user_id != null)
                                {{ $order->user->name }}
                            @else
                                Guest ({{ $order->guest_id }})
                            @endif
                        </td>
                        <td>
                            {{ single_price($order->grand_total) }}
                        </td>
                        <td>
                            <span class="badge badge--2 mr-4">
                                @if ($order->payment_status == 'paid')
                                    <i class="bg-green"></i> Paid
                                @else
                                    <i class="bg-red"></i> Unpaid
                                @endif
                            </span>
                        </td>
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
                        <td>
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                    {{__('Actions')}} <i class="dropdown-caret"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    @if ($order->status_order == 0)
                                        <li><a href="{{ route('approve.by.admin', encrypt($order->id)) }}">{{__('Approve')}}</a></li>
                                        <li><a style="cursor: pointer;" onclick="disapprove_by_admin({{$order->id}})">{{__('Disapprove')}}</a></li>
                                    @elseif($order->status_order == 2)
                                        <li><a href="{{ route('show.payment', encrypt($order->id)) }}">{{__('Show Payment')}}</a></li>
                                    @endif
                                    <li><a style="cursor: pointer;" onclick="confirm_modal('{{route('orders.destroy', $order->id)}}');">{{__('Delete')}}</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                <div class="modal fade" id="disapprove{{$order->id}}" tabindex="-1" role="dialog" aria-labelledby="disapproveTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Disapprove</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('disapprove.by.admin') }}" method="get">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="order_id" value="{{$order->id}}">
                                <label>Alasan</label>
                                <textarea name="alasan" class="form-control" placeholder="Tuliskan alasan" cols="20" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    </div>
                </div>
                </div>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection


@section('script')
    <script type="text/javascript">
        function disapprove_by_admin(id){
            $('#disapprove'+id).modal('show');
        }
    </script>
@endsection
