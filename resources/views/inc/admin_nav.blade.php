@php
    $generalsetting = \App\GeneralSetting::first();
@endphp
<header id="navbar">
    <div id="navbar-container" class="boxed">
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
                    </a>

                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="opacity: 1;">
                        <div class="nano scrollable has-scrollbar">
                            <div class="nano-content" tabindex="0" style="margin-top: 10px; margin-bottom: 10px;">
                                <ul class="head-list">
                                    <li>
                                        <a class="media" href="#" style="position:relative">
                                            <div class="media-body">
                                                <b>#</b>
                                                <p>#</p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle" aria-expanded="true">
                        <i class="demo-pli-bell" title="Pending Notifications"></i>
                        @if (Auth::user()->unreadNotifications->count() > 0)
                            <span class="badge badge-danger">{{ Auth::user()->unreadNotifications->count() }}</span>
                        @endif
                    </a>

                    <!--Notification dropdown menu-->
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right" style="opacity: 1;">
                        <div class="nano scrollable has-scrollbar">
                            <div class="nano-content" tabindex="0" style="margin-top: 10px; margin-bottom: 10px;">
                                <ul class="head-list">
                                    @php
                                        $user = Auth::user();
                                    @endphp
                                    @if ($user->unreadNotifications->count() > 0)
                                        @foreach ($user->unreadNotifications as $notif)
                                            @php
                                                $data = json_decode(json_encode($notif->data))
                                            @endphp
                                            <li>
                                                <a class="media" style="color: black;" href="{{ route('mark.as.read', $notif->id) }}" style="position:relative">
                                                    <div class="media-body">
                                                        <b>{{ $data->title }}</b>
                                                        <p>{{$notif->created_at }}</p>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                        <li>
                                            <a class="media" style="color: blue;" href="{{ route('mark.all.as.read') }}" style="position:relative">
                                                Mark All As Read
                                            </a>
                                        </li>
                                    @else 
                                    <li>
                                        <a class="media" style="color: red;">
                                            You have not notification
                                        </a>
                                    </li>
                                    @endif
                                </ul>
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
                                <a href="{{ route('logout')}}" onclick="logoutSession()"><i class="demo-pli-unlock icon-lg icon-fw"></i> {{__('Logout')}}</a>
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

<script>
    function logoutSession(){
        var ls = [
            'pushyToken',
            'pushyTokenAppId',
            'pushyTokenAuth',
        ];

        ls.forEach(element => {
            localStorage.removeItem(element);
        });
    }
</script>
