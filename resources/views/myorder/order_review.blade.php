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
                            <td width="80">
                                <img src="{{ url(json_decode($product->photos)[0]) }}" class="img-fluid" width="80">
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
                                    <div class="badge badge-success"><i class="fa fa-money"></i> Paid</div> | <a href="{{ url($cp->bukti) }}" target="_blank">Bukti Transfer</a>
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
                                <button data-toggle="collapse" data-target="#proses-active{{ $od->id }}" aria-expanded="false" aria-controls="collapseExample" class="btn btn-circle btn-sm btn-outline-primary">
                                    <i class="fa fa-spinner"></i> View Proses
                                </button>
                                <button onclick="itemDetails({{ $od->id }})" class="btn btn-outline-secondary btn-sm btn-circle"><i class="fa fa-eye"></i> Details</button> 
                            </td>
                        </tr>
                        <tr>
                            <table class="table">
                                <tr>
                                    <td>
                                        <div class="collapse" id="proses-active{{ $od->id }}">
                                            <div class="card mt-2" style="border-radius: 0; background: #fbfbfb">
                                                <div class="card-body">
                                                    <div class="row justify-content-center">
                                                        @php
                                                            $ap = \App\ActivatedProces::where('order_detail_id', $od->id)->first();
                                                        @endphp
                                                        <div class="col-12">
                                                            <div class="step-wizard">
                                                                <div class="row">
                                                                    <div class="col-4 margin-top d-flex justify-content-center">
                                                                        <label class="checkbox">
                                                                            <input id="editing" type="checkbox" @if ($ap->status === 1 || $ap->status === 2 || $ap->status === 3) checked disabled @endif>
                                                                            <span id="ec" class="checkmark"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-4 margin-top d-flex justify-content-center">
                                                                        <label class="checkbox">
                                                                            <input id="install" type="checkbox" @if ($ap->status === 2 || $ap->status === 3) checked disabled @endif>
                                                                            <span id="ic" class="checkmark"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-4 margin-top d-flex justify-content-center">
                                                                        <label class="checkbox">
                                                                            <input id="done" type="checkbox" @if ($ap->status === 3) checked disabled @endif>
                                                                            <span id="dc" class="checkmark"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center">
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <div class="col-4 margin-b d-flex justify-content-center">
                                                                    <div class="text-center">
                                                                        <b>Editing Process</b><br>
                                                                        @if ($ap->status === 1 || $ap->status === 2 || $ap->status === 3)
                                                                            <p>{{ date('d M Y H:i:s', strtotime($ap->time_1)) }}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-4 margin-b d-flex justify-content-center">
                                                                    <div class="text-center">
                                                                        <b>Installation Process</b><br>
                                                                        @if ($ap->status === 2 || $ap->status === 3)
                                                                            <p>{{ date('d M Y H:i:s', strtotime($ap->time_2)) }}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-4 margin-b d-flex justify-content-center">
                                                                    <div class="text-center">
                                                                        <b>Ready to Aired</b><br>
                                                                        @if ($ap->status === 3)
                                                                            <p>{{ date('d M Y H:i:s', strtotime($ap->time_3)) }}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </tr>
                    </table>
                </div>
            </article>
        </div>
    @endforeach
@else 
    @include('frontend.not_found')
@endif