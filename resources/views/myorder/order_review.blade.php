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
                                <img width="150" src="{{ url(json_decode($product->photos)[0]) }}" class="img-fluid" width="80">
                            </td>
                            <td width="250"> 
                                <a target="_blank" href="{{ route('product', $product->slug) }}">{{ $product->name }}</a><br>
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
                                                    't.payment_status',
                                                    't.code as code_trx'
                                                ])->first();
                                @endphp
                                @if ($query->payment_status === 1)
                                    @php
                                        $cp = \App\ConfirmPayment::where('code_trx', $query->code_trx)->first();
                                    @endphp
                                    <div class="badge badge-success"><i class="fa fa-money"></i> Paid</div> | <a href="{{ url($cp->bukti) }}" download><i class="fa fa-download"></i> Bukti Transfer</a>
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
                                <button onclick="itemDetails({{ $od->id }})" class="btn btn-outline-secondary btn-sm btn-circle"><i class="fa fa-eye"></i> Details</button> 
                            </td>
                        </tr>
                        @php
                            $ap = \App\ActivatedProces::where('order_detail_id', $od->id)->first();
                        @endphp
                        @if ($ap !== null)
                            <tr>
                                <table style="width: 90%;" align="center">
                                    <tr>
                                        <td>
                                            <div class="row justify-content-center">
                                                <div class="col-10">
                                                    <div class="step-wizard">
                                                        <div class="row">
                                                            <div class="col-4 margin-top d-flex justify-content-center">
                                                                <div class="btn btn-orange btn-circles" style="top: 3px;">
                                                                    @if ($ap->status === 1 || $ap->status === 2 || $ap->status === 3)
                                                                        <div style="margin-top: -3px;">
                                                                            <i class="fa fa-check text-white"></i>
                                                                        </div>
                                                                    @else 
                                                                        <div style="margin-top: -3px;">
                                                                            <i class="fa fa-spin fa-spinner text-white"></i>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-4 margin-top d-flex justify-content-center">
                                                                <div class="btn btn-orange btn-circles" style="top: 3px;">
                                                                    @if ($ap->status === 2 || $ap->status === 3)
                                                                        <div style="margin-top: -3px;">
                                                                            <i class="fa fa-check text-white"></i>
                                                                        </div>
                                                                    @else 
                                                                        <div style="margin-top: -3px;">
                                                                            <i class="fa fa-spin fa-spinner text-white"></i>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-4 margin-top d-flex justify-content-center">
                                                                <div class="btn btn-orange btn-circles" style="top: 3px;">
                                                                    @if ($ap->status === 3)
                                                                        <div style="margin-top: -3px;">
                                                                            <i class="fa fa-check text-white"></i>
                                                                        </div>
                                                                    @else 
                                                                        <div style="margin-top: -3px;">
                                                                            <i class="fa fa-spin fa-spinner text-white"></i>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col-10">
                                                    <div class="row">
                                                        <div class="col-4 margin-b d-flex justify-content-center">
                                                            <div class="text-center mb-2">
                                                                <b>Editing Process</b><br>
                                                                @if ($ap->status === 1 || $ap->status === 2 || $ap->status === 3)
                                                                    <p>{{ date('d M Y H:i:s', strtotime($ap->time_1)) }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-4 margin-b d-flex justify-content-center">
                                                            <div class="text-center mb-2">
                                                                <b>Installation Process</b><br>
                                                                @if ($ap->status === 2 || $ap->status === 3)
                                                                    <p>{{ date('d M Y H:i:s', strtotime($ap->time_2)) }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-4 margin-b d-flex justify-content-center">
                                                            <div class="text-center mb-2">
                                                                <b>Ready to Aired</b><br>
                                                                @if ($ap->status === 3)
                                                                    <p>{{ date('d M Y H:i:s', strtotime($ap->time_3)) }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </tr>
                        @endif
                    </table>
                </div>
            </article>
        </div>
    @endforeach
@else 
    @include('frontend.not_found')
@endif