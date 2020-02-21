<style>
    .nav-cus {
        border: none !important;
        border-top-left-radius: 0 !important;
        border-top-right-radius: 0 !important;
        color: black !important;
    }
    .nav-cus:hover {
        background: orange;
    }
    .nav-cus:active {
        background: orange !important;
    }
    .nav-cus:focus {
        background: orange !important;
    }
</style>
<div class="dropdown-cart-items c-scrollbar">
    <div class="dc-item">
        <div class="">
            <div class="nav nav-justified nav-tabs" onclick="changeTab(event)" id="myTab" role="tablist">
                <a class="nav-link nav-cus nav-item active" id="notif-buyer-tab" data-url="{{ route('notif.buyer') }}" data-toggle="tab" href="#notif-buyer" role="tab" aria-controls="notif-buyer" aria-selected="true">Purchase</a>
                @if (Auth::user()->user_type == "seller")
                    <a class="nav-link nav-cus nav-item" id="notif-seller-tab" data-url="{{ route('notif.seller') }}" data-toggle="tab" href="#notif-seller" role="tab" aria-controls="notif-seller" aria-selected="false">Sales</a>
                @endif
            </div>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="notif-buyer" role="tabpanel" aria-labelledby="notif-buyer-tab">

                </div>
                @if (Auth::user()->user_type == "seller")
                <div class="tab-pane fade" id="notif-seller" role="tabpanel" aria-labelledby="notif-seller-tab">

                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="py-2 text-center dc-btn" style="border-top: 1px solid #ccc">
    <ul class="inline-links inline-links--style-3">
        <li class="px-1">
            <a href="{{ route('cart') }}" class="btn btn-primary btn-circle px-3 py-1 text-white">
                <i class="fa fa-shopping-bag"></i> {{__('Show all orders')}}
            </a>
        </li>
        <li class="px-1">
            <a class="btn btn-secondary btn-circle px-3 py-1 text-white" onclick="closeNotif()">
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

        $(href).load(url,function(result){
            pane.tab('show');
        });
    }
</script>