<!--MAIN NAVIGATION-->
<!--===================================================-->
@php
    $user = Auth::user();
    $userRegister = [];
    foreach ($user->unreadNotifications as $notif) {
        if ($notif->type === "App\Notifications\UserRegister") {
            array_push($userRegister, $user->type);
        }
    }
@endphp
<nav id="mainnav-container">
    <div id="mainnav">

        <!--Menu-->
        <!--================================-->
        <div id="mainnav-menu-wrap">
            <div class="nano">
                <div class="nano-content">

                    <!--Profile Widget-->
                    <!--================================-->


                    <!--Shortcut buttons-->
                    <!--================================-->
                    <div id="mainnav-shortcut" class="hidden">
                        <ul class="list-unstyled shortcut-wrap">
                            <li class="col-xs-3" data-content="My Profile">
                                <a class="shortcut-grid" href="#">
                                    <div class="icon-wrap icon-wrap-sm icon-circle bg-mint">
                                    <i class="demo-pli-male"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="col-xs-3" data-content="Messages">
                                <a class="shortcut-grid" href="#">
                                    <div class="icon-wrap icon-wrap-sm icon-circle bg-warning">
                                    <i class="demo-pli-speech-bubble-3"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="col-xs-3" data-content="Activity">
                                <a class="shortcut-grid" href="#">
                                    <div class="icon-wrap icon-wrap-sm icon-circle bg-success">
                                    <i class="demo-pli-thunder"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="col-xs-3" data-content="Lock Screen">
                                <a class="shortcut-grid" href="#">
                                    <div class="icon-wrap icon-wrap-sm icon-circle bg-purple">
                                    <i class="demo-pli-lock-2"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!--================================-->
                    <!--End shortcut buttons-->


                    <ul id="mainnav-menu" class="list-group">


                        <!--Menu list item-->
                        <li class="{{ areActiveRoutes(['admin.dashboard'])}}">
                            <a class="nav-link" href="{{route('admin.dashboard')}}">
                                <i class="fa fa-home"></i>
                                <span class="menu-title">{{__('Dashboard')}}</span>
                            </a>
                        </li>

                        <!-- Product Menu -->

                        @if(Auth::user()->user_type == 'admin')
                            <li>
                                <a href="#">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span class="menu-title">{{__('Products')}}</span>
                                    <i class="arrow"></i>
                                </a>
                                <!--Submenu-->
                                <ul class="collapse">
                                    <li class="{{ areActiveRoutes(['brands.index', 'brands.create', 'brands.edit'])}}">
                                        <a class="nav-link" href="{{route('brands.index')}}">{{__('Brand')}}</a>
                                    </li>
                                    <li class="{{ areActiveRoutes(['categories.index', 'categories.create', 'categories.edit'])}}">
                                        <a class="nav-link" href="{{route('categories.index')}}">{{__('Category')}}</a>
                                    </li>
                                    <li class="{{ areActiveRoutes(['subcategories.index', 'subcategories.create', 'subcategories.edit'])}}">
                                        <a class="nav-link" href="{{route('subcategories.index')}}">{{__('Subcategory')}}</a>
                                    </li>
                                    @if(\App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
                                    <li class="{{ areActiveRoutes(['products.seller', 'products.seller.edit'])}}">
                                        <a class="nav-link" href="{{route('products.seller')}}">{{__('List Products')}}</a>
                                    </li>
                                    @endif
                                    <li class="{{ areActiveRoutes(['reviews.index'])}}">
                                        <a class="nav-link" href="{{route('reviews.index')}}">{{__('Product Reviews')}}</a>
                                    </li>
                                    <li class="{{ areActiveRoutes(['products.bundle.index'])}}">
                                        <a class="nav-link" href="{{route('products.bundle.index')}}">{{__('Product Bundle')}}</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="{{ areActiveRoutes(['flash_deals.index', 'flash_deals.create', 'flash_deals.edit'])}}">
                                <a class="nav-link" href="{{ route('flash_deals.index') }}">
                                    <i class="fa fa-fw fa-bolt"></i>
                                    <span class="menu-title">{{__('Flash Deal')}}</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-fw fa-dollar"></i>
                                    <span class="menu-title">{{__('Sales')}}</span>
                                    <i class="arrow pull-right"></i>
                                </a>
                                <ul class="collapse">
                                    <li class="{{ areActiveRoutes(['orders.list.orders','sales.show'])}}">
                                        <a class="nav-link" href="{{ route('orders.list.orders') }}">{{__('Order List')}}</a>
                                    </li>
                                    <li class="{{ areActiveRoutes(['transaction.index','transaction.details','transaction.show.payment','transaction.show.invoice']) }}">
                                        <a class="nav-link" href="{{ route('transaction.index') }}">{{__('Transaction')}}</a>
                                    </li>
                                    <li class="{{ areActiveRoutes(['slot.index']) }}">
                                        <a class="nav-link" href="{{ route('slot.index') }}">{{__('Slot Availability')}}</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-user-plus"></i>
                                    <span class="menu-title">{{__('Sellers')}}</span>
                                    <i class="arrow"></i>
                                </a>

                                <!--Submenu-->
                                <ul class="collapse">
                                    <li class="{{ areActiveRoutes(['sellers.index', 'sellers.create', 'sellers.edit', 'sellers.payment_history'])}}">
                                        <a class="nav-link" href="{{route('sellers.index')}}">{{__('Seller List')}}</a>
                                    </li>
                                    <li class="{{ areActiveRoutes(['sellers.payment_histories'])}}">
                                        <a class="nav-link" href="{{ route('sellers.payment_histories') }}">{{__('Seller Payments')}}</a>
                                    </li>
                                    <li class="{{ areActiveRoutes(['business_settings.vendor_commission'])}}">
                                        <a class="nav-link" href="{{ route('business_settings.vendor_commission') }}">{{__('Seller Commission')}}</a>
                                    </li>
                                    <li class="{{ areActiveRoutes(['seller_verification_form.index'])}}">
                                        <a class="nav-link" href="{{route('seller_verification_form.index')}}">{{__('Seller Verification Form')}}</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-user-plus"></i>
                                    <span class="menu-title">{{__('Customers')}}</span>
                                    <i class="arrow pull-right"></i>
                                    @if (count($userRegister) > 0)
                                        <span class="fa-pulse pull-right" style="margin-right: 10px;"><i class="fa fa-circle"></i></span>
                                    @endif
                                </a>

                                <!--Submenu-->
                                <ul class="collapse">
                                    <li class="{{ areActiveRoutes(['customers.index'])}}">
                                        <a class="nav-link" href="{{ route('customers.index') }}">{{__('Customer list')}}</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-money"></i>
                                    <span class="menu-title">{{__('Payments')}}</span>
                                    <i class="arrow"></i>
                                </a>

                                <!--Submenu-->
                                <ul class="collapse">
                                    <li class="{{ areActiveRoutes(['admin.payment.index'])}}">
                                        <a class="nav-link" href="{{ route('admin.payment.index') }}">{{__('Payment List')}}</a>
                                    </li>
                                    <li class="{{ areActiveRoutes(['admin.payment.confirm'])}}">
                                        <a class="nav-link" href="{{ route('admin.payment.confirm') }}">{{__('Confirm Payment')}}</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-envelope"></i>
                                    <span class="menu-title">{{__('Messaging')}}</span>
                                    <i class="arrow"></i>
                                </a>

                                <!--Submenu-->
                                <ul class="collapse">
                                    <li class="{{ areActiveRoutes(['newsletters.index'])}}">
                                        <a class="nav-link" href="{{route('newsletters.index')}}">{{__('Newsletters')}}</a>
                                    </li>
                                    <li class="{{ areActiveRoutes(['support_ticket.admin_index', 'support_ticket.admin_show'])}}">
                                        <a class="nav-link" href="{{ route('support_ticket.admin_index') }}">
                                            <span class="menu-title">{{__('Support Tickets')}}</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-briefcase"></i>
                                    <span class="menu-title">{{__('General Settings')}}</span>
                                    <i class="arrow"></i>
                                </a>

                                <!--Submenu-->
                                <ul class="collapse">
                                    <li class="{{ areActiveRoutes(['activation.index'])}}">
                                        <a class="nav-link" href="{{route('activation.index')}}">{{__('Activation')}}</a>
                                    </li>
                                    <li class="{{ areActiveRoutes(['smtp_settings.index'])}}">
                                        <a class="nav-link" href="{{ route('smtp_settings.index') }}">{{__('SMTP Settings')}}</a>
                                    </li>
                                    <li class="{{ areActiveRoutes(['whatsapp_settings.index'])}}">
                                        <a class="nav-link" href="{{ route('whatsapp_settings.index') }}">{{__('Whatsapp Settings')}}</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-desktop"></i>
                                    <span class="menu-title">{{__('Frontend Settings')}}</span>
                                    <i class="arrow"></i>
                                </a>

                                <!--Submenu-->
                                <ul class="collapse">
                                    <li class="{{ areActiveRoutes(['home_settings.index', 'home_banners.index', 'sliders.index', 'home_categories.index', 'home_banners.create', 'home_categories.create', 'home_categories.edit', 'sliders.create'])}}">
                                        <a class="nav-link" href="{{route('home_settings.index')}}">{{__('Home')}}</a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <span class="menu-title">{{__('Policy Pages')}}</span>
                                            <i class="arrow"></i>
                                        </a>

                                        <!--Submenu-->
                                        <ul class="collapse">

                                            <li class="{{ areActiveRoutes(['sellerpolicy.index'])}}">
                                                <a class="nav-link" href="{{route('sellerpolicy.index', 'seller_policy')}}">{{__('Seller Policy')}}</a>
                                            </li>
                                            <li class="{{ areActiveRoutes(['returnpolicy.index'])}}">
                                                <a class="nav-link" href="{{route('returnpolicy.index', 'return_policy')}}">{{__('Return Policy')}}</a>
                                            </li>
                                            <li class="{{ areActiveRoutes(['supportpolicy.index'])}}">
                                                <a class="nav-link" href="{{route('supportpolicy.index', 'support_policy')}}">{{__('Support Policy')}}</a>
                                            </li>
                                            <li class="{{ areActiveRoutes(['terms.index'])}}">
                                                <a class="nav-link" href="{{route('terms.index', 'terms')}}">{{__('Terms & Conditions')}}</a>
                                            </li>
                                            <li class="{{ areActiveRoutes(['privacypolicy.index'])}}">
                                                <a class="nav-link" href="{{route('privacypolicy.index', 'privacy_policy')}}">{{__('Privacy Policy')}}</a>
                                            </li>
                                        </ul>

                                    </li>
                                    <li class="{{ areActiveRoutes(['links.index', 'links.create', 'links.edit'])}}">
                                        <a class="nav-link" href="{{route('links.index')}}">{{__('Useful Link')}}</a>
                                    </li>
                                    <li class="{{ areActiveRoutes(['generalsettings.index'])}}">
                                        <a class="nav-link" href="{{route('generalsettings.index')}}">{{__('General Settings')}}</a>
                                    </li>
                                    <li class="{{ areActiveRoutes(['generalsettings.logo'])}}">
                                        <a class="nav-link" href="{{route('generalsettings.logo')}}">{{__('Logo Settings')}}</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-user"></i>
                                    <span class="menu-title">{{__('Staffs')}}</span>
                                    <i class="arrow"></i>
                                </a>

                                <!--Submenu-->
                                <ul class="collapse">
                                    <li class="{{ areActiveRoutes(['staffs.index', 'staffs.create', 'staffs.edit'])}}">
                                        <a class="nav-link" href="{{ route('staffs.index') }}">{{__('All staffs')}}</a>
                                    </li>
                                    <li class="{{ areActiveRoutes(['roles.index', 'roles.create', 'roles.edit'])}}">
                                        <a class="nav-link" href="{{route('roles.index')}}">{{__('Staff permissions')}}</a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        <li>
                            <a href="#">
                                <i class="fa fa-file"></i>
                                <span class="menu-title">{{__('Reports')}}</span>
                                <i class="arrow"></i>
                            </a>
                            <!--Submenu-->
                            <ul class="collapse">
                                <li class="{{ areActiveRoutes(['stock_report.index'])}}">
                                    <a class="nav-link" href="{{ route('stock_report.index') }}">{{__('Stock Report')}}</a>
                                </li>
                                <li class="{{ areActiveRoutes(['seller_report.index'])}}">
                                    <a class="nav-link" href="{{ route('seller_report.index') }}">{{__('Seller Report')}}</a>
                                </li>
                                <li class="{{ areActiveRoutes(['seller_sale_report.index'])}}">
                                    <a class="nav-link" href="{{ route('seller_sale_report.index') }}">{{__('Seller Based Selling Report')}}</a>
                                </li>
                                <li class="{{ areActiveRoutes(['wish_report.index'])}}">
                                    <a class="nav-link" href="{{ route('wish_report.index') }}">{{__('Product Wish Report')}}</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--================================-->
        <!--End menu-->

    </div>
</nav>
<style>
.fa-pulse {
    color: red;
	display: inline-block;
	-moz-animation: pulse 1s infinite linear;
	-o-animation: pulse 1s infinite linear;
	-webkit-animation: pulse 1s infinite linear;
	animation: pulse 1s infinite linear;
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
