@foreach ($order_details as $key => $od)
    @if ($od->status === 1)
        <article class="card mt-1">
            <div style="height: 35px; background: #0f355a; color: white; border-bottom: 2px solid #fd7e14">
                <strong style="line-height: 35px; margin-left: 15px">{{ $od->created_at }}</strong>
            </div>
            <div class="table-responsive">
                <table class="table">
                    @php
                        $product = \App\Product::where('id', $od->product_id)->first();
                    @endphp
                    <tr>
                        <td>
                            <img src="{{ url(json_decode($product->photos)[0]) }}" class="img-fluid" width="50">
                        </td>
                        <td> 
                            {{ $product->name }} <br>
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
                                <div class="badge badge-success">Paid</div>
                            @else 
                                <div class="badge badge-danger">Unpaid</div>
                            @endif
                        </td>
                        <td align="right">
                            <button class="btn btn-outline-secondary btn-circle btn-sm" onclick="itemDetailsSeller({{ $od->id }})">
                                <i class="fa fa-eye"></i> Details
                            </button>
                            @if ($od->status == 1)
                                @if ($od->is_paid == true)
                                    <button data-toggle="modal" data-target="#active{{$od->id}}" class="btn btn-circle btn-sm btn-outline-primary">
                                        <i class="fa fa-calendar-check-o"></i> Activate
                                    </button>
                                @else
                                    <button type="button" class="btn btn-sm btn-circle btn-outline-primary" style="cursor: not-allowed" disabled>
                                        <i class="fa fa-calendar-check-o"></i> Activate
                                    </button>
                                @endif
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </article>

        <!-- Modal Approve-->
        <div class="modal fade" id="active{{ $od->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Are you sure activate ?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <h5>#{{ \App\Product::where('id', $od->product_id)->first()->name }}</h5>
                    <p>Clik yes to continue activate.</p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="{{ route('order.activate', encrypt($od->id)) }}" class="btn btn-primary">Yes</a>
                </div>
            </div>
            </div>
        </div>
    @endif
@endforeach