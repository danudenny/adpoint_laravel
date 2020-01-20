
<section class="slice-sm footer-top-bar bg-white">
    <div class="container sct-inner">
        <div class="row no-gutters">
            <div class="col-lg-3 col-md-6">
                <div class="footer-top-box text-center">
                    <a href="{{ route('sellerpolicy') }}">
                        <i class="la la-file-text"></i>
                        <h4 class="heading-5">{{__('Seller Policy')}}</h4>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-top-box text-center">
                    <a href="{{ route('returnpolicy') }}">
                        <i class="la la-mail-reply"></i>
                        <h4 class="heading-5">{{__('Return Policy')}}</h4>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-top-box text-center">
                    <a href="{{ route('supportpolicy') }}">
                        <i class="la la-support"></i>
                        <h4 class="heading-5">{{__('Support Policy')}}</h4>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-top-box text-center">
                    <a href="{{ route('profile') }}">
                        <i class="la la-dashboard"></i>
                        <h4 class="heading-5">{{__('My Profile')}}</h4>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- FOOTER -->
<footer id="footer" class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                @php
                    $generalsetting = \App\GeneralSetting::first();
                @endphp
                <div class="col-md-4 text-center text-md-left">
                    <div class="col">
                        <a href="{{ route('home') }}" class="d-block">
                            @if($generalsetting->logo != null)
                                <img src="{{ asset($generalsetting->logo) }}" class="" height="44">
                            @else
                                <img src="{{ asset('frontend/images/logo/logo.png') }}" class="" height="44">
                            @endif
                        </a>
                        <p class="mt-3">{{ $generalsetting->description }}</p>
                        <!-- <h4 class="heading heading-xs strong-600 text-uppercase mb-2">
                            {{__('Contact Info')}}
                        </h4>
                        <ul class="footer-links contact-widget">
                            <li>
                               <span class="d-block opacity-5">{{__('Address')}}:</span>
                               <span class="d-block">{{ $generalsetting->address }}</span>
                            </li>
                            <li>
                               <span class="d-block opacity-5">{{__('Phone')}}:</span>
                               <span class="d-block">{{ $generalsetting->phone }}</span>
                            </li>
                            <li>
                               <span class="d-block opacity-5">{{__('Email')}}:</span>
                               <span class="d-block">
                                   <a href="mailto:{{ $generalsetting->email }}">{{ $generalsetting->email  }}</a>
                                </span>
                            </li>
                        </ul> -->
                        <div class="d-inline-block d-md-block mt-2">
                            <form class="form-inline" method="POST" action="{{ route('subscribers.store') }}">
                                @csrf
                                <div class="input-group">
                                    <input type="text" class="form-control" name="email" placeholder="Your Email Address" aria-describedby="basic-addon2" required>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn" style="background: #ff9400; color: white;" type="button">
                                            <i class="fa fa-send" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
                <!-- <div class="col-md-2">
                    <div class="col text-center text-md-left">
                        <h4 class="heading heading-xs strong-600 text-uppercase mb-2">
                            {{__('Support & Help')}}
                        </h4>
                        <ul class="footer-links">
                            @foreach (\App\Link::all() as $key => $link)
                                <li>
                                    <a href="{{ $link->url }}" title="">
                                        {{ $link->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div> -->
                <div class="col-md-3">
                    <div class="col text-center text-md-left">
                        <h4 class="heading heading-xs strong-600 text-uppercase mb-2">
                            {{__('Media Category')}}
                        </h4>
                        <div class="row">
                            <div class="col">
                                <ul class="footer-links">
                                    @foreach (\App\Category::all() as $key => $category)
                                            @if ($key % 2 == 0)
                                                <li><a href="#" title="">{{ $category->name }}</a></li>
                                            @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col">
                                <ul class="footer-links">
                                    @foreach (\App\Category::all() as $key => $category)
                                            @if ($key % 2 != 0)
                                                <li><a href="#" title="">{{ $category->name }}</a></li>
                                            @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="col text-center text-md-left">
                        <h4 class="heading heading-xs strong-600 text-uppercase mb-2">
                            {{__('Area Covered')}}
                        </h4>
                        @php
                            $area_covered = ['DKI Jakarta','Surabaya','Bandung','Semarang','Jogja','Medan','Palembang','Makassar','Bali','Banjarmasin'];
                        @endphp
                        <div class="row">
                            <div class="col">
                                <ul class="footer-links">
                                    @foreach ($area_covered as $key => $ac)
                                        @if ($key % 2 == 0)
                                            <li><a href="#" title="">{{ $ac }}</a></li>
                                        @endif        
                                    @endforeach
                                </ul>
                            </div>
                            <div class="col">
                                <ul class="footer-links">
                                    @foreach ($area_covered as $key => $ac)
                                        @if ($key % 2 != 0)
                                            <li><a href="#" title="">{{ $ac }}</a></li>
                                        @endif        
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="col text-center text-md-left">
                       <h4 class="heading heading-xs strong-600 text-uppercase mb-2">
                          {{__('My Account')}}
                       </h4>

                       <ul class="footer-links">
                            @if (Auth::check())
                                <li>
                                    <a href="{{ route('logout') }}" title="Logout">
                                        {{__('Logout')}}
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('user.login') }}" title="Login">
                                        {{__('Login')}}
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ route('purchase_history.index') }}" title="Order History">
                                    {{__('Order History')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('wishlists.index') }}" title="My Wishlist">
                                    {{__('My Wishlist')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('orders.track') }}" title="Track Order">
                                    {{__('Track Order')}}
                                </a>
                            </li>
                        </ul>
                    </div>
                    @if (\App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
                        <div class="col text-center text-md-left">
                            <div class="mt-4">
                                <h4 class="heading heading-xs strong-600 text-uppercase mb-2">
                                    {{__('Be a Seller')}}
                                </h4>
                                <a href="{{ route('shops.create') }}" class="btn btn-base-1 btn-icon-left">
                                    {{__('Apply Now')}}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom py-3 sct-color-3">
        <div class="container">
            <div class="row row-cols-xs-spaced flex flex-items-xs-middle">
                <div class="col-md-4">
                    <div class="copyright text-center text-md-left">
                        <ul class="copy-links no-margin">
                            <li>
                                © {{ date('Y') }} {{ $generalsetting->site_name }}
                            </li>
                            <li>
                                <a href="{{ route('terms') }}">{{__('Terms')}}</a>
                            </li>
                            <li>
                                <a href="{{ route('privacypolicy') }}">{{__('Privacy policy')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="text-center my-3 my-md-0 social-nav model-2">
                        @if ($generalsetting->facebook != null)
                            <li>
                                <a href="{{ $generalsetting->facebook }}" class="facebook" target="_blank" data-toggle="tooltip" data-original-title="Facebook">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                        @endif
                        @if ($generalsetting->instagram != null)
                            <li>
                                <a href="{{ $generalsetting->instagram }}" class="instagram" target="_blank" data-toggle="tooltip" data-original-title="Instagram">
                                    <i class="fa fa-instagram"></i>
                                </a>
                            </li>
                        @endif
                        @if ($generalsetting->twitter != null)
                            <li>
                                <a href="{{ $generalsetting->twitter }}" class="twitter" target="_blank" data-toggle="tooltip" data-original-title="Twitter">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                        @endif
                        @if ($generalsetting->youtube != null)
                            <li>
                                <a href="{{ $generalsetting->youtube }}" class="youtube" target="_blank" data-toggle="tooltip" data-original-title="Youtube">
                                    <i class="fa fa-youtube"></i>
                                </a>
                            </li>
                        @endif
                        @if ($generalsetting->google_plus != null)
                            <li>
                                <a href="{{ $generalsetting->google_plus }}" class="google-plus" target="_blank" data-toggle="tooltip" data-original-title="Google Plus">
                                    <i class="fa fa-google-plus"></i>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="col-md-4">
                    
                </div>
            </div>
        </div>
    </div>
</footer>
