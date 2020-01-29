@if (count($order_details) > 0)
    @foreach ($order_details as $key => $od)
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
                        <td width="250"> 
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
                            <button class="btn btn-outline-secondary btn-circle btn-sm" onclick="buktiTayang({{ $od->id }})">
                                <i class="fa fa-upload"></i> Bukti Tayang
                            </button> 
                        </td>
                    </tr>
                </table>
            </div>
        </article>
    @endforeach
@else 
    @include('frontend.not_found')
@endif