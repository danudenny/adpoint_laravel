@if (count($order_details) > 0)
    @foreach ($order_details as $key => $od)
        <div style="border-bottom: 1px solid #ccc">
            <article class="card no-border mt-1">
                <div class="table-responsive">
                    <table class="table">
                        @php
                            $product = \App\Product::where('id', $od->product_id)->first();
                        @endphp
                        <tr>
                            <td width="100">
                                <img width="150" src="{{ url(json_decode($product->photos)[0]) }}" class="img-fluid" width="50">
                            </td>
                            <td width="250"> 
                                <a target="_blank" href="{{ route('product', $product->slug) }}">{{ $product->name }}</a><br>
                                {{ $od->variation }} 
                                <small>
                                    ( {{ date('d M Y', strtotime($od->start_date)) }} - {{ date('d M Y', strtotime($od->end_date)) }} ) 
                                </small>
                                @php
                                    $query = DB::table('transactions as t')
                                                ->join('orders as o', 'o.transaction_id', '=', 't.id')
                                                ->join('order_details as od', 'od.order_id', '=', 'o.id')
                                                ->where([
                                                    'od.id' => $od->id,
                                                    'o.seller_id' => Auth::user()->id
                                                ])
                                                ->select([
                                                    't.payment_status'
                                                ])->first();
                                @endphp
                                @if ($query->payment_status === 1)
                                    <div class="badge badge-success"><i class="fa fa-money"></i> Paid</div>
                                @else 
                                    <div class="badge badge-danger"><i class="fa fa-money"></i> Unpaid</div>
                                @endif
                            </td>
                            <td width="200">
                                <div style="font-size: 11px;">
                                    Date: <br>
                                    {{ date('d M Y H:i:s', strtotime($od->created_at)) }}
                                </div>
                            </td>
                            <td align="right">
                                <button data-toggle="modal" data-target="#approve{{$od->id}}" class="btn btn-outline-success btn-circle btn-sm"><i class="fa fa-check"></i> Approve</button>
                                <button data-toggle="modal" data-target="#reject{{$od->id}}" class="btn btn-sm btn-circle btn-outline-danger">
                                    <i class="fa fa-times"></i> Reject
                                </button>
                                <button class="btn btn-outline-secondary btn-circle btn-sm" onclick="itemDetailsSeller({{ $od->id }})">
                                    <i class="fa fa-eye"></i> Details
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </article>
        </div>
        <!-- Modal Approve-->
        <div class="modal fade" id="approve{{ $od->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Are you sure approve ?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <h5>#{{ \App\Product::where('id', $od->product_id)->first()->name }}</h5>
                    <p>Clik yes to continue approve.</p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="{{ route('approve.by.seller', encrypt($od->id)) }}" class="btn btn-primary">Yes</a>
                </div>
            </div>
            </div>
        </div>
        <!-- Modal Reject -->
        <div class="modal fade" id="reject{{ $od->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form action="{{ route('disapprove.by.seller') }}" method="POST">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Reject item {{ $product->name }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                @csrf
                                <input type="hidden" name="od_id" value="{{$od->id}}">
                                <label>Alasan</label>
                                <textarea name="alasan" class="form-control" placeholder="Tuliskan alasan" cols="20" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
@else 
    @include('frontend.not_found')
@endif