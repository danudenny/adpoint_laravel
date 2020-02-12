
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
                            @elseif ($transaction->status === 'cancelled')
                                <div class="badge badge-danger">
                                    <i class="fa fa-times"></i> Cancelled
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
                            @elseif ($transaction->status === "cancelled")
                                <i>Cancelled</i>
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
                        @php
                            $true = [];
                            $false = [];
                        @endphp
                        @foreach (\App\Transaction::where('id', $transaction->id)->get() as $key => $t)
                            @foreach ($t->orders as $key => $o)
                                @foreach ($o->orderDetails as $key => $od)
                                    @php
                                        array_push($false, $od->is_confirm);
                                    @endphp
                                    @if ($od->is_confirm === 1)
                                        @php
                                            array_push($true, $od->is_confirm);
                                        @endphp
                                    @endif
                                @endforeach
                            @endforeach
                        @endforeach
                        @if (count($true) === count($false))
                            <button onclick="confirmToBuyer({{$transaction->id}})" class="btn btn-primary">Confirm</button>
                        @endif
                    @elseif ($transaction->status === "paid")
                        <a class="btn btn-primary" href="{{ route('transaction.show.invoice', encrypt($transaction->id)) }}">
                            <i class="fa fa-money"></i> Invoice
                        </a>
                        @if ($transaction->payment_status !== 1)
                            <a class="btn btn-success" href="{{ route('transaction.show.payment', $transaction->code) }}">
                                <i class="fa fa-money"></i> Mark as paid
                            </a>
                        @else 
                            <a class="btn btn-success" href="{{ route('transaction.show.payment', $transaction->code) }}">
                                <i class="fa fa-money"></i> View
                            </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="modal fade" id="approve{{$transaction->id}}" tabindex="-1" role="dialog" aria-labelledby="disapproveTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="width: 300px" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">#Approval </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h3>Are you sure to approve ?</h3>
                        <strong># {{ $transaction->code  }}</strong>
                        <div style="margin-top: 30px">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <a href="{{ route('approve.by.admin', encrypt($transaction->id)) }}" class="btn btn-primary">Yes, approve</a>
                        </div>
                    </div>
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
                                @foreach ($transaction->orders as $key => $o)
                                    @php
                                        $seller = \App\User::where('id', $o->seller_id)->first();
                                    @endphp
                                    <tr>
                                        <th colspan="6">
                                            Order Number: {{ $o->code }} - <span class="badge badge-primary"># {{ $seller->name }}</span>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>Description</th>
                                        <th>File Advertising</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th></th>
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
                                                    <strong>{{ $product->name }}</strong> ( <strong>{{ $od->quantity }}</strong> <i><strong>{{ $od->variation }}</strong></i>) 
                                                </td>
                                                <td>
                                                    @php
                                                        $file = json_decode($od->file_advertising);
                                                    @endphp
                                                    @if ($file !== null)
                                                        @if ($file->gambar !== null)
                                                            @foreach ($file->gambar as $key => $g)
                                                                <b><a href="{{ url($g) }}" download>Gambar {{ $key+1 }}</a></b> <br>
                                                            @endforeach
                                                        @endif
                                                        @if ($file->video !== null)
                                                            @foreach ($file->video as $key => $v)
                                                                <b><a href="{{ url($v) }}" download>Video {{ $key+1 }}</a></b> <br>
                                                            @endforeach
                                                        @endif
                                                    @endif                                                   
                                                </td>
                                                <td>
                                                    <strong>{{ single_price($od->price) }}</strong>
                                                </td>
                                                <td align="right">
                                                    <strong>{{ single_price($od->total) }}</strong>
                                                </td>
                                                <td>
                                                    @if ($od->is_confirm == 0)
                                                        <button data-toggle="tooltip" title="Details" onclick="rejectDetail({{ $od->id }})" class="btn btn-sm btn-primary">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @else 
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>
                                                    <i class="fa fa-fw fa-check text-success"></i>
                                                    <strong>{{ $product->name }}</strong> ( <strong>{{ $od->quantity }}</strong> <i><strong>{{ $od->variation }}</strong></i>) 
                                                </td>
                                                <td>
                                                    @php
                                                        $file = json_decode($od->file_advertising);
                                                    @endphp
                                                    @if ($file !== null)
                                                        @if ($file->gambar !== null)
                                                            @foreach ($file->gambar as $key => $g)
                                                                <b><a href="{{ url($g) }}" download>Gambar {{ $key+1 }}</a></b> <br>
                                                            @endforeach
                                                        @endif
                                                        @if ($file->video !== null)
                                                            @foreach ($file->video as $key => $v)
                                                                <b><a href="{{ url($v) }}" download>Video {{ $key+1 }}</a></b> <br>
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong>{{ single_price($od->price) }}</strong>
                                                </td>
                                                <td align="right">
                                                    <strong>{{ single_price($od->total) }}</strong>
                                                </td>
                                                <td></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
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

<div class="modal fade" id="rejectDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
        <div class="modal-content position-relative">
            <div id="rejectDetailbody">

            </div>
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

        function rejectDetail(id) {
            $('#rejectDetailbody').html(null);
            $('#rejectDetail').modal();
            $.post('{{ route('reject.detail') }}', {_token:'{{ csrf_token() }}', order_detail_id:id}, function(data){
                $('#rejectDetailbody').html(data);
            });
        }
    </script>
@endsection
