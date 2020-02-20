@php
    $orderPlaced = DB::table('orders as o')
                -> join('order_details as od', 'o.seller_id', '=', 'od.seller_id')
                -> join('products as p', 'p.id', '=', 'od.product_id')
                -> orderBy('od.id', 'desc')
                -> where('od.status', 0)
                -> where('o.user_id', Auth::user()->id)
                -> groupBy('od.id')
                ->get();

    $orderOnReview = DB::table('orders as o')
                -> join('order_details as od', 'o.seller_id', '=', 'od.seller_id')
                -> join('products as p', 'p.id', '=', 'od.product_id')
                -> orderBy('od.id', 'desc')
                -> where('od.status', 1)
                -> where('o.user_id', Auth::user()->id)
                -> groupBy('od.id')
                ->get();

    $orderActive = DB::table('orders as o')
                -> join('order_details as od', 'o.seller_id', '=', 'od.seller_id')
                -> join('products as p', 'p.id', '=', 'od.product_id')
                -> orderBy('od.id', 'desc')
                -> where('od.status', 3)
                -> where('o.user_id', Auth::user()->id)
                -> groupBy('od.id')
                ->get();
    $orderCompleted = DB::table('orders as o')
                -> join('order_details as od', 'o.seller_id', '=', 'od.seller_id')
                -> join('products as p', 'p.id', '=', 'od.product_id')
                -> orderBy('od.id', 'desc')
                -> where('od.status', 4)
                -> where('o.user_id', Auth::user()->id)
                -> groupBy('od.id')
                ->get();
    $orderCancelled = DB::table('orders as o')
                -> join('order_details as od', 'o.seller_id', '=', 'od.seller_id')
                -> join('products as p', 'p.id', '=', 'od.product_id')
                -> orderBy('od.id', 'desc')
                -> where('od.status', 2)
                -> where('o.user_id', Auth::user()->id)
                -> groupBy('od.id')
                ->get();
@endphp
<ul class="list-group list-group-flush">
    <li class="list-group-item list-group-item-action">
        <a href="{{ route('purchase_history.index') }}" onclick="moveTab('#nav-order-place','{{ route('myorder.place.order') }}')"><i class="fa fa-fw fa-shopping-bag"></i> Order Placed</a>
        <span class="badge badge-danger badge-pill pull-right">{{ count($orderPlaced) }}</span>
    </li>
    <li class="list-group-item list-group-item-action">
        <a href="{{ route('purchase_history.index') }}" onclick="moveTab('#nav-onreview','{{ route('myorder.review.order') }}')"><i class="fa fa-fw fa-sticky-note-o"></i> Order Reviewed</a>
        <span class="badge badge-danger badge-pill pull-right">{{ count($orderOnReview) }}</span>
    </li>
    <li class="list-group-item list-group-item-action">
        <a href="{{ route('purchase_history.index') }}" onclick="moveTab('#nav-active','{{ route('myorder.active.order') }}')"><i class="fa fa-fw fa-calendar-check-o"></i> Order Actived</a>
        <span class="badge badge-danger badge-pill pull-right">{{ count($orderActive) }}</span>
    </li>
    <li class="list-group-item list-group-item-action">
        <a href="{{ route('purchase_history.index') }}" onclick="moveTab('#nav-complete','{{ route('myorder.complete.order') }}')"><i class="fa fa-fw fa-check"></i> Order Completed</a>
        <span class="badge badge-danger badge-pill pull-right">{{ count($orderCompleted) }}</span>
    </li>
    <li class="list-group-item list-group-item-action">
        <a href="{{ route('purchase_history.index') }}" onclick="moveTab('##nav-cancel','{{ route('myorder.cancelled.order') }}')"><i class="fa fa-fw fa-exclamation-triangle"></i> Order Cancelled</a>
        <span class="badge badge-danger badge-pill pull-right">{{ count($orderCancelled) }}</span>
    </li>
</ul>
<script>
    function moveTab(activeTab, routeTab) {
        localStorage.setItem('activeTabBuyer', activeTab);
        localStorage.setItem('routeTabBuyer', routeTab);
    }
</script>