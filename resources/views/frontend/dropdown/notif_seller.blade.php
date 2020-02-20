@php
    $orderPlaced = DB::table('orders as o')
                -> join('order_details as od', 'o.seller_id', '=', 'od.seller_id')
                -> join('products as p', 'p.id', '=', 'od.product_id')
                -> orderBy('od.id', 'desc')
                -> where('o.approved', 1)
                -> where('od.status', 0)
                -> where('o.seller_id', Auth::user()->id)
                -> groupBy('od.id')
                ->get();

    $orderOnReview = DB::table('orders as o')
                -> join('order_details as od', 'o.seller_id', '=', 'od.seller_id')
                -> join('products as p', 'p.id', '=', 'od.product_id')
                -> orderBy('od.id', 'desc')
                -> where('od.status', 1)
                -> where('o.seller_id', Auth::user()->id)
                -> groupBy('od.id')
                ->get();

    $orderActive = DB::table('orders as o')
                -> join('order_details as od', 'o.seller_id', '=', 'od.seller_id')
                -> join('products as p', 'p.id', '=', 'od.product_id')
                -> orderBy('od.id', 'desc')
                -> where('od.status', 3)
                -> where('o.seller_id', Auth::user()->id)
                -> groupBy('od.id')
                ->get();
    $orderCompleted = DB::table('orders as o')
                -> join('order_details as od', 'o.seller_id', '=', 'od.seller_id')
                -> join('products as p', 'p.id', '=', 'od.product_id')
                -> orderBy('od.id', 'desc')
                -> where('od.status', 4)
                -> where('o.seller_id', Auth::user()->id)
                -> groupBy('od.id')
                ->get();
    $orderCancelled = DB::table('orders as o')
                -> join('order_details as od', 'o.seller_id', '=', 'od.seller_id')
                -> join('products as p', 'p.id', '=', 'od.product_id')
                -> orderBy('od.id', 'desc')
                -> where('od.status', 2)
                -> where('o.seller_id', Auth::user()->id)
                -> groupBy('od.id')
                ->get();
@endphp
<ul class="list-group list-group-flush">
    <li class="list-group-item list-group-item-action">
        <a href=""><i class="fa fa-fw fa-shopping-bag"></i> Order Placed</a>
        <span class="badge badge-danger badge-pill pull-right">{{ count($orderPlaced) }}</span>
    </li>
    <li class="list-group-item list-group-item-action">
        <a href=""><i class="fa fa-fw fa-sticky-note-o"></i> Order Reviewed</a>
        <span class="badge badge-danger badge-pill pull-right">{{ count($orderOnReview) }}</span>
    </li>
    <li class="list-group-item list-group-item-action">
        <a href=""><i class="fa fa-fw fa-calendar-check-o"></i> Order Actived</a>
        <span class="badge badge-danger badge-pill pull-right">{{ count($orderActive) }}</span>
    </li>
    <li class="list-group-item list-group-item-action">
        <a href=""><i class="fa fa-fw fa-check"></i> Order Completed</a>
        <span class="badge badge-danger badge-pill pull-right">{{ count($orderCompleted) }}</span>
    </li>
    <li class="list-group-item list-group-item-action">
        <a href=""><i class="fa fa-fw fa-exclamation-triangle"></i> Order Cancelled</a>
        <span class="badge badge-danger badge-pill pull-right">{{ count($orderCancelled) }}</span>
    </li>
</ul>