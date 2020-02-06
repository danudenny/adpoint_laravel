
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
            <div class="col-md-4">
                <table class="table">
                    <tr>
                        <th>TRX</th>
                        <th> : {{ $transaction->code }}</th>
                    </tr>
                    <tr>
                        <th>Payment Status</th>
                        <th> : 
                            @if ($transaction->payment_status === 1)
                                <div class="badge badge-success">
                                    <i class="fa fa-money"></i> Paid
                                </div>
                            @else
                                <div class="badge badge-danger">
                                    <i class="fa fa-money"></i> Unpaid
                                </div>
                            @endif
                        </th>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <th> : 
                            @if ($transaction->status === "on proses")
                                <i>On Proses</i>
                            @elseif ($transaction->status === "approved")
                                <i>Approved</i>
                            @elseif ($transaction->status === "rejected")
                                <i>Rejected</i> - <i class="text-danger">{{ $transaction->is_rejected }}</i>
                            @elseif ($transaction->status === "ready")
                                <i>Checked Seller</i>
                            @elseif ($transaction->status === "confirmed")
                                <i>Confirmed</i>
                            @elseif ($transaction->status === "paid")
                                <i>Paid</i>
                            @endif
                        </th>
                    </tr>
                </table>
            </div>
            <div class="col-md-8">
                <div class="row pull-right">
                    @if ($transaction->status === "on proses")
                        <button class="btn btn-success" onclick="approve_by_admin({{ $transaction->id }})">
                            <i class="fa fa-check"></i> Approve
                        </button>
                        <button class="btn btn-danger" onclick="disapprove_by_admin({{$transaction->id}})">
                            <i class="fa fa-times"></i> Reject
                        </button>
                    @elseif ($transaction->status === "ready")
                        <button onclick="confirmToBuyer({{$transaction->id}})" class="btn btn-primary">Confirm to buyer</button>
                    @elseif ($transaction->status === "paid")
                        <a class="btn btn-primary" href="{{ route('transaction.show.invoice', encrypt($transaction->id)) }}">
                            <i class="fa fa-money"></i> Invoice
                        </a>
                        <a class="btn btn-success" href="{{ route('transaction.show.payment', $transaction->code) }}">
                            <i class="fa fa-money"></i> Change To Paid
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="modal fade" id="approve{{$transaction->id}}" tabindex="-1" role="dialog" aria-labelledby="disapproveTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Approve TRX: {{ $transaction->code }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure to approve <strong>{{ $transaction->code }}</strong> ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                    <a href="{{ route('approve.by.admin', encrypt($transaction->id)) }}" class="btn btn-primary">Yes</a>
                </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="disapprove{{$transaction->id}}" tabindex="-1" role="dialog" aria-labelledby="disapproveTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Reject TRX: {{ $transaction->code }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('disapprove.by.admin') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="trx_id" value="{{$transaction->id}}">
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
        <br>
        <div class="row">
           <div class="col-md-12">
               <div class="card">
                   <div class="card-body">
                       <div class="table-responsive">
                           <table class="table table-bordered">
                                @php
                                    $grand_total = 0;
                                @endphp
                                @foreach ($transaction->orders as $key => $o)
                                    @php
                                        $seller = \App\User::where('id', $o->seller_id)->first();
                                    @endphp
                                    <tr>
                                        <th colspan="6">
                                            Order Number: {{ $o->code }} - <span class="badge badge-primary"># {{ $seller->name }}</span>
                                        </th>
                                    </tr>
                                    @foreach ($o->orderDetails as $key => $od)
                                        @php
                                            $product = \App\Product::where('id', $od->product_id)->first();
                                        @endphp
                                        @if ($od->status == 2)
                                            <tr style="text-decoration: line-through">
                                                <td>{{ $key+1 }}</td>
                                                <td>
                                                    <i class="fa fa-fw fa-times text-danger"></i>
                                                    <small>Name: </small><br>
                                                    <strong>{{ $product->name }}</strong>
                                                </td>
                                                <td>
                                                    <small>Qty: </small><br>
                                                    <strong>{{ $od->quantity }}</strong>
                                                </td>
                                                <td>
                                                    <small>Periode: </small><br>
                                                    <strong>{{ $od->variation }}</strong>
                                                </td>
                                                <td>
                                                    <small>Price: </small><br>
                                                    <strong>{{ single_price($od->price) }}</strong>
                                                </td>
                                                <td align="right">
                                                    <small>Total: </small><br>
                                                    <strong>{{ single_price($od->total) }}</strong>
                                                </td>
                                            </tr>
                                        @else 
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>
                                                    <i class="fa fa-fw fa-check text-success"></i>
                                                    <small>Name: </small><br>
                                                    <strong>{{ $product->name }}</strong>
                                                </td>
                                                <td>
                                                    <small>Qty: </small><br>
                                                    <strong>{{ $od->quantity }}</strong>
                                                </td>
                                                <td>
                                                    <small>Periode: </small><br>
                                                    <strong>{{ $od->variation }}</strong>
                                                </td>
                                                <td>
                                                    <small>Price: </small><br>
                                                    <strong>{{ single_price($od->price) }}</strong>
                                                </td>
                                                <td align="right">
                                                    <small>Total: </small><br>
                                                    <strong>{{ single_price($od->total) }}</strong>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    <tr>
                                        <td colspan="5" align="right">Total</td>
                                        <td align="right"><strong>{{ single_price($o->total) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" align="right">Tax: (10%) </td>
                                        <td align="right"><strong>{{ single_price($o->tax) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" align="right">Subtotal: </td>
                                        <td align="right"><strong>{{ single_price($o->grand_total) }}</strong></td>
                                    </tr>
                                    @php
                                        $grand_total += $o->grand_total;
                                    @endphp
                                @endforeach
                                <tr>
                                    <td align="right" colspan="5">
                                        <h4>{{__('Grand Total')}} :</h4>
                                    </td>
                                    <td align="right">
                                        <h4>{{ single_price($grand_total) }}</h4>
                                    </td>
                                </tr>
                           </table>
                       </div>
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

        function approve_by_admin(id) {
            $('#approve'+id).modal('show');
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
