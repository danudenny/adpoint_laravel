
{{-- <section class="slice-sm footer-top-bar bg-white">
    <div class="container sct-inner">
        <div class="row no-gutters">
            <div class="col-3">
                <div class="footer-top-box text-center">
                    <a href="{{ route('sellerpolicy') }}">
                        <i class="la la-file-text"></i>
                        <h4 class="heading-5">{{__('Seller Policy')}}</h4>
                    </a>
                </div>
            </div>
            <div class="col-3">
                <div class="footer-top-box text-center">
                    <a href="{{ route('returnpolicy') }}">
                        <i class="la la-mail-reply"></i>
                        <h4 class="heading-5">{{__('Return Policy')}}</h4>
                    </a>
                </div>
            </div>
            <div class="col-3">
                <div class="footer-top-box text-center">
                    <a href="{{ route('supportpolicy') }}">
                        <i class="la la-support"></i>
                        <h4 class="heading-5">{{__('Support Policy')}}</h4>
                    </a>
                </div>
            </div>
            <div class="col-3">
                <div class="footer-top-box text-center">
                    <a href="{{ route('profile') }}">
                        <i class="la la-dashboard"></i>
                        <h4 class="heading-5">{{__('My Profile')}}</h4>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section> --}}


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
                        <p class="mt-3">{{ $generalsetting->address }}</p>
                        <div class="d-inline-block d-md-block mt-2">
                            <form class="form-inline" method="POST" action="{{ route('subscribers.store') }}">
                                @csrf
                                <div class="input-group">
                                    <input type="text" class="form-control" name="email" placeholder="Your Email Address" aria-describedby="basic-addon2" required>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn" style="background: #000; color: white;" type="button">
                                            <i class="fa fa-send" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col text-center text-md-left">
                            <div class="row">
                                <div class="col-md-7">
                                    <h4 class="heading text-dark heading-xs strong-600 text-uppercase mb-2">
                                        {{__('About Adpoint')}}
                                    </h4>
                                    <ul class="footer-links">
                                        <li><a href="#" title="">About Us</a></li>
                                        <li><a href="#" title="">Blog</a></li>
                                        <li><a href="#" title="">Contact Us</a></li>
                                        <li><a href="#" title="">Terms and Condition</a></li>
                                        <li><a href="#" title="">Privacy Policy</a></li>
                                        <li><a href="#" title="">Career</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col text-center text-md-left">
                                            <h4 class="heading text-dark heading-xs strong-600 text-uppercase mb-2">
                                                {{__('Seller')}}
                                            </h4>
                                            <ul class="footer-links">
                                                <li><a href="{{ route('how.to.sell') }}" title="">How to sell</a></li>
                                                <li><a href="#" title="">Benefit</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col text-center text-md-left">
                                            <h4 class="heading text-dark heading-xs strong-600 text-uppercase mb-2">
                                                {{__('Buyer')}}
                                            </h4>
                                            <ul class="footer-links">
                                                <li><a href="{{ route('how.to.buy') }}" title="">How to buy</a></li>
                                                <li><a href="#" title="">Benefit</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col text-center text-md-left">
                       <div class="row">
                            <div class="col">
                                <h4 class="heading heading-xs strong-600 text-uppercase mb-2" style="color: black">
                                    {{__('Payment Options')}}
                                </h4>

                                <div class="row justify-content-center">
                                    <div class="col-md-6 w-25">
                                        <img src="{{ asset('frontend/images/icons/cards/bca.png')}}" class="img-fluid">
                                    </div>
                                    <div class="col-md-6 w-25">
                                        <img src="{{ asset('frontend/images/icons/cards/mandiri.png')}}" class="img-fluid">
                                    </div>
                                </div>
                           </div>
                       </div>
                       <div class="row mt-3">
                        <div class="col">
                            <h4 class="heading heading-xs strong-600 text-uppercase mb-2" style="color: black">
                                {{__('Folow us on')}}
                            </h4>

                            <ul class="my-3 my-md-0 social-nav model-2">
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
                       <div class="row mt-3">
                           <div class="col">
                               <h4 class="heading heading-xs strong-600 text-uppercase mb-2" style="color: black">
                                   {{__('Switch Languages')}}
                               </h4>
                               <ul class="inline-links d-lg-inline-block d-flex justify-content-between">
                                   <li class="dropdown" id="lang-change">
                                       @php
                                           if(Session::has('locale')){
                                               $locale = Session::get('locale', Config::get('app.locale'));
                                           }
                                           else{
                                               $locale = 'en';
                                           }
                                       @endphp
                                       <a href="" class="dropdown-toggle top-bar-item" data-toggle="dropdown">
                                           <img src="{{ asset('frontend/images/icons/flags/'.$locale.'.png') }}" class="flag"><span class="language">{{ \App\Language::where('code', $locale)->first()->name }}</span>
                                       </a>
                                       <ul class="dropdown-menu">
                                           @foreach (\App\Language::all() as $key => $language)
                                               <li class="dropdown-item @if($locale == $language) active @endif">
                                                   <a href="#" data-flag="{{ $language->code }}"><img src="{{ asset('frontend/images/icons/flags/'.$language->code.'.png') }}" class="flag"><span class="language">{{ $language->name }}</span></a>
                                               </li>
                                           @endforeach
                                       </ul>
                                   </li>
                               </ul>
                           </div>
                       </div>
                   </div>
                    </div>
                    @auth
                        @php
                            $userSeller = Auth::user()->user_type;
                        @endphp
                        @if($userSeller != 'seller')
                            <div class="col text-center text-md-left">
                                <div class="mt-4">
                                    <h4 class="heading text-dark heading-xs strong-600 text-uppercase mb-2">
                                        {{__('Be a Seller')}}
                                    </h4>
                                    <a href="{{ route('shops.create') }}" class="btn btn-base-1 btn-icon-left">
                                        {{__('Apply Now')}}
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom py-3 sct-color-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 d-flex justify-content-center">
                    <div class="text-center text-white">
                        <span>{{ $generalsetting->description }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
