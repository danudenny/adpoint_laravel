<style>
    @media (max-width: 1920px) {
        .fa-pulse {
            color: red;
            display: inline-block;
            /*position: relative;*/
            -moz-animation: pulse 1s infinite linear;
            -o-animation: pulse 1s infinite linear;
            -webkit-animation: pulse 1s infinite linear;
            animation: pulse 1s infinite linear;
            position: absolute;
            top: -4px;
            right: -2px;
            padding: 2px 4px;
            border-radius: 50%;
        }
    }

    .fa-pulse {
        color: red;
        display: inline-block;
        /*position: relative;*/
        -moz-animation: pulse 1s infinite linear;
        -o-animation: pulse 1s infinite linear;
        -webkit-animation: pulse 1s infinite linear;
        animation: pulse 1s infinite linear;
        position: absolute;
        top: -8px;
        right: -3px;
        padding: 2px 4px;
        border-radius: 50%;
    }

    @-webkit-keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0; }
        100% { opacity: 1; }
    }
    @-moz-keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0; }
        100% { opacity: 1; }
    }
    @-o-keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0; }
        100% { opacity: 1; }
    }
    @-ms-keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0; }
        100% { opacity: 1; }
    }
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0; }
        100% { opacity: 1; }
    }
</style>
<div class="header bg-white">
@auth
    @php
        if (Auth::user()->user_type == "customer") {
            $orderPlaced = orders_notif('customer', 0, 'o.user_id')->count();
            $orderOnReviewed = orders_notif('customer', 1, 'o.user_id')->count();
            $orderActived = orders_notif('customer', 3, 'o.user_id')->count();
            $orderCompleted = orders_notif('customer', 4, 'o.user_id')->count();
            $orderCancelled = orders_notif('customer', 2, 'o.user_id')->count();
        }
        if (Auth::user()->user_type == "seller") {
            $orderPlaced = orders_notif('seller', 0, 'o.seller_id')->count();
            $orderOnReviewed = orders_notif('seller', 1, 'o.seller_id')->count();
            $orderActived = orders_notif('seller', 3, 'o.seller_id')->count();
            $orderCompleted = orders_notif('seller', 4, 'o.seller_id')->count();
            $orderCancelled = orders_notif('seller', 2, 'o.seller_id')->count();
        }
        $trxUnpaid = trx_notif(0, Auth::user()->id)->count();
        $trxPaid = trx_notif(1, Auth::user()->id)->count();
    @endphp
@endauth
    <!-- mobile menu -->
    <div class="mobile-side-menu d-lg-none">
        <div class="side-menu-overlay opacity-0" onclick="sideMenuClose()"></div>
        <div class="side-menu-wrap opacity-0">
            <div class="side-menu closed">
                <div class="side-menu-header ">
                    <div class="side-menu-close" onclick="sideMenuClose()">
                        <i class="la la-close"></i>
                    </div>

                    @auth
                        <div class="widget-profile-box px-3 py-4 d-flex align-items-center">
                                <div class="image " style="background-image:url('{{ Auth::user()->avatar_original }}')"></div>
                                <div class="name">{{ Auth::user()->name }}</div>
                        </div>
                        <div class="side-login px-3 pb-3">
                            <a href="{{ route('logout') }}" onclick="logoutSession()">{{__('Sign Out')}}</a>
                        </div>
                    @else
                        <div class="widget-profile-box px-3 py-4 d-flex align-items-center">
                                <div class="image " style="background-image:url('{{ asset('frontend/images/icons/user-placeholder.jpg') }}')"></div>
                        </div>
                        <div class="side-login px-3 pb-3">
                            <a data-toggle="modal" data-target="#sign-in-modal" class="c-pointer">{{__('Sign In')}}</a>
                            <a href="{{ route('user.registration') }}">{{__('Registration')}}</a>
                        </div>
                    @endauth
                </div>
                <div class="side-menu-list px-3">
                    <div class="sidebar-widget-title py-0 mt-2">
                        <span>{{__('Buyer Menu')}}</span>
                    </div>
                    <ul class="side-user-menu">
                        <li>
                            <a href="{{ route('home') }}">
                                <i class="la la-home"></i>
                                <span>{{__('Home')}}</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('dashboard') }}">
                                <i class="la la-dashboard"></i>
                                <span>{{__('Dashboard')}}</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('purchase_history.index') }}">
                                <i class="la la-file-text"></i>
                                <span>{{__('My Order')}}</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('trx.page.buyer') }}">
                                <i class="la la-file-text"></i>
                                <span>{{__('My Transaction')}}</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('profile') }}">
                                <i class="la la-user"></i>
                                <span>{{__('Manage Profile')}}</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('support_ticket.index') }}" class="{{ areActiveRoutesHome(['support_ticket.index', 'support_ticket.show'])}}">
                                <i class="la la-support"></i>
                                <span class="category-name">
                                    {{__('Support Ticket')}}
                                </span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('wishlists.index') }}">
                                <i class="la la-heart-o"></i>
                                <span>{{__('Wishlist')}}</span>
                            </a>
                        </li>

                        @if (\App\BusinessSetting::where('type', 'wallet_system')->first()->value == 1)
                            <li>
                                <a href="{{ route('wallet.index') }}">
                                    <i class="la la-dollar"></i>
                                    <span>{{__('My Wallet')}}</span>
                                </a>
                            </li>
                        @endif

                        @if (\App\BusinessSetting::where('type', 'wallet_system')->first()->value == 1)
                            <li>
                                <a href="{{ route('wallet.index') }}" class="{{ areActiveRoutesHome(['wallet.index'])}}">
                                    <i class="la la-dollar"></i>
                                    <span class="category-name">
                                        {{__('My Wallet')}}
                                    </span>
                                </a>
                            </li>
                        @endif


                        <li>
                            <a href="{{ route('compare') }}">
                                <i class="la la-refresh"></i>
                                <span>{{__('Compare')}}</span>
                                @if(Session::has('compare'))
                                    <span class="badge" id="compare_items_sidenav">{{ count(Session::get('compare'))}}</span>
                                @else
                                    <span class="badge" id="compare_items_sidenav">0</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('cart') }}">
                                <i class="la la-shopping-cart"></i>
                                <span>{{__('Cart')}}</span>
                                @if(Session::has('cart'))
                                    @php
                                        $count = 0;
                                        foreach (Session::get('cart') as $key => $c) {
                                            $count += count($c);
                                        }
                                    @endphp
                                    <span class="badge" id="cart_items_sidenav">{{ $count }}</span>
                                @else
                                    <span class="badge" id="cart_items_sidenav">0</span>
                                @endif
                            </a>
                        </li>

                    </ul>
                    @if (Auth::check() && Auth::user()->user_type == 'seller')
                        <div class="sidebar-widget-title py-0">
                            <span>{{__('Seller Menu')}}</span>
                        </div>
                        <ul class="side-seller-menu">
                            <li>
                                <a href="{{ route('seller.products') }}">
                                    <i class="la la-diamond"></i>
                                    <span>{{__('Products')}}</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('orders.index') }}">
                                    <i class="la la-file-text"></i>
                                    <span>{{__('Orders')}}</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('reviews.seller') }}">
                                    <i class="la la-star-o"></i>
                                    <span>{{__('Product Reviews')}}</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('shops.index') }}">
                                    <i class="la la-cog"></i>
                                    <span>{{__('Shop Setting')}}</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('payments.index') }}">
                                    <i class="la la-cc-mastercard"></i>
                                    <span>{{__('Payment History')}}</span>
                                </a>
                            </li>

                        </ul>
                        <div class="sidebar-widget-title py-0">
                            <span>{{__('Earnings')}}</span>
                        </div>
                        <div class="widget-balance py-3">
                            <div class="text-center">
                                <div class="heading-4 strong-700 mb-4">
                                    @php
                                        $orders = \App\Order::where('seller_id', Auth::user()->id)->where('created_at', '>=', date('-30d'))->get();

                                        $total = 0;
                                        foreach ($orders as $key => $o) {
                                            if($o->approved == 1){
                                                $total += $o->grand_total-$o->adpoint_earning;
                                            }
                                        }
                                    @endphp
                                    <small class="d-block text-sm alpha-5 mb-2">{{__('Your earnings (current month)')}}</small>
                                    <span class="p-2 bg-base-1 rounded">{{ single_price($total) }}</span>
                                </div>
                                <table class="text-left mb-0 table w-75 m-auto">
                                    <tbody>
                                        <tr>
                                            @php
                                                $orders = \App\Order::where('seller_id', Auth::user()->id)->get();
                                                $total = 0;
                                                foreach ($orders as $key => $o) {
                                                    if($o->approved == 1){
                                                        $total += $o->grand_total-$o->adpoint_earning;
                                                    }
                                                }
                                            @endphp
                                            <td class="p-1 text-sm">
                                                {{__('Total earnings')}}:
                                            </td>
                                            <td class="p-1">
                                                {{ single_price($total) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            @php
                                                $orders = \App\Order::where('seller_id', Auth::user()->id)->where('created_at', '>=', date('-60d'))->where('created_at', '<=', date('-30d'))->get();
                                                $total = 0;
                                                foreach ($orders as $key => $o) {
                                                    if($o->approved == 1){
                                                        $total += $o->grand_total-$o->adpoint_earning;
                                                    }
                                                }
                                            @endphp
                                            <td class="p-1 text-sm">
                                                {{__('Last Month earnings')}}:
                                            </td>
                                            <td class="p-1">
                                                {{ single_price($total) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    <div class="sidebar-widget-title py-0">
                        <span>Categories</span>
                    </div>
                    <ul class="side-seller-menu">
                        @foreach (\App\Category::all() as $key => $category)
                            <li>
                                <a href="{{ route('products.category', $category->slug) }}" class="text-truncate">
                                    <img class="cat-image" src="{{ asset($category->banner) }}" width="13">
                                    <span>{{ __($category->name) }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- end mobile menu -->

    <div class="logo-bar-area" style="position: fixed; top: 0; width: 100%;">
        <div class="p-2">
            <div class="container">
                <div class="row no-gutters align-items-center">
                    <div class="col-lg-3 col-8">
                        <div class="d-flex">
                            <div class="d-block d-lg-none mobile-menu-icon-box">
                                <!-- Navbar toggler  -->
                                <a href="" onclick="sideMenuOpen(this)">
                                    <div class="hamburger-icon">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </a>
                            </div>

                            <!-- Brand/Logo -->
                            <a class="navbar-brand w-100" href="{{ route('home') }}">
                                @php
                                    $generalsetting = \App\GeneralSetting::first();
                                @endphp
                                @if($generalsetting->logo != null)
                                    <img src="{{ asset($generalsetting->logo) }}" class="" alt="active shop">
                                @else
                                    <img src="{{ asset('frontend/images/logo/logo.png') }}" class="" alt="active shop">
                                @endif
                            </a>

                            @if(Route::currentRouteName() != 'home' && Route::currentRouteName() != 'categories.all')
                                <div class="d-none d-xl-block category-menu-icon-box">
                                    <div class="dropdown-toggle navbar-light category-menu-icon" id="category-menu-icon">
                                        <span class="navbar-toggler-icon"></span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-9 col-4 position-static">
                        <div class="d-flex w-100">
                            <div class="logo-bar-icons d-inline-block ml-auto">
                                <div class="d-none d-lg-inline-block topnav-text">
                                    <i class="fa fa-envelope"></i>
                                    <span> hello@adpoint.id</span>
                                </div>
                                <div class="d-none d-lg-inline-block topnav-text">
                                    <i class="fa fa-phone"></i>
                                    <span> +621-538-5359</span>
                                </div>
                                @auth
                                    <div class="d-none d-lg-inline-block topnav-text">
                                        <a href="{{ route('dashboard') }}" class="login-text">{{__('My Account')}}</a>
                                    </div>
                                    <div class="d-none d-lg-inline-block topnav-text">
                                        <a href="{{ route('logout') }}" onclick="logoutSession()" class="login-text">{{__('Logout')}}</a>
                                    </div>
                                    <div class="d-inline-block" data-hover="dropdown">
                                        <div class="nav-cart-box dropdown" id="cart_items">
                                            <a href="" class="nav-box-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-shopping-cart fa-2x text-dark"></i>
                                                @if(Session::has('cart'))
                                                    @php
                                                        $count = 0;
                                                        foreach (Session::get('cart') as $key => $c) {
                                                            $count += count($c);
                                                        }
                                                    @endphp
                                                    <span class="nav-box-number bg-red">{{ $count }}</span>
                                                @else
                                                    <span class="nav-box-number bg-red">0</span>
                                                @endif
                                            </a>
                                            <ul class="dropdown-menu border-0 dropdown-menu-right px-0">
                                                <li>
                                                    <div class="dropdown-cart px-0">
                                                        @if(Session::has('cart'))
                                                            @if(count($cart = Session::get('cart')) > 0)
                                                                <div class="dc-header">
                                                                    <h3 class="heading heading-6 strong-700">
                                                                        <i class="fa fa-shopping-cart"></i> {{__('My Cart')}}
                                                                    </h3>
                                                                </div>
                                                                <div class="dropdown-cart-items c-scrollbar">
                                                                    @php
                                                                        $total = 0;
                                                                    @endphp
                                                                    @foreach($cart as $seller_id => $c)
                                                                        <div class="dc-item p-2">
                                                                            <strong class="ml-2">{{ \App\User::where('id', $seller_id)->first()->name }}</strong>
                                                                        </div>
                                                                        @php
                                                                            $subtotal = 0;
                                                                        @endphp
                                                                        @foreach ($c as $key => $cartItem)
                                                                            @php
                                                                                $product = \App\Product::where('id', $cartItem['id'])->first();
                                                                                $subtotal += $cartItem['price']*$cartItem['quantity'];
                                                                            @endphp
                                                                            <div class="dc-item">
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="dc-image">
                                                                                        <a href="{{ route('product', $product->slug) }}">
                                                                                            <img src="{{ url($product->thumbnail_img) }}" class="img-fluid" alt="">
                                                                                        </a>
                                                                                    </div>
                                                                                    <div class="dc-content">
                                                                                        <span class="d-block dc-product-name text-capitalize strong-600 mb-1">
                                                                                            <a href="{{ route('product', $product->slug) }}">
                                                                                                {{ __($product->name) }}
                                                                                            </a>
                                                                                        </span>

                                                                                        <span class="dc-quantity">x{{ $cartItem['quantity'] }}</span>
                                                                                        <span class="dc-price">{{ single_price($cartItem['price']*$cartItem['quantity']) }}</span>
                                                                                    </div>
                                                                                    <div class="dc-actions">
                                                                                        <button onclick="confirm_delete(event, {{ $seller_id }}, {{ $key }})">
                                                                                            <i class="la la-close"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                        @php
                                                                            $total += $subtotal;
                                                                        @endphp
                                                                    @endforeach
                                                                </div>
                                                                <div class="dc-item py-3">
                                                                    <span class="subtotal-text">{{__('Subtotal')}}</span>
                                                                    <span class="subtotal-amount strong-700">{{ single_price($total) }}</span>
                                                                </div>
                                                                <div class="py-2 text-center dc-btn">
                                                                    <ul class="inline-links inline-links--style-3">
                                                                        <li class="px-1">
                                                                            <a href="{{ route('cart') }}" class="btn btn-orange btn-circle px-3 py-1 text-white">
                                                                                <i class="la la-shopping-cart"></i> {{__('View cart')}}
                                                                            </a>
                                                                        </li>
                                                                        @if (Auth::check())
                                                                        <li class="px-1">
                                                                            <a href="{{ route('checkout.shipping_info') }}" class="btn btn-success btn-circle text-white px-3 py-1">
                                                                                <i class="la la-mail-forward"></i> {{__('Checkout')}}
                                                                            </a>
                                                                        </li>
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            @else
                                                                <div class="text-center">
                                                                    <h3 class="heading heading-6 strong-700">
                                                                        <i class="fa fa-shopping-cart"></i> {{__('Your Cart is empty')}}
                                                                    </h3>
                                                                </div>
                                                            @endif
                                                        @else
                                                            <div class="text-center">
                                                                <h3 class="heading heading-6 strong-700">
                                                                    <i class="fa fa-shopping-cart"></i> {{__('Your Cart is empty')}}
                                                                </h3>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="d-inline-block">
                                        <div class="nav-cart-box dropdown" id="head-notif">
                                            <a id="notif-load-btn" class="nav-box-link" style="cursor: pointer">
                                                <i class="fa fa-bell fa-2x text-dark"></i>
                                                @if($orderPlaced > 0 || $orderOnReviewed > 0 || $orderActived > 0 || $orderCompleted > 0 || $orderCancelled > 0 || $trxUnpaid > 0 || $trxPaid > 0)
                                                    <span class="badge-header fa-pulse"><i class="fa fa-circle"></i></span>
                                                @endif
                                            </a>
                                            <ul class="dropdown-menu border-0 dropdown-menu-right px-0" id="content-notif">
                                                <li>
                                                    <div class="dropdown-cart px-0">
                                                        <div class="dc-header">
                                                            <h3 class="heading heading-6 strong-700">
                                                                <i class="fa fa-bell"></i> {{__('Notification')}}
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div class="row loading-notif">
                                                        <div class="col-md-12">
                                                            <h3 class="text-center">
                                                                <i class="fa fa-spin fa-spinner"></i>   
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div id="content-notification">

                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                @else
                                <div class="d-none d-lg-inline-block topnav-text">
                                    <a data-toggle="modal" data-target="#sign-in-modal" class="login-text c-pointer"> Login</a>
                                </div>
                                <div class="d-none d-lg-inline-block topnav-text">
                                    <a href="{{ route('user.registration') }}" class="btn btn-dark btn-circle"> Create Account</a>
                                </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="hover-category-menu" id="hover-category-menu">
            <div class="container">
                <div class="row no-gutters position-relative">
                    <div class="col-lg-3 position-static">
                        <div class="category-sidebar" id="category-sidebar">
                            <div class="all-category">
                                <span>{{__('CATEGORIES')}}</span>
                                <a href="{{ route('categories.all') }}" class="d-inline-block">See All ></a>
                            </div>
                            <ul class="categories">
                                @foreach (\App\Category::all()->take(11) as $key => $category)
                                    @php
                                        $brands = array();
                                    @endphp
                                    <li>
                                        <a href="{{ route('products.category', $category->slug) }}">
                                            <img class="cat-image" src="{{ asset($category->icon) }}" width="30">
                                            <span class="cat-name">{{ __($category->name) }}</span>
                                        </a>
                                        @if(count($category->subcategories)>0)
                                            <div class="sub-cat-menu c-scrollbar">
                                                <div class="sub-cat-main row no-gutters">
                                                    <div class="col-7">
                                                        <div class="sub-cat-content">
                                                            <div class="sub-cat-list">
                                                                <div>
                                                                    <label class="sub-cat-name" style="margin-top: 20px; margin-left: 10px;"><b>SUB CATEGORIES</b></label>
                                                                </div>
                                                                <div class="card-columns">
                                                                    @foreach ($category->subcategories as $subcategory)
                                                                        <div class="card">
                                                                            <ul class="sub-cat-items">
                                                                                @php
                                                                                    foreach (json_decode($subcategory->brands) as $brand) {
                                                                                        if(!in_array($brand, $brands)){
                                                                                            array_push($brands, $brand);
                                                                                        }
                                                                                    }
                                                                                @endphp
                                                                                <li><a href="{{ route('products.subcategory', $subcategory->slug) }}">{{ __($subcategory->name) }}</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-5">
                                                        <div class="sub-cat-brand">
                                                            <div>
                                                                <label class="sub-cat-name" style="margin-top: 10px; "><b>MEDIA PARTNERS</b></label>
                                                                <hr>
                                                            </div>
                                                            <ul class="sub-brand-list">
                                                                @foreach ($brands as $brand_id)
                                                                    @if(\App\Brand::find($brand_id) != null)
                                                                        <li class="sub-brand-item">
                                                                            <a href="{{ route('products.brand', \App\Brand::find($brand_id)->slug) }}" ><img src="{{ asset(\App\Brand::find($brand_id)->logo) }}" class="img-fluid"></a>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Navbar -->

    <div class="main-nav-area d-none d-lg-block">
        <nav class="navbar navbar-expand-lg navbar--bold navbar--style-2 navbar-light bg-default">
            <div class="container">
                <div class="collapse navbar-collapse align-items-center justify-content-center" id="navbar_main">
                    <!-- Navbar links -->
                    <ul class="navbar-nav">
                        @foreach (\App\Search::orderBy('count', 'desc')->get()->take(5) as $key => $search)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('suggestion.search', $search->query) }}">{{ $search->query }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="sign-in-modal" tabindex="-1" role="dialog" aria-labelledby="sign-in-modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="sign-in-modalTitle">Sign In</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <form action="{{ route('login.user') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="container p-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group{{ $errors->has('email') ? 'has-error' : ''}}">
                                <div class="input-group input-group--style-1">
                                    <input type="email" class="form-control form-control-sm" value="{{ old('email') }}" placeholder="{{__('Email')}}" name="email" id="email">
                                    <span class="input-group-addon bg-dark">
                                        <i class="text-md text-white la la-user"></i>
                                    </span>
                                </div>
                                <strong class="text-danger mt-1">{!! $errors->first('email', '<p class="help-block">:message</p>') !!}</strong>
                            </div>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group{{ $errors->has('password') ? 'has-error' : ''}}">
                                <div class="input-group input-group--style-1">
                                    <input type="password" class="form-control" placeholder="{{__('Password')}}" name="password" id="password">
                                    <span class="input-group-addon bg-dark">
                                        <i class="text-md text-white la la-lock"></i>
                                    </span>
                                </div>
                                <strong class="text-danger mt-1">{!! $errors->first('password', '<p class="help-block">:message</p>') !!}</strong>
                            </div>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <div class="checkbox pad-btm text-left">
                                    <input id="demo-form-checkbox" class="magic-checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="demo-form-checkbox" class="text-sm">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route('reset.password') }}" class="link link-xs link--style-3">{{__('Forgot password?')}}</a>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col text-center">
                            <button type="submit" class="btn btn-dark btn-block btn-md">{{ __('Login') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
</div>

<script>
    function confirm_delete(e, seller_id, index) {
        if (confirm('Are you sure delete?')) {
            removeFromCart(seller_id, index);
            location.reload();
        }
    }

    function logoutSession(){
        var ls = [
            'pushyToken',
            'pushyTokenAppId',
            'pushyTokenAuth',
            'activeTabBuyer',
            'activeTabSeller',
            'activeTabTrx',
            'routeTabBuyer',
            'routeTabSeller',
            'routeTabTrx',
        ];

        ls.forEach(element => {
            localStorage.removeItem(element);
        });
    }

    $('#notif-load-btn').on('click', function(e) {
        $('#head-notif').addClass('show');
        $('#content-notif').addClass('show');
        $.get('{{ route('notif.loading') }}', function(result) {
            $('.loading-notif').hide();
            $('#content-notification').html(result);
        })
    });

    function closeNotif() {
        $('#head-notif').removeClass('show');
        $('#content-notif').removeClass('show');
    }
    $('#closeNotif').on('click', function(e) {
        $('#head-notif').removeClass('show');
        $('#content-notif').removeClass('show');
    });
</script>
