<div class="sidebar sidebar--style-3 no-border stickyfill p-0">
    <div class="widget mb-0">
        <div class="widget-profile-box text-center p-3">
            <div class="image" style="background-image:url('{{ asset(Auth::user()->avatar_original) }}')">
                @if(Auth::user()->seller->verification_status == 1)
                    <img src="{{ asset('frontend/images/icons/verified.png') }}" alt=""
                        width="50" style="position:absolute; top: 60px;">
                @else
                    <img src="{{ asset('frontend/images/icons/non_verified.png') }}" alt=""
                        width="50" style="position:absolute; top: 60px;">
                @endif
            </div>
            @if(Auth::user()->seller->verification_status == 1)
                <div class="name mb-0">{{ Auth::user()->name }} <img
                        src="{{ asset('frontend/images/icons/verified-account.png') }}" alt="">
                </div>
            @else
                @if(Auth::user()->seller->verification_status == 0)
                    <div class="name mb-0">{{ Auth::user()->name }}</div>
                    <div>
                        <a href="{{ route('shop.verify') }}" type="button" class="btn btn-warning"><i
                                class="fa fa-clock-o text-default"></i> Waiting for Verified</a>
                    </div>
                @else
                    <div class="name mb-0">{{ Auth::user()->name }}
                        <span class="ml-2"><i class="fa fa-times-circle text-danger"></i></span>
                    </div>
                    <div>
                        <a href="{{ route('shop.verify') }}" type="button"
                            class="btn btn-danger">Verify Account</a>
                    </div>
                @endif
            @endif
            <div class="mt-4">
                <a type="button" class="btn" style="color: white; background-color: #0ab1fc">Connect to Smartmedia</a>
            </div>
        </div>
        <div class="sidebar-widget-title py-3">
            <span>{{ __('Buyer Menu') }}</span>
        </div>
        <div class="widget-profile-menu py-3">
            <ul class="categories categories--style-3">
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="{{ areActiveRoutesHome(['dashboard']) }}">
                        <i class="la la-dashboard"></i>
                        <span class="category-name">
                            {{ __('Dashboard') }}
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('purchase_history.index') }}"
                        class="{{ areActiveRoutesHome(['purchase_history.index']) }}">
                        <i class="la la-file-text"></i>
                        <span class="category-name">
                            {{ __('My Order') }}
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('trx.page.buyer') }}"
                        class="{{ areActiveRoutesHome(['trx.page.buyer']) }}">
                        <i class="la la-exchange"></i>
                        <span class="category-name">
                            {{ __('My Transaction') }}
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('wishlists.index') }}"
                        class="{{ areActiveRoutesHome(['wishlists.index']) }}">
                        <i class="la la-heart"></i>
                        <span class="category-name">
                            {{ __('My Wishlist') }}
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile') }}"
                        class="{{ areActiveRoutesHome(['profile']) }}">
                        <i class="la la-user"></i>
                        <span class="category-name">
                            {{ __('Manage Profile') }}
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('support_ticket.index') }}"
                        class="{{ areActiveRoutesHome(['support_ticket.index', 'support_ticket.show']) }}">
                        <i class="la la-support"></i>
                        <span class="category-name">
                            {{ __('Support Ticket') }}
                        </span>
                    </a>
                </li>
            </ul>
        </div>
        @if(Auth::user()->seller->verification_status == 1)
            <div class="sidebar-widget-title py-3">
                <span>{{ __('Seller Menu') }}</span>
            </div>
            <div class="widget-profile-menu py3">
                <ul class="categories categories--style-3">
                    <li>
                        <a href="{{ route('seller.products') }}"
                            class="{{ areActiveRoutesHome(['seller.products', 'seller.products.upload', 'seller.products.edit']) }}">
                            <i class="la la-diamond"></i>
                            <span class="category-name">
                                {{ __('Products') }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('orders.index') }}"
                            class="{{ areActiveRoutesHome(['orders.index']) }}">
                            <i class="la la-file-text"></i>
                            <span class="category-name">
                                {{ __('Orders') }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reviews.seller') }}"
                            class="{{ areActiveRoutesHome(['reviews.seller']) }}">
                            <i class="la la-star-o"></i>
                            <span class="category-name">
                                {{ __('Product Reviews') }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('shops.index') }}"
                            class="{{ areActiveRoutesHome(['shops.index']) }}">
                            <i class="la la-cog"></i>
                            <span class="category-name">
                                {{ __('Vendor Setting') }}
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('payments.index') }}"
                            class="{{ areActiveRoutesHome(['payments.index']) }}">
                            <i class="la la-cc-mastercard"></i>
                            <span class="category-name">
                                {{ __('Payment History') }}
                            </span>
                        </a>
                    </li>
                </ul>

            </div>
            <div class="sidebar-widget-title py-3">
                <span><img src="{{ asset('uploads/smartmedia.png') }}" alt="" height="24px"></span>
            </div>
            <div class="widget-profile-menu py3">
                <ul class="categories categories--style-3">
                    <li>
                        <a href="{{ route('seller.products') }}"
                            class="{{ areActiveRoutesHome(['seller.products', 'seller.products.upload', 'seller.products.edit']) }}">
                            <i class="la la-diamond"></i>
                            <span class="category-name">
                                {{ __('Report Device Logs') }}
                            </span>
                        </a>
                    </li>

                </ul>

            </div>
            <div class="sidebar-widget-title py-3">
                <span>{{ __('Earnings') }}</span>
            </div>
            <div class="widget-balance pb-3 pt-1">
                <div class="text-center">
                    <div class="heading-4 strong-700 mb-4">
                        @php
                            $orders = DB::table('orders')
                                    ->selectRaw('sum(grand_total - adpoint_earning) as jumlah')
                                    ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE)')
                                    ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE)')
                                    ->get();
                            foreach ($orders as $key => $value) {
                                $jumlah = $value->jumlah;
                            }
                        @endphp
                        <small
                            class="d-block text-sm alpha-5 mb-2">{{ __('Your earnings (current month)') }}</small>
                        <span class="p-2 bg-base-1 rounded">{{ single_price($jumlah) }}</span>
                    </div>
                    <table class="text-left mb-0 table w-75 m-auto">
                        <tr>
                            @php
                                $orders = DB::table('orders')
                                    ->selectRaw('sum(grand_total - adpoint_earning) as jumlah')
                                    ->get();
                                foreach ($orders as $key => $value) {
                                    $jumlah = $value->jumlah;
                                }
                            @endphp
                            <td class="p-1 text-sm">
                                {{ __('Total earnings') }}:
                            </td>
                            <td class="p-1">
                                {{ single_price($jumlah) }}
                            </td>
                        </tr>
                        <tr>
                            @php
                                $orders = DB::table('orders')
                                    ->selectRaw('sum(grand_total - adpoint_earning) as jumlah')
                                    ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)')
                                    ->whereRaw('MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)')
                                    ->get();
                                foreach ($orders as $key => $value) {
                                    $jumlah = $value->jumlah;
                                }
                            @endphp
                            <td class="p-1 text-sm">
                                {{ __('Last Month earnings') }}:
                            </td>
                            <td class="p-1">
                                {{ single_price($jumlah) }}
                            </td>
                        </tr>
                    </table>
                </div>
                <table>

                </table>
            </div>
        @endif

    </div>
</div>
