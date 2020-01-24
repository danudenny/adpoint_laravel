
@extends('layouts.app')

@section('content')

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Transaction Detail')}}</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-bold">Code: {{ $details->code }}</h4>
                <div>
                    <i>Payment status:</i>
                    @if ($details->payment_status === "1")
                        <div class="badge badge-success">Paid</div>
                    @else
                        <div class="badge badge-danger">Unpaid</div>
                    @endif
                </div>
                @if ($details->status === "ready")
                    <br>
                    <div>
                        <a onclick="confirmToBuyer({{$details->id}})" class="btn btn-primary">Confirm to buyer</a>
                    </div>
                @elseif ($details->status === "confirmed")
                    <br>
                    <div>
                        <div class="badge badge-success">Confirmed</div>
                    </div>
                @elseif ($details->status === "paid")
                    <br>
                    <div>
                        <a class="btn btn-primary" href="{{ route('transaction.show.invoice', encrypt($details->id)) }}"><i class="fa fa-eye"></i> {{__('Show Invoice')}}</a>
                        <a class="btn btn-success" href="{{ route('transaction.show.payment', $details->code) }}"><i class="fa fa-money"></i> {{__('Paid')}}</a>
                    </div>
                @endif
            </div>
        </div>
        <br>
        <div class="row">
           <div class="col-md-12">
            @if (Session::has('message'))
                <div class="alert alert-success">
                    {!! session('message') !!}
                </div>
            @endif
               <div class="card">
                   <div class="card-body">
                    @php
                        $order = \App\Order::where('transaction_id', $details->id)->get();
                    @endphp 
                    @foreach ($order as $no => $o)
                        <div style="height: 50px; background: #303641; color: white; border-bottom: 2px solid #fd7e14">
                            <div style="line-height: 50px; margin-left: 15px">
                                <strong style="float: left">Order ID: {{ $o->code }}</strong>
                                <div style="float: right">
                                    @if ($o->approved === 2)
                                        <strong style="margin-right: 10px"><div class="badge badge-danger">Rejected</div></strong>
                                    @else 
                                        @if ($o->approved === 0)
                                            <a class="btn btn-default" href="{{ route('approve.by.admin', encrypt($o->id)) }}" style="margin-right: 4px">Approve</a>
                                            <a style="cursor: pointer; margin-right: 10px;" onclick="disapprove_by_admin({{$o->id}})">
                                                <div class="badge badge-danger">{{__('Reject')}}</div>
                                            </a>
                                        @else 
                                            <strong style="margin-right: 10px"><div class="badge badge-success">Approved</div></strong>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="disapprove{{$o->id}}" tabindex="-1" role="dialog" aria-labelledby="disapproveTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Reject ORDER-ID: {{ $o->code }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('disapprove.by.admin') }}" method="get">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="order_id" value="{{$o->id}}">
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
                        <table class="table table-bordered">
                            @php
                                $orderDetail = \App\OrderDetail::where('order_id', $o->id)->get();
                            @endphp
                            @foreach ($orderDetail as $key => $od)
                                @php
                                    $product = \App\Product::where('id',$od->product_id)->first();
                                @endphp
                                <tr>
                                    <td width="50"> 
                                        <img src="{{ url(json_decode($product->photos)[0]) }}" class="img-sm border">
                                    </td>
                                    <td width="250"> 
                                        <p class="title mb-0">{{ $product->name }}</p>
                                        <var class="price text-muted">Rp. {{ number_format($od->price,2,",",".") }}</var>
                                    </td>
                                    <td width="250"> Seller <br>{{ \App\User::where('id', $od->seller_id)->first()->name }}</td>
                                    <td>
                                        Status: <br>
                                        @if ($od->status == 1)
                                            <div class="badge badge-success">Approved</div>
                                        @elseif ($od->status == 2)
                                            <div class="badge badge-danger">Rejected</div> " <strong class="text-danger">{{ $od->rejected }}</strong> "
                                        @elseif ($od->status == 0)
                                            <div class="badge badge-info" data-toggle="tooltip" data-placement="top" title="Being checked seller">On progres</div>
                                        @elseif ($od->status == 100)
                                            <div class="badge badge-danger">Rejected</div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @endforeach
                   </div>
               </div>
           </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmToBuyer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div id="confirm-modal-body">

        </div>
    </div>
</div>

@endsection

@section('script')
    <script>
        function disapprove_by_admin(id) {
            $('#disapprove'+id).modal('show');
        }

        function confirmToBuyer(id) {
            $('#confirm-modal-body').html(null);
            $.post('{{ route('confirm.to.buyer') }}', { _token : '{{ @csrf_token() }}', trx_id : id}, function(data){
                $('#confirm-modal-body').html(data);
                $('#confirmToBuyer').modal();
            });
        }
    </script>
@endsection
