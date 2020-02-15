
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
                                @if ($od->status == 1)
                                    @if ($od->is_paid == true)
                                        @php
                                            $ap = \App\ActivatedProces::where('order_detail_id', $od->id)->first();
                                        @endphp
                                        @if ($ap !== null)
                                            @if ($ap->status === 3)
                                                <button onclick="activateItem({{ $od->id }})" class="btn btn-circle btn-sm btn-outline-primary">
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
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-4 margin-b d-flex justify-content-center">
                                                            <div class="text-center">
                                                                <b>Editing Process</b><br>
                                                                @if ($ap->status === 1 || $ap->status === 2 || $ap->status === 3)
                                                                    <p>{{ date('d M Y H:i:s', strtotime($ap->time_1)) }}</p>
                                                                @else
                                                                    <button onclick="editingProcess(event, {{ $od->id }})" class="mt-2 mb-2 btn btn-sm btn-circle btn-outline-success">
                                                                        <i class="fa fa-check-circle"></i> Done
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-4 margin-b d-flex justify-content-center">
                                                            <div class="text-center">
                                                                <b>Installation Process</b><br>
                                                                @if ($ap->status === 2 || $ap->status === 3)
                                                                    <p>{{ date('d M Y H:i:s', strtotime($ap->time_2)) }}</p>
                                                                @else 
                                                                    <button onclick="installationProcess(event, {{ $od->id }})" class="mt-2 mb-2 btn btn-sm btn-circle btn-outline-success">
                                                                        <i class="fa fa-check-circle"></i> Done
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-4 margin-b d-flex justify-content-center">
                                                            <div class="text-center">
                                                                <b>Ready to Aired</b><br>
                                                                @if ($ap->status === 3)
                                                                    <p>{{ date('d M Y H:i:s', strtotime($ap->time_3)) }}</p>
                                                                @else 
                                                                    <button onclick="doneProcess(event, {{ $od->id }})" class="mt-2 mb-2 btn btn-sm btn-circle btn-outline-success">
                                                                        <i class="fa fa-check-circle"></i> Done
                                                                    </button>
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

<div style="cursor: not-allowed">

</div>

<script>
    function activateItem(id) {
        if (confirm('Are you sure to activate?')) {
            localStorage.setItem('activeTabSeller', '#nav-active');
            localStorage.setItem('routeTabSeller', '{{ route('orders.active.order') }}');
            location.reload();
            $.post('{{ route('order.activate') }}', {_token:'{{ csrf_token() }}', id:id}, function(result) {
                var activeTab = localStorage.getItem('activeTabSeller');
                if(activeTab !== null){
                    var routeTab = localStorage.getItem('routeTabSeller')
                    $('a[href="'+activeTab+'"]').addClass('active');
                    $(activeTab).load(routeTab,function(result){
                        $(activeTab).addClass('show');
                        $(activeTab).addClass('active');
                        $('.c-nav-load').hide();
                    });
                }
            });
        }
    }

    function editingProcess(e, id) {
        postStatus(id, 1);
    }
    function installationProcess(e, id) {
        postStatus(id, 2);
    }
    function doneProcess(e, id) {
        postStatus(id, 3);
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
                            location.reload();
                            break;
                        case 2:
                            showFrontendAlert('success', 'Installation process done!');
                            location.reload();
                            break;
                        case 3:
                            showFrontendAlert('success', 'Process done!');
                            location.reload();
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