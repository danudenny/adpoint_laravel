@foreach ($order_details as $key => $od)
    @if ($od->status === 3)
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
                        <td width="80">
                            <img src="{{ url(json_decode($product->photos)[0]) }}" class="img-fluid" width="80">
                        </td>
                        <td> 
                            {{ $product->name }} <br>
                            {{ $od->variation }} 
                            <small>
                                <strong>( {{ date('d M Y', strtotime($od->start_date)) }} - {{ date('d M Y', strtotime($od->end_date)) }} )</strong>
                            </small>
                            @php
                                $query = DB::table('transactions as t')
                                            ->join('orders as o', 'o.transaction_id', '=', 't.id')
                                            ->join('order_details as od', 'od.order_id', '=', 'o.id')
                                            ->where([
                                                'od.id' => $od->id,
                                                'o.user_id' => Auth::user()->id
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
                            @php
                                $bukti = \App\Evidence::where('order_detail_id', $od->id)->first();
                            @endphp
                            @if ($bukti !== null)
                                <button onclick="showBuktiTayang({{ $bukti->id }})" class="btn btn-sm btn-circle btn-outline-success"><i class="fa fa-image"></i> Show Bukti Tayang</button>
                            @endif
                            <button onclick="itemDetails({{ $od->id }})" class="btn btn-outline-secondary btn-sm btn-circle"><i class="fa fa-eye"></i> Details</button> 
                        </td>
                    </tr>
                </table>
            </div>
        </article>
    @endif
@endforeach