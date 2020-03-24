@php
    $orderPlaced = orders_notif(Auth::user()->user_type, 0, 'o.seller_id')->count();
    $orderOnReviewed = orders_notif(Auth::user()->user_type, 1, 'o.seller_id')->count();
    $orderActived = orders_notif(Auth::user()->user_type, 3, 'o.seller_id')->count();
    $orderCompleted = orders_notif(Auth::user()->user_type, 4, 'o.seller_id')->count();
    $orderCancelled = orders_notif(Auth::user()->user_type, 2, 'o.seller_id')->count();
@endphp
<ul class="list-group list-group-flush">
    <li class="list-group-item list-group-item-action">
        <a href="{{ route('orders.index') }}" class="text-dark" onclick="moveTab('#nav-order-place','{{ route('orders.place.order') }}')"><i class="fa fa-fw fa-shopping-bag"></i> Order Placed</a>
        @if ($orderPlaced > 0)
            <span class="badge badge-danger badge-pill pull-right">{{ $orderPlaced }}</span> 
        @endif
    </li>
    <li class="list-group-item list-group-item-action">
        <a href="{{ route('orders.index') }}" class="text-dark" onclick="moveTab('#nav-onreview','{{ route('orders.review.order') }}')"><i class="fa fa-fw fa-sticky-note-o"></i> Order Reviewed</a>
        @if ($orderOnReviewed > 0)
            <span class="badge badge-danger badge-pill pull-right">{{ $orderOnReviewed }}</span>
        @endif
    </li>
    <li class="list-group-item list-group-item-action">
        <a href="{{ route('orders.index') }}" class="text-dark" onclick="moveTab('#nav-active','{{ route('orders.active.order') }}')"><i class="fa fa-fw fa-calendar-check-o"></i> Order Actived</a>
        @if ($orderActived > 0)
            <span class="badge badge-danger badge-pill pull-right">{{ $orderActived }}</span>  
        @endif
    </li>
    <li class="list-group-item list-group-item-action">
        <a href="{{ route('orders.index') }}" onclick="moveTab('#nav-complete','{{ route('orders.complete.order') }}')"><i class="fa fa-fw fa-check"></i> Order Completed</a>
        @if ($orderCompleted > 0)
            <span class="badge badge-danger badge-pill pull-right">{{ $orderCompleted }}</span>  
        @endif
    </li>
    <li class="list-group-item list-group-item-action">
        <a href="{{ route('orders.index') }}" class="text-dark" onclick="moveTab('#nav-cancel','{{ route('orders.cancelled.order') }}')"><i class="fa fa-fw fa-exclamation-triangle"></i> Order Cancelled</a>
        @if ($orderCancelled > 0)
            <span class="badge badge-danger badge-pill pull-right">{{ $orderCancelled }}</span> 
        @endif
    </li>
</ul>

<script>
    function moveTab(activeTab, routeTab) {
        localStorage.setItem('activeTabSeller', activeTab);
        localStorage.setItem('routeTabSeller', routeTab);
    }
</script>