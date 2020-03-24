<style>
    .nav-cus {
        border: none !important;
        border-top-left-radius: 0 !important;
        border-top-right-radius: 0 !important;
        color: black !important;
        background: #ffc107;
    }
</style>
@php
    if (Auth::user()->user_type == "customer") {
        $orderPlacedB = orders_notif('customer', 0, 'o.user_id')->count();
        $orderOnReviewedB = orders_notif('customer', 1, 'o.user_id')->count();
        $orderActivedB = orders_notif('customer', 3, 'o.user_id')->count();
        $orderCompletedB = orders_notif('customer', 4, 'o.user_id')->count();
        $orderCancelledB = orders_notif('customer', 2, 'o.user_id')->count();
    }
    if (Auth::user()->user_type == "seller") {
        $orderPlacedS = orders_notif('seller', 0, 'o.seller_id')->count();
        $orderOnReviewedS = orders_notif('seller', 1, 'o.seller_id')->count();
        $orderActivedS = orders_notif('seller', 3, 'o.seller_id')->count();
        $orderCompletedS = orders_notif('seller', 4, 'o.seller_id')->count();
        $orderCancelledS = orders_notif('seller', 2, 'o.seller_id')->count();
    }
    $trxUnpaid = trx_notif(0, Auth::user()->id)->count();
    $trxPaid = trx_notif(1, Auth::user()->id)->count();
@endphp
<div class="dropdown-cart-items no-border c-scrollbar">
    <div class="tabs tabs--style-2">
        <div class="nav nav-justified nav-tabs" onclick="changeTab(event)" id="myTab" role="tablist">
            <a class="nav-link nav-item active" id="notif-buyer-tab" data-url="{{ route('notif.buyer') }}" data-toggle="tab" href="#notif-buyer" role="tab" aria-controls="notif-buyer" aria-selected="true">
                Purchase 
                @if (Auth::user()->user_type == "customer")
                    @if($orderPlacedB > 0 || $orderOnReviewedB > 0 || $orderActivedB > 0 || $orderCompletedB > 0 || $orderCancelledB > 0)
                        <span class="badge badge-danger badge-pill">
                            {{ $orderPlacedB+$orderOnReviewedB+$orderActivedB+$orderCompletedB+$orderCancelledB }}
                        </span>
                    @endif
                @endif
            </a>
            @if (Auth::user()->user_type == "seller")
                <a class="nav-link nav-item" id="notif-seller-tab" data-url="{{ route('notif.seller') }}" data-toggle="tab" href="#notif-seller" role="tab" aria-controls="notif-seller" aria-selected="false">
                    Sales
                    @if($orderPlacedS > 0 || $orderOnReviewedS > 0 || $orderActivedS > 0 || $orderCompletedS > 0 || $orderCancelledS > 0)
                        <span class="badge badge-danger badge-pill">
                            {{ $orderPlacedS+$orderOnReviewedS+$orderActivedS+$orderCompletedS+$orderCancelledS }}
                        </span>
                    @endif
                </a>
            @endif
            {{-- <a class="nav-link nav-item" id="notif-trx-tab" data-url="{{ route('notif.trx') }}" data-toggle="tab" href="#notif-trx" role="tab" aria-controls="notif-trx" aria-selected="false">
                Transaction
                @if ($trxUnpaid > 0 || $trxPaid > 0)
                    <span class="badge badge-danger badge-pill">
                        {{ $trxUnpaid+$trxPaid }}
                    </span>
                @endif
            </a> --}}
            <a class="nav-link nav-item" id="notif-update-tab" data-url="{{ route('notif.update') }}" data-toggle="tab" href="#notif-update" role="tab" aria-controls="notif-trx" aria-selected="false">
                Update
                @php
                    $user = Auth::user();
                @endphp
                @if ($user->unreadNotifications->count() > 0)
                    <span class="badge badge-danger badge-pill">
                        {{ $user->unreadNotifications->count() }}
                    </span>
                @endif
            </a>
        </div>
        <div class="tab-content p-0" id="myTabContent">
            <div class="tab-pane fade show active" id="notif-buyer" role="tabpanel" aria-labelledby="notif-buyer-tab">
                <div class="c-notif-load">
                    <div class="ph-item border-0 p-0 mt-3">
                        <div class="ph-col-12">
                            <div class="ph-row">
                                <div class="ph-col-12 big"></div>
                                <div class="ph-col-12 big"></div>
                                <div class="ph-col-12 big"></div>
                                <div class="ph-col-12 big"></div>
                                <div class="ph-col-12 big"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (Auth::user()->user_type == "seller")
            <div class="tab-pane fade" id="notif-seller" role="tabpanel" aria-labelledby="notif-seller-tab">
                <div class="c-notif-load">
                    <div class="ph-item border-0 p-0 mt-3">
                        <div class="ph-col-12">
                            <div class="ph-row">
                                <div class="ph-col-12 big"></div>
                                <div class="ph-col-12 big"></div>
                                <div class="ph-col-12 big"></div>
                                <div class="ph-col-12 big"></div>
                                <div class="ph-col-12 big"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            {{-- <div class="tab-pane fade" id="notif-trx" role="tabpanel" aria-labelledby="notif-trx-tab">
                <div class="c-notif-load">
                    <div class="ph-item border-0 p-0 mt-3">
                        <div class="ph-col-12">
                            <div class="ph-row">
                                <div class="ph-col-12 big"></div>
                                <div class="ph-col-12 big"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="tab-pane fade" id="notif-update" role="tabpanel" aria-labelledby="notif-update-tab">
                <div class="c-notif-load">
                    <div class="ph-item border-0 p-0 mt-3">
                        <div class="ph-col-12">
                            <div class="ph-row">
                                <div class="ph-col-12 big"></div>
                                <div class="ph-col-12 big"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="py-2 text-right dc-btn" style="border-top: 1px solid orange">
    <ul class="inline-links inline-links--style-3">
        <li class="px-1">
            <a class="btn btn-secondary btn-sm btn-circle px-3 py-1 text-white" onclick="closeNotif()">
                <i class="fa fa-times"></i> {{__('Close')}}
            </a>
        </li>
    </ul>
</div>

<script>
    $('#notif-buyer').load('{{ route('notif.buyer') }}',function(result){
        $(this).tab('show');
    });
    function changeTab(e) {
        e.preventDefault();
        var url = $(e.target).attr("data-url");
        var href = e.target.hash;
        var pane = $(e.target);

        // ajax load from data-url
        $('.c-notif-load').show();
        $(href).load(url,function(result){
            pane.tab('show');
            $('.c-notif-load').hide();
        });
    }
</script>