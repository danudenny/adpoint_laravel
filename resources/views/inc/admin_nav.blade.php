<!--NAVBAR-->
<!--===================================================-->
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
<header id="navbar">
    <div id="navbar-container" class="boxed">
        @php
            $generalsetting = \App\GeneralSetting::first();
            $customers = DB::table('users')
                        -> orderBy('id', 'desc')
                        -> where('verified', 0)
                        ->get();
            $sellerNotif = DB::table('sellers as s')
                        -> join('users as u', 'u.id', '=', 's.user_id')
                        ->select([
                            's.id',
                            'u.name',
                            's.created_at',
                            'u.email'
                        ])
                        -> orderBy('s.created_at', 'desc')
                        -> where('s.verification_status', 0)
                        ->get();
            $orderNew = DB::table('orders')
                        -> orderBy('id', 'desc')
                        -> where('approved', 0)
                        ->get();
            $trxNew = DB::table('transactions')
                        -> orderBy('id', 'desc')
                        -> where('payment_status', 0)
                        -> whereIn('status', array('confirmed', 'ready'))
                        ->get();
            $ticketNew = DB::table('tickets as t')
                        -> join('users as u', 'u.id', '=', 't.user_id')
                        ->select([
                            't.id',
                            'u.name',
                            't.created_at',
                            't.subject'
                        ])
                        -> orderBy('t.created_at', 'desc')
                        -> where('t.status', 'pending')
                        -> where('u.user_type', 'seller')
                        ->get();
            $ticketNewCust = DB::table('tickets as t')
                        -> join('users as u', 'u.id', '=', 't.user_id')
                        ->select([
                            't.id',
                            'u.name',
                            't.created_at',
                            't.subject'
                        ])
                        -> orderBy('t.created_at', 'desc')
                        -> where('t.status', 'pending')
                        -> where('u.user_type', 'customer')
                        ->get();
            $ticketNewOpen = DB::table('tickets as t')
                        -> join('users as u', 'u.id', '=', 't.user_id')
                        ->select([
                            't.id',
                            'u.name',
                            't.created_at',
                            't.subject'
                        ])
                        -> orderBy('t.created_at', 'desc')
                        -> where('t.status', 'open')
                        -> where('u.user_type', 'seller')
                        ->get();
            $ticketNewCustOpen = DB::table('tickets as t')
                        -> join('users as u', 'u.id', '=', 't.user_id')
                        ->select([
                            't.id',
                            'u.name',
                            't.created_at',
                            't.subject'
                        ])
                        -> orderBy('t.created_at', 'desc')
                        -> where('t.status', 'open')
                        -> where('u.user_type', 'customer')
                        ->get();
        @endphp

        <!--Brand logo & name-->
        <!--================================-->
        <div class="navbar-header">
            <a href="{{route('admin.dashboard')}}" class="navbar-brand">
                @if($generalsetting->logo != null)
                    <img src="{{ asset($generalsetting->admin_logo) }}" class="brand-icon" alt="{{ $generalsetting->site_name }}">
                @else
                    <img src="{{ asset('img/logo_shop.png') }}" class="brand-icon" alt="{{ $generalsetting->site_name }}">
                @endif
                <div class="brand-title">
                    <span class="brand-text">{{ $generalsetting->site_name }}</span>
                </div>
            </a>
        </div>
        <!--================================-->
        <!--End brand logo & name-->


        <!--Navbar Dropdown-->
        <!--================================-->
        <div class="navbar-content">

            <ul class="nav navbar-top-links">

                <!--Navigation toogle button-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li class="tgl-menu-btn">
                    <a class="mainnav-toggle" href="#">
                        <i class="demo-pli-list-view"></i>
                    </a>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End Navigation toogle button-->



                <!--Search-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li>
                    <div class="custom-search-form">
                        <label class="btn btn-trans" for="search-input" data-toggle="collapse" data-target="#nav-searchbox">
                            <i class="demo-pli-magnifi-glass"></i>
                        </label>
                    </div>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End Search-->

            </ul>
            <ul class="nav navbar-top-links">
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle" aria-expanded="true">    
                        <i class="demo-pli-mail" title="Ticket Notification"></i>
                        @if(count($ticketNew) > 0 || count($ticketNewCust) > 0 || count($ticketNewOpen) > 0 || count($ticketNewCustOpen) > 0)
                            <span class="badge-header fa-pulse"><i class="fa fa-circle"></i></span>
                        @endif
                    </a>

                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="opacity: 1;">
                        <div class="nano scrollable has-scrollbar" style="height: 265px;">
                            <div class="nano-content" tabindex="0" style="right: -17px;">
                                <ul class="head-list">
                                    <li>
                                        @if (count($ticketNew) > 0)
                                            <h4 style="background-color: orange; padding: 10px; border-radius: 5px; color:white;"><i class="fa fa-envelope"></i> Seller Support Tickets</h4>
                                            @foreach ($ticketNew as $key => $val)
                                            <a class="media" href="{{route('support_ticket.admin_show', encrypt($val->id))}}" style="position:relative">
                                                <div class="media-body">
                                                    <p class="mar-no text-nowrap text-main text-semibold">New Ticket Support Message (Pending).</p>
                                                    <p>{{ $val->name }}</p>
                                                    <p><i>{{ $val->subject }}</i></p>
                                                    <label style="font-size:11px;" class="label label-default">{{ $val->created_at }}</label>
                                                </div>
                                            </a>
                                            @endforeach
                                        @endif
                                    </li>
                                    <li>
                                        @if (count($ticketNewCust) > 0)
                                            <h4 style="background-color: #00B9BD; padding: 10px; border-radius: 5px; color:white;"><i class="fa fa-envelope"></i> Customer Support Tickets</h4>
                                            @foreach ($ticketNewCust as $key => $val)
                                            <a class="media" href="{{route('support_ticket.admin_show', encrypt($val->id))}}" style="position:relative">
                                                <div class="media-body">
                                                    <p class="mar-no text-nowrap text-main text-semibold">New Ticket Support Message (Pending).</p>
                                                    <p>{{ $val->name }}</p>
                                                    <p><i>{{ $val->subject }}</i></p>
                                                    <label style="font-size:11px;" class="label label-default">{{ $val->created_at }}</label>
                                                </div>
                                            </a>
                                            @endforeach
                                        @endif
                                    </li>
                                    <li>
                                        @if (count($ticketNewOpen) > 0)
                                            <h4 style="background-color: orange; padding: 10px; border-radius: 5px; color:white;"><i class="fa fa-envelope"></i> Seller Support Tickets</h4>
                                            @foreach ($ticketNewOpen as $key => $val)
                                            <a class="media" href="{{route('support_ticket.admin_show', encrypt($val->id))}}" style="position:relative">
                                                <div class="media-body">
                                                    <p class="mar-no text-nowrap text-main text-semibold">New Ticket Support Message (Open).</p>
                                                    <p>{{ $val->name }}</p>
                                                    <p><i>{{ $val->subject }}</i></p>
                                                    <label style="font-size:11px;" class="label label-default">{{ $val->created_at }}</label>
                                                </div>
                                            </a>
                                            @endforeach
                                        @endif
                                    </li>
                                    <li>
                                        @if (count($ticketNewCustOpen) > 0)
                                            <h4 style="background-color: #00B9BD; padding: 10px; border-radius: 5px; color:white;"><i class="fa fa-envelope"></i> Customer Support Tickets</h4>
                                            @foreach ($ticketNewCustOpen as $key => $val)
                                            <a class="media" href="{{route('support_ticket.admin_show', encrypt($val->id))}}" style="position:relative">
                                                <div class="media-body">
                                                    <p class="mar-no text-nowrap text-main text-semibold">New Ticket Support Message (Open).</p>
                                                    <p>{{ $val->name }}</p>
                                                    <p><i>{{ $val->subject }}</i></p>
                                                    <label style="font-size:11px;" class="label label-default">{{ $val->created_at }}</label>
                                                </div>
                                            </a>
                                            @endforeach
                                        @endif
                                    </li>
                                    <li>
                                        @if(count($ticketNew) > 0 || count($ticketNewCust) > 0 || count($ticketNewOpen) > 0 || count($ticketNewCustOpen) > 0 )
                                            <br>
                                            <a href="{{route('support_ticket.admin_index')}}" type="button" style="color: #333" class="btn btn-primary btn-blocks"><i class="fa fa-list"></i> Show All</a>
                                        @else
                                            <h5 style="text-align: center;"><i class="fa fa-ban text-danger"></i> <i>No Support Message Notifications</i></h5>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                            <div class="nano-pane" style="">
                                <div class="nano-slider" style="height: 170px; transform: translate(0px, 0px);"></div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle" aria-expanded="true">    
                        <i class="demo-pli-bell" title="Pending Notifications"></i>
                        @if(count($customers) > 0 || count($orderNew) > 0 || count($trxNew) > 0 || count($sellerNotif) > 0)
                            <span class="badge-header fa-pulse"><i class="fa fa-circle"></i></span>
                        @endif
                    </a>

                    <!--Notification dropdown menu-->
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="opacity: 1;">
                        <div class="nano scrollable has-scrollbar" style="height: 265px;">
                            <div class="nano-content" tabindex="0" style="right: -17px;">
                                <ul class="head-list">
                                    <li>
                                        @if (count($customers) > 0)
                                            <h4 style="background-color: orange; padding: 10px; border-radius: 5px; color:white;"><i class="fa fa-user"></i> New Users</h4>
                                            @foreach ($customers as $key => $val)
                                            <a class="media" href="{{ route('customers.index') }}" style="position:relative">
                                                <div class="media-body">
                                                    <p class="mar-no text-nowrap text-main text-semibold">User Baru Telah Terdaftar.</p>
                                                    <p>{{ $val->name }}</p>
                                                    <p><i>{{ $val->email }}</i></p>
                                                    <label style="font-size:11px;" class="label label-default">{{ $val->created_at }}</label>
                                                </div>
                                            </a>
                                            @endforeach
                                        @endif
                                    </li>
                                    <li>
                                        @if (count($sellerNotif) > 0)
                                            <h4 style="background-color: #BD1550; padding: 10px; border-radius: 5px; color:white;"><i class="fa fa-user"></i> New Sellers</h4>
                                            @foreach ($sellerNotif as $key => $val)
                                            <a class="media" href="{{ route('sellers.show_verification_request', $val->id) }}" style="position:relative">
                                                <div class="media-body">
                                                    <p class="mar-no text-nowrap text-main text-semibold">Seller Baru Telah Terdaftar.</p>
                                                    <p>{{ $val->name }}</p>
                                                    <p><i>{{ $val->email }}</i></p>
                                                    <label style="font-size:11px;" class="label label-default">{{ $val->created_at }}</label>
                                                </div>
                                            </a>
                                            @endforeach
                                        @endif
                                    </li>
                                    <li>
                                        @if (count($orderNew) > 0)
                                            <h4 style="background-color: #00B9BD; padding: 10px; border-radius: 5px; color:white;"><i class="fa fa-shopping-cart"></i> New Orders</h4>
                                            @foreach ($orderNew as $key => $val)
                                            <a class="media" href="{{ route('orders.list.orders') }}" style="position:relative">
                                                <div class="media-body">
                                                    <p class="mar-no text-nowrap text-main text-semibold">Order Baru Telah Masuk.</p>
                                                    <p><i>{{ $val->code }}</i></p>
                                                    <label style="font-size:11px;" class="label label-default">{{ $val->created_at }}</label>
                                                </div>
                                            </a>
                                            @endforeach
                                        @endif
                                    </li>
                                    <li>
                                        @if (count($trxNew) > 0)
                                        <h4 style="background-color: #004853; padding: 10px; border-radius: 5px; color:white;"><i class="fa fa-money"></i> Unpaid Transactions</h4>
                                            @foreach ($trxNew as $key => $val)
                                            <a class="media" href="{{ route('transaction.details', encrypt($val->id)) }}" style="position:relative">
                                                <div class="media-body">
                                                    <p class="mar-no text-nowrap text-main text-semibold">Transaksi Baru Belum Dibayar.</p>
                                                    <p><i>{{ $val->code }}</i></p>
                                                    <label style="font-size:11px;" class="label label-default">{{ $val->created_at }}</label>
                                                </div>
                                            </a>
                                            @endforeach
                                        @endif
                                    </li>
                                    <li>
                                        @if(count($customers) > 0 || count($orderNew) > 0 || count($trxNew) > 0 || count($sellerNotif) > 0)
                                            <h5 style="display : none;"><i class="fa fa-ban text-danger"></i> <i>No Unread Notifications</i></h5>
                                        @else
                                            <h5 style="text-align: center;"><i class="fa fa-ban text-danger"></i> <i>No Unread Notifications</i></h5>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                            <div class="nano-pane" style="">
                                <div class="nano-slider" style="height: 170px; transform: translate(0px, 0px);"></div>
                            </div>
                        </div>
                    </div>
                </li>

                
                <!--User dropdown-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li id="dropdown-user" class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                        <span class="ic-user pull-right">

                            <i class="demo-pli-male"></i>
                        </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right panel-default">
                        <ul class="head-list">
                            <li>
                                <a href="{{ route('profile.index') }}"><i class="demo-pli-male icon-lg icon-fw"></i> {{__('Profile')}}</a>
                            </li>
                            <li>
                                <a href="{{ route('logout')}}"><i class="demo-pli-unlock icon-lg icon-fw"></i> {{__('Logout')}}</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End user dropdown-->
            </ul>
        </div>
        <!--================================-->
        <!--End Navbar Dropdown-->

    </div>
</header>
