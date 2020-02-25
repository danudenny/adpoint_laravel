@php
    $trxUnpaid = trx_notif(0, Auth::user()->id)->count();
    $trxPaid = trx_notif(1, Auth::user()->id)->count();
@endphp
<ul class="list-group list-group-flush">
    <li class="list-group-item list-group-item-action">
        <a href="{{ route('trx.page.buyer') }}" onclick="moveTab('#nav-unpaid','{{ route('trx.unpaid') }}')"><i class="la la-money"></i> Transaction Unpaid</a>
        @if ($trxUnpaid > 0)
            <span class="badge badge-danger badge-pill pull-right">{{ $trxUnpaid }}</span>   
        @endif
    </li>
    <li class="list-group-item list-group-item-action">
        <a href="{{ route('trx.page.buyer') }}" onclick="moveTab('#nav-paid','{{ route('trx.paid') }}')"><i class="la la-check"></i> Transaction Paid</a>
        @if ($trxPaid > 0)
            <span class="badge badge-danger badge-pill pull-right">{{ $trxPaid }}</span>   
        @endif
    </li>
</ul>
<script>
    function moveTab(activeTab, routeTab) {
        localStorage.setItem('activeTabTrx', activeTab);
        localStorage.setItem('routeTabTrx', routeTab);
    }
</script>