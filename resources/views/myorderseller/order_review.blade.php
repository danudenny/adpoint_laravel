
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
                                <img src="{{ url(json_decode($product->photos)[0]) }}" class="img-fluid" width="50">
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
                                @if ($od->status == 1)
                                    @if ($od->is_paid == true)
                                        @php
                                            $ap = \App\ActivatedProces::where('order_detail_id', $od->id)->first();
                                        @endphp
                                        @if ($ap !== null)
                                            @if ($ap->status === 3)
                                                <button data-toggle="modal" data-target="#active{{$od->id}}" class="btn btn-circle btn-sm btn-outline-primary">
                                                    <i class="fa fa-calendar-check-o"></i> Activate
                                                </button>
                                            @else 
                                                <button type="button" class="btn btn-sm btn-circle btn-outline-primary" style="cursor: not-allowed" disabled>
                                                    <i class="fa fa-calendar-check-o"></i> Activate
                                                </button>
                                            @endif
                                        @endif
                                    @endif
                                @endif
                                <button class="btn btn-outline-secondary btn-circle btn-sm" onclick="itemDetailsSeller({{ $od->id }})">
                                    <i class="fa fa-eye"></i> Details
                                </button>
                            </td>
                        </tr>
                        @php
                            $ap = \App\ActivatedProces::where('order_detail_id', $od->id)->first();
                        @endphp
                        @if ($ap !== null)
                            <tr>
                                <table style="width: 80%" align="center">
                                    <tr>
                                        <td>
                                            <div class="row justify-content-center">
                                                
                                                <div class="col-12">
                                                    <div class="step-wizard">
                                                        <div class="row">
                                                            <div class="col-4 margin-top d-flex justify-content-center">
                                                                <label class="checkbox">
                                                                    <input id="editing" onchange="editingProcess(event, {{ $od->id }})" type="checkbox" @if ($ap->status === 1 || $ap->status === 2 || $ap->status === 3) checked disabled @endif>
                                                                    <span id="ec" class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                            <div class="col-4 margin-top d-flex justify-content-center">
                                                                <label class="checkbox">
                                                                    <input id="install" onchange="installationProcess(event, {{ $od->id }})" type="checkbox" @if ($ap->status === 2 || $ap->status === 3) checked disabled @endif>
                                                                    <span id="ic" class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                            <div class="col-4 margin-top d-flex justify-content-center">
                                                                <label class="checkbox">
                                                                    <input id="done" onchange="doneProcess(event, {{ $od->id }})" type="checkbox" @if ($ap->status === 3) checked disabled @endif>
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
                                        </td>
                                    </tr>
                                </table>
                            </tr>
                        @endif
                    </table>
                </div>
            </article>
        </div>
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
    @endforeach
@else
    @include('frontend.not_found')
@endif

<div style="cursor: not-allowed">

</div>

<script>
    function editingProcess(e, id) {
        e.preventDefault();
        postStatus(id, 1);
        $('#editing').prop('disabled', true);
    }
    function installationProcess(e, id) {
        e.preventDefault();
        postStatus(id, 2);
        $('#install').prop('disabled', true);
    }
    function doneProcess(e, id) {
        e.preventDefault();
        postStatus(id, 3);
        $('#done').prop('disabled', true);
    }

    function postStatus(id, status) {
        $.ajax({
            url: '{{ route('post.process.active') }}',
            method: 'POST',
            dataType: 'JSON',
            data: {
                _token:'{{ csrf_token() }}',
                order_detail_id : id,
                status : status
            },
            success: function(result) {
                if (result === 1) {
                    switch (status) {
                        case 1:
                            showFrontendAlert('success', 'Editing process done!');
                            break;
                        case 2:
                            showFrontendAlert('success', 'Installation process done!');
                            break;
                        case 3:
                            showFrontendAlert('success', 'Process done!');
                            break;
                        default:
                            break;
                    }
                }
            },
            error: function(err){
                if (err === 0) {
                    showFrontendAlert('error', 'Something wrong!');
                }
            }
        })
    }
</script>