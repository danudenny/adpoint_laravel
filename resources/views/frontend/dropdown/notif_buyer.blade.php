@php    
    $orderPlaced = orders_notif(Auth::user()->user_type, 0, 'o.user_id')->count();
    $orderOnreviewed = orders_notif(Auth::user()->user_type, 1, 'o.user_id')->count();
    $orderActived = orders_notif(Auth::user()->user_type, 3, 'o.user_id')->count();
    $orderCompleted = orders_notif(Auth::user()->user_type, 4, 'o.user_id')->count();
    $orderCancelled = orders_notif(Auth::user()->user_type, 2, 'o.user_id')->count();
@endphp
<ul class="list-group list-group-flush">
    <li class="list-group-item list-group-item-action">
        <a href="{{ route('purchase_history.index') }}" class="text-dark" onclick="moveTab('#nav-order-place','{{ route('myorder.place.order') }}')"><i class="fa fa-fw fa-shopping-bag"></i> Order Placed</a>
        @if ($orderPlaced > 0)
            <span class="badge badge-danger badge-pill pull-right">{{ $orderPlaced }}</span>   
        @endif
    </li>
    <li class="list-group-item list-group-item-action">
        <a href="{{ route('purchase_history.index') }}" class="text-dark" onclick="moveTab('#nav-onreview','{{ route('myorder.review.order') }}')"><i class="fa fa-fw fa-sticky-note-o"></i> Order Reviewed</a>
        @if ($orderOnreviewed > 0)
            <span class="badge badge-danger badge-pill pull-right">{{ $orderOnreviewed }}</span>  
        @endif
    </li>
    <li class="list-group-item list-group-item-action">
        <a href="{{ route('purchase_history.index') }}" class="text-dark" onclick="moveTab('#nav-active','{{ route('myorder.active.order') }}')"><i class="fa fa-fw fa-calendar-check-o"></i> Order Actived</a>
        @if ($orderActived > 0)
            <span class="badge badge-danger badge-pill pull-right">{{ $orderActived }}</span> 
        @endif
    </li>
    <li class="list-group-item list-group-item-action">
        <a href="{{ route('purchase_history.index') }}" class="text-dark" onclick="moveTab('#nav-complete','{{ route('myorder.complete.order') }}')"><i class="fa fa-fw fa-check"></i> Order Completed</a>
        @if ($orderCompleted > 0)
            <span class="badge badge-danger badge-pill pull-right">{{ $orderCompleted }}</span>   
        @endif
    </li>
    <li class="list-group-item list-group-item-action">
        <a href="{{ route('purchase_history.index') }}" class="text-dark" onclick="moveTab('#nav-cancel','{{ route('myorder.cancelled.order') }}')"><i class="fa fa-fw fa-exclamation-triangle"></i> Order Cancelled</a>
        @if ($orderCancelled > 0)
            <span class="badge badge-danger badge-pill pull-right">{{ $orderCancelled }}</span>
        @endif
    </li>
</ul>
<script>
    function moveTab(activeTab, routeTab) {
        localStorage.setItem('activeTabBuyer', activeTab);
        localStorage.setItem('routeTabBuyer', routeTab);
    }
</script>