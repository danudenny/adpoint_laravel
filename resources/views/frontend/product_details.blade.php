@extends('frontend.layouts.app')

@section('meta_title'){{ $product->meta_title }}@stop

@section('meta_description'){{ $product->meta_description }}@stop

@section('meta_keywords'){{ $product->tags }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $product->meta_title }}">
    <meta itemprop="description" content="{{ $product->meta_description }}">
    <meta itemprop="image" content="{{ asset($product->meta_img) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $product->meta_title }}">
    <meta name="twitter:description" content="{{ $product->meta_description }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ asset($product->meta_img) }}">
    <meta name="twitter:data1" content="{{ single_price($product->unit_price) }}">
    <meta name="twitter:label1" content="Price">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $product->meta_title }}" />
    <meta property="og:type" content="product" />
    <meta property="og:url" content="{{ route('product', $product->slug) }}" />
    <meta property="og:image" content="{{ asset($product->meta_img) }}" />
    <meta property="og:description" content="{{ $product->meta_description }}" />
    <meta property="og:site_name" content="{{ env('APP_NAME') }}" />
    <meta property="og:price:amount" content="{{ single_price($product->unit_price) }}" />
@endsection

@section('content')
    <!-- SHOP GRID WRAPPER -->
    <section class="product-details-area">
        <div class="container">
            <div class="bg-white">

                <!-- Product gallery and Description -->
                <div class="row no-gutters cols-xs-space cols-sm-space cols-md-space">
                    <div class="col-lg-6">
                        <div class="product-gal sticky-top d-flex flex-row-reverse">
                            @if(is_array(json_decode($product->photos)) && count(json_decode($product->photos)) > 0)
                                <div class="product-gal-img">
                                    <img class="xzoom img-fluid" src="{{ asset(json_decode($product->photos)[0]) }}" xoriginal="{{ asset(json_decode($product->photos)[0]) }}" />
                                </div>
                                <div class="product-gal-thumb">
                                    <div class="xzoom-thumbs">
                                        @foreach (json_decode($product->photos) as $key => $photo)
                                            <a href="{{ asset($photo) }}">
                                                <img class="xzoom-gallery" width="80" src="{{ asset($photo) }}"  @if($key == 0) xpreview="{{ asset($photo) }}" @endif>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <!-- Product description -->
                        <div class="product-description-wrapper">
                            <!-- Product title -->
                            <h2 class="product-title">
                                {{ __($product->name) }}
                            </h2>
                            <ul class="breadcrumb">
                                <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                <li><a href="{{ route('categories.all') }}">{{__('All Categories')}}</a></li>
                                <li><a href="{{ route('products.category', $product->category->slug) }}">{{ $product->category->name }}</a></li>
                                <li><a href="{{ route('products.subcategory', $product->subcategory->slug) }}">{{ $product->subcategory->name }}</a></li>
                            </ul>

                            <div class="row">
                                <div class="col-6">
                                    <!-- Rating stars -->
                                    <div class="rating mb-1">
                                        @php
                                            $total = 0;
                                            $total += $product->reviews->count();
                                        @endphp
                                        <span class="star-rating">
                                            {{ renderStarRating($product->rating) }}
                                        </span>
                                        <span class="rating-count">({{ $total }} {{__('customer reviews')}})</span>
                                    </div>
                                    <div class="sold-by">
                                        <div class="row">
                                            <div class="col-md-3">

                                            </div>
                                            <div class="col-md-9">
                                                <small class="mr-2">{{__('Sold by')}}: </small>
                                                @if ($product->added_by == 'seller' && \App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
                                                    <a href="{{ route('shop.visit', $product->user->shop->slug) }}">{{ $product->user->shop->name }}</a>
                                                @else
                                                    {{ __('Inhouse product') }}
                                                @endif
        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 text-right">
                                    <ul class="inline-links inline-links--style-1">
                                        @php
                                            $qty = 0;
                                            foreach (json_decode($product->variations) as $key => $variation) {
                                                $qty += $variation->qty;
                                            }
                                            $available = $product->available;
                                        @endphp
                                        @if($available === 1)
                                            <li>
                                                <span class="badge badge-md badge-pill bg-green">
                                                    <i class="fa fa-check"></i> {{__('Available')}}
                                                </span>
                                            </li>
                                        @else
                                            <li>
                                                <span class="badge badge-md badge-pill bg-red">
                                                    <i class="fa fa-times"></i> {{__('Not Available')}}
                                                </span>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>

                            @if (Auth::user() != null)
                                @if(home_price($product->id) != home_discounted_price($product->id))
                                    <div class="row no-gutters mt-4">
                                        <div class="col-2">
                                            <div class="product-description-label">{{__('Price')}}:</div>
                                        </div>
                                        <div class="col-10">
                                            <div class="product-price-old">
                                                <del>
                                                    {{ home_price($product->id) }}
                                                    <span>{{ $product->unit }}</span>
                                                </del>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row no-gutters mt-3">
                                        <div class="col-2">
                                            <div class="product-description-label mt-1">{{__('Discount Price')}}:</div>
                                        </div>
                                        <div class="col-10">
                                            <div class="product-price">
                                                <strong>
                                                    {{ home_discounted_price($product->id) }}
                                                </strong>
                                                <span class="piece">{{ $product->unit }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="row no-gutters mt-3">
                                        <div class="col-2">
                                            <div class="product-description-label">{{__('Price')}}:</div>
                                        </div>
                                        <div class="col-10">
                                            <div class="product-price">
                                                <strong>
                                                    {{ home_discounted_price($product->id) }}
                                                </strong>
                                                <span class="piece">{{ $product->unit }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="row no-gutters mt-3">
                                    <div class="col-2">
                                        <div class="product-description-label">{{__('Price')}}:</div>
                                    </div>
                                    <div class="col-10">
                                        <div class="product-price">
                                            <strong>
                                                XXX
                                            </strong>
                                            <span class="piece">{{ $product->unit }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            <hr>

                            <form id="option-choice-form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">

                                @foreach (json_decode($product->choice_options) as $key => $choice)

                                <div class="row no-gutters">
                                    <div class="col-2">
                                        <div class="product-description-label mt-2 ">{{ $choice->title }}:</div>
                                    </div>
                                    <div class="col-10">
                                        <ul id="choiceOptions" class="list-inline checkbox-alphanumeric checkbox-alphanumeric--style-1 mb-2">
                                            @foreach ($choice->options as $key => $option)
                                                <li>
                                                    <input type="radio" id="{{ $choice->title }}-{{ $option }}" name="{{ $choice->title }}" value="{{ $option }}" @if($key == 0) checked @endif>
                                                    <label for="{{ $choice->title }}-{{ $option }}">{{ $option }}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                @endforeach

                                <!-- Quantity + Add to cart -->
                                <div class="row no-gutters">
                                    <div class="col-2">
                                        <div class="product-description-label mt-2">{{__('Quantity')}}:</div>
                                    </div>
                                    <div class="col-10">
                                        <div class="product-quantity d-flex align-items-center">
                                            <div class="input-group input-group--style-2 pr-3" style="width: 160px;">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-number" type="button" data-type="minus" data-field="quantity" disabled="disabled">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </span>
                                                <input type="text" name="quantity" class="form-control input-number text-center" placeholder="1" id="quantity" value="1" min="1" max="10">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-number" type="button" data-type="plus" data-field="quantity">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row no-gutters">
                                    <div class="col-2">
                                        <div class="product-description-label mt-2">{{__('Date')}}:</div>
                                    </div>
                                    <div class="col-10">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="start_date" id="startDate" autocomplete="off" required>
                                            </div>
                                            <p>To</p>
                                            <div class="col-md-5">
                                                <input type="text" class="form-control" name="end_date" id="endDate" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <hr>

                                <div class="row no-gutters pb-3 d-none" id="chosen_price_div">
                                    <div class="col-2">
                                        <div class="product-description-label">{{__('Total Price')}}:</div>
                                    </div>
                                    <div class="col-10">
                                        <div class="product-price">
                                            <strong id="chosen_price">

                                            </strong>
                                        </div>
                                    </div>
                                </div>

                            </form>

                            <div class="d-table width-100 mt-3">
                                <div class="d-table-cell">
                                    <!-- Buy Now button -->
                                    @if(count(json_decode($product->variations, true)) >= 1)
                                        @if ($qty > 0)
                                            <button type="button" id="buynow" class="btn btn-success btn-circle" onclick="buyNow()">
                                                <i class="fa fa-shopping-cart"></i> {{__('Buy Now')}}
                                            </button>
                                        @endif
                                    @endif
                                    <!-- Add to cart button -->
                                    <button type="button" id="addtocart" class="btn btn-orange btn-circle ml-2" onclick="addToCart()">
                                        <i class="fa fa-cart-plus"></i>
                                        <span class="d-none d-md-inline-block"> {{__('Add to cart')}}</span>
                                    </button>
                                </div>
                            </div>


                            <hr class="mt-3 mb-0">

                            <div class="d-table width-100 mt-2">
                                <div class="d-table-cell">
                                    <!-- Add to wishlist button -->
                                    <button type="button" class="btn pl-0 btn-link strong-700" onclick="addToWishList({{ $product->id }})">
                                       <i class="fa fa-heart"></i> {{__('Add to wishlist')}}
                                    </button>
                                    <!-- Add to compare button -->
                                    <button type="button" class="btn btn-link btn-icon-left strong-700" onclick="addToCompare({{ $product->id }})">
                                    <i class="fa fa-refresh"></i>{{__('Add to compare')}}
                                    </button>
                                </div>
                            </div>

                            <hr class="mt-2">
                            @if ($product->added_by == 'seller')
                                <div class="row no-gutters mt-3">
                                    <div class="col-2">
                                        <div class="product-description-label alpha-6">{{__('Seller Guarantees')}}:</div>
                                    </div>
                                    <div class="col-10 pull-left">
                                        @if ($product->user->seller->verification_status == 1)
                                            <b>{{__('Verified seller')}}</b> <i class="fa fa-check-square text-success"></i>
                                        @else
                                            {{__('Non verified seller')}} <i class="fa fa-minus-square text-danger"></i>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="row no-gutters mt-3">
                                <div class="col-2">
                                    <div class="product-description-label alpha-6">{{__('Payment')}}:</div>
                                </div>
                                <div class="col-10">
                                    <ul class="inline-links">
                                        <li>
                                            <img src="{{ asset('frontend/images/icons/cards/bca.png') }}" width="60" class="">
                                        </li>
                                        <li>
                                            <img src="{{ asset('frontend/images/icons/cards/mandiri.png') }}" width="60" class="">
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="row no-gutters mt-3">
                                <div class="col-10">
                                    <button data-toggle="collapse" data-target="#showQR" class="btn btn-success btn-circle">
                                        <i class="fa fa-qrcode"></i>
                                        {{__('Show QRCode')}}
                                    </button>
                                    <div id="showQR" class="collapse">
                                        <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->merge('/public/uploads/admin_logo/logo_ad_qr.png', .3)->generate(Request::url())) !!} ">
                                    </div>
                                </div>
                            </div>


                            <hr class="mt-4">
                            <div class="row no-gutters mt-4">
                                <div class="col-2">
                                    <div class="product-description-label mt-2">{{__('Share')}}:</div>
                                </div>
                                <div class="col-10">
                                    <div id="share"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="gry-bg">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 d-none d-xl-block">
                    <div class="seller-info-box mb-3">
                        <div class="sold-by position-relative">
                            @if ($product->added_by == 'seller' && \App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1 && $product->user->seller->verification_status == 1)
                                <div class="position-absolute medal-badge">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" viewBox="0 0 287.5 442.2">
                                        <polygon style="fill:#F8B517;" points="223.4,442.2 143.8,376.7 64.1,442.2 64.1,215.3 223.4,215.3 "/>
                                        <circle style="fill:#FBD303;" cx="143.8" cy="143.8" r="143.8"/>
                                        <circle style="fill:#F8B517;" cx="143.8" cy="143.8" r="93.6"/>
                                        <polygon style="fill:#FCFCFD;" points="143.8,55.9 163.4,116.6 227.5,116.6 175.6,154.3 195.6,215.3 143.8,177.7 91.9,215.3 111.9,154.3
                                        60,116.6 124.1,116.6 "/>
                                    </svg>
                                </div>
                            @endif
                            <div class="title">{{__('Sold By')}}</div>
                            {{-- @if($product->added_by == 'seller' && ) --}}
                            @php
                                $sellerInfo = \DB::table('users as u')
                                        ->join('shops as s', 's.user_id', 'u.id')
                                        ->where('u.id', 20)
                                        ->first();
                            @endphp
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="{{ asset($sellerInfo->logo) }}" alt="" width="80">
                                </div>
                                <div class="col-md-9">
                                    <a href="{{ route('shop.visit', $sellerInfo->slug) }}" class="name d-block">{{ $sellerInfo->name }}
                                        <span class="ml-2"><i class="fa fa-check-circle" style="color:green"></i></span>
                                    </a>
                                    <div class="location">{{ $sellerInfo->address }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row no-gutters align-items-center">
                            @if($product->added_by == 'seller')
                                <div class="col">
                                    <a href="{{ route('shop.visit', $sellerInfo->slug) }}" class="d-block store-btn">{{__('Visit Store')}}</a>
                                </div>
                                <div class="col">
                                    <ul class="social-media social-media--style-1-v4 text-center">
                                        <li>
                                            <a href="{{ $sellerInfo->facebook }}" class="facebook" target="_blank" data-toggle="tooltip" data-original-title="Facebook">
                                                <i class="fa fa-facebook"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ $sellerInfo->google }}" class="google" target="_blank" data-toggle="tooltip" data-original-title="Google">
                                                <i class="fa fa-google"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ $sellerInfo->twitter }}" class="twitter" target="_blank" data-toggle="tooltip" data-original-title="Twitter">
                                                <i class="fa fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ $sellerInfo->youtube }}" class="youtube" target="_blank" data-toggle="tooltip" data-original-title="Youtube">
                                                <i class="fa fa-youtube"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="seller-top-products-box bg-white sidebar-box mb-3">
                        <div class="box-title">
                            {{__('Top Selling Products From This Seller')}}
                        </div>
                        <div class="box-content">
                            @foreach (filter_products(\App\Product::where('user_id', 20)->orderBy('num_of_sale', 'desc'))->limit(4)->get() as $key => $top_product)
                            <div class="mb-3 product-box-3">
                                <div class="clearfix">
                                    <div class="product-image float-left img-fluid">
                                        <a href="{{ route('product', $top_product->slug) }}" style="background-image:url('{{ asset($top_product->thumbnail_img) }}');"></a>
                                    </div>
                                    <div class="product-details float-left">
                                        <h4 class="title text-truncate">
                                            <a href="{{ route('product', $top_product->slug) }}" class="d-block text-sm">{{ $top_product->name }}</a>
                                        </h4>
                                        <div class="star-rating star-rating-sm mt-1">
                                            {{ renderStarRating($top_product->rating) }}
                                        </div>
                                        <div class="price-box">
                                            <!-- @if(home_base_price($top_product->id) != home_discounted_base_price($top_product->id))
                                                <del class="old-product-price strong-400">{{ home_base_price($top_product->id) }}</del>
                                            @endif -->
                                            <span class="product-price strong-600 text-sm">{{ home_discounted_base_price($top_product->id) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="product-desc-tab bg-white">
                        <div class="tabs tabs--style-2">
                            <ul class="nav nav-tabs justify-content-center sticky-top bg-white">
                                <li class="nav-item">
                                    <a href="#tab_default_1" data-toggle="tab" class="nav-link text-uppercase strong-600 active show">{{__('Description')}}</a>
                                </li>
                                @if($product->video_link != null)
                                    <li class="nav-item">
                                        <a href="#tab_default_2" data-toggle="tab" class="nav-link text-uppercase strong-600">{{__('Video')}}</a>
                                    </li>
                                @endif
                                @if($product->pdf != null)
                                    <li class="nav-item">
                                        <a href="#tab_default_3" data-toggle="tab" class="nav-link text-uppercase strong-600">{{__('Downloads')}}</a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a href="#tab_default_4" data-toggle="tab" class="nav-link text-uppercase strong-600">{{__('Reviews')}}</a>
                                </li>
                                @if($product->termin_pembayaran != null)
                                <li class="nav-item">
                                    <a href="#tab_default_5" data-toggle="tab" class="nav-link text-uppercase strong-600">{{__('Termin Pembayaran')}}</a>
                                </li>
                                @endif
                                @if ($product->audien_target != null && $product->statistik_masyarakat != null && $product->jumlah_pendengarradio != null && $product->target_pendengarradio != null)
                                <li class="nav-item">
                                    <a href="#tab_default_6" data-toggle="tab" class="nav-link text-uppercase strong-600">{{__('Demografi Wilayah')}}</a>
                                </li>
                                @endif
                            </ul>
                            <div class="tab-content pt-0">
                                <div class="tab-pane active show" id="tab_default_1">
                                    <div class="py-2 px-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <small id="alamat" hidden>{{ $product->alamat }}</small>
                                                <p>{!! $product->description !!}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <small id="coords" hidden>{{ $product->latlong }}</small>
                                                <div id="detailsProductMap" class="map" style="height: 300px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab_default_2">
                                    <div class="fluid-paragraph py-2">
                                        <!-- 16:9 aspect ratio -->
                                        <div class="embed-responsive embed-responsive-16by9 mb-5">
                                            @if ($product->video_provider == 'youtube' && $product->video_link != null)
                                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ explode('=', $product->video_link)[1] }}"></iframe>
                                            @elseif ($product->video_provider == 'dailymotion' && $product->video_link != null)
                                                <iframe class="embed-responsive-item" src="https://www.dailymotion.com/embed/video/{{ explode('video/', $product->video_link)[1] }}"></iframe>
                                            @elseif ($product->video_provider == 'vimeo' && $product->video_link != null)
                                                <iframe src="https://player.vimeo.com/video/{{ explode('vimeo.com/', $product->video_link)[1] }}" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_default_3">
                                    <div class="py-2 px-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="{{ asset($product->pdf) }}">{{ __('Download') }}</a>
                                            </div>
                                        </div>
                                        <span class="space-md-md"></span>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab_default_5">
                                    <div class="py-2 px-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php echo $product->termin_pembayaran; ?>
                                            </div>
                                        </div>
                                        <span class="space-md-md"></span>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab_default_6">
                                    <div class="py-2 px-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php echo $product->audien_target; ?><br>
                                                <?php echo $product->statistik_masyarakat; ?><br>
                                                <?php echo $product->jumlah_pendengarradio; ?><br>
                                                <?php echo $product->target_pendengarradio; ?>
                                            </div>
                                        </div>
                                        <span class="space-md-md"></span>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab_default_4">
                                    <div class="fluid-paragraph py-4">
                                        @foreach ($product->reviews as $key => $review)
                                            <div class="block block-comment">
                                                <div class="block-image">
                                                    <img src="{{ asset($review->user->avatar_original) }}" class="rounded-circle">
                                                </div>
                                                <div class="block-body">
                                                    <div class="block-body-inner">
                                                        <div class="row no-gutters">
                                                            <div class="col">
                                                                <h3 class="heading heading-6">
                                                                    <a href="javascript:;">{{ $review->user->name }}</a>
                                                                </h3>
                                                                <span class="comment-date">
                                                                    {{ date('d-m-Y', strtotime($review->created_at)) }}
                                                                </span>
                                                            </div>
                                                            <div class="col">
                                                                <div class="rating text-right clearfix d-block">
                                                                    <span class="star-rating star-rating-sm float-right">
                                                                        @for ($i=0; $i < $review->rating; $i++)
                                                                            <i class="fa fa-star active"></i>
                                                                        @endfor
                                                                        @for ($i=0; $i < 5-$review->rating; $i++)
                                                                            <i class="fa fa-star"></i>
                                                                        @endfor
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <p class="comment-text">
                                                            {{ $review->comment }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        @if(count($product->reviews) <= 0)
                                            <div class="text-center">
                                                {{ __('There have been no reviews for this product yet.') }}
                                            </div>
                                        @endif

                                        @if(Auth::check())
                                            @php
                                                $commentable = false;
                                            @endphp
                                            @foreach ($product->orderDetails as $key => $orderDetail)
                                                @if($orderDetail->order->user_id == Auth::user()->id && $orderDetail->delivery_status == 'delivered' && \App\Review::where('user_id', Auth::user()->id)->where('product_id', $product->id)->first() == null)
                                                    @php
                                                        $commentable = true;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            @if ($commentable)
                                                <div class="leave-review">
                                                    <div class="section-title section-title--style-1">
                                                        <h3 class="section-title-inner heading-6 strong-600 text-uppercase">
                                                            {{__('Write a review')}}
                                                        </h3>
                                                    </div>
                                                    <form class="form-default" role="form" action="{{ route('reviews.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="" class="text-uppercase c-gray-light">{{__('Your name')}}</label>
                                                                    <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" disabled required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="" class="text-uppercase c-gray-light">{{__('Email')}}</label>
                                                                    <input type="text" name="email" value="{{ Auth::user()->email }}" class="form-control" required disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="c-rating mt-1 mb-1 clearfix d-inline-block">
                                                                    <input type="radio" id="star5" name="rating" value="5" required/>
                                                                    <label class="star" for="star5" title="Awesome" aria-hidden="true"></label>
                                                                    <input type="radio" id="star4" name="rating" value="4" required/>
                                                                    <label class="star" for="star4" title="Great" aria-hidden="true"></label>
                                                                    <input type="radio" id="star3" name="rating" value="3" required/>
                                                                    <label class="star" for="star3" title="Very good" aria-hidden="true"></label>
                                                                    <input type="radio" id="star2" name="rating" value="2" required/>
                                                                    <label class="star" for="star2" title="Good" aria-hidden="true"></label>
                                                                    <input type="radio" id="star1" name="rating" value="1" required/>
                                                                    <label class="star" for="star1" title="Bad" aria-hidden="true"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-sm-12">
                                                                <textarea class="form-control" rows="4" name="comment" placeholder="{{__('Your review')}}" required></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="text-right">
                                                            <button type="submit" class="btn btn-styled btn-base-1 btn-circle mt-4">
                                                                {{__('Send review')}}
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#addtocart').prop('disabled', true);
            $('#buynow').prop('disabled', true);
    		$('#share').share({
    			networks: ['facebook','twitter','linkedin','tumblr','in1','stumbleupon','digg'],
    			theme: 'square'
    		});
            getVariantPrice();

            var data = [];
            $('#choiceOptions').children().each(function(i, result){
                var periode = result.getElementsByTagName('input');
                $.each(periode, function(i, option){
                    var choice = $(this).val();
                    data.push(choice);
                })
            });

            $('#option-choice-form input').on('change', function(e){
                var periode = $(this).val();
                var start_date = $('#startDate').val();

                if (start_date != '') {
                    if (periode === 'Harian') {
                        dateEndByDay();
                    }else if (periode === 'Mingguan') {
                        dateEndByWeek();
                    }else if(periode === 'Bulanan'){
                        dateEndByMonth();
                    }else if (periode === 'TigaBulan') {
                        dateEndByThreeMonth();
                    }else if (periode === 'EnamBulan') {
                        dateEndBySixMonth();
                    }else if (periode === 'Tahunan') {
                        dateEndByYear();
                    }
                }else{
                    $('#endDate').attr('value', '');
                }
                getVariantPrice();
            });

            // Datepicker
            var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
            $('#startDate').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'dd mmm yyyy',
                iconsLibrary: 'fontawesome',
                minDate: today,
                close: function(e) {
                    let checked = $('input[name=Periode]:checked').val();
                    $('#addtocart').prop('disabled', false);
                    $('#buynow').prop('disabled', false);
                    switch (checked) {
                        case 'Harian':
                            dateEndByDay();
                            break;
                        case 'Mingguan':
                            dateEndByWeek();
                            break;
                        case 'Bulanan':
                            dateEndByMonth();
                            break;
                        case 'TigaBulan':
                            dateEndByThreeMonth();
                            break;
                        case 'EnamBulan':
                            dateEndBySixMonth();
                            break;
                        case 'Tahunan':
                            dateEndByYear();
                            break;
                        default:
                            break;
                    }
                }
            });

            function dateEndByDay() {
                $('#endDate').empty();
                const quantity = parseInt($('#quantity').val());
                let currentDate = new Date($('#startDate').val());
                let newDate = new Date(currentDate.getFullYear(), currentDate.getMonth() , currentDate.getDate() + quantity);
                $('#endDate').attr('value', dateFormat(newDate))
            }
            function dateEndByWeek(){
                $('#endDate').empty();
                const quantity = parseInt($('#quantity').val()) * 7;
                let currentDate = new Date($('#startDate').val());
                let newDate = new Date(currentDate.getFullYear(), currentDate.getMonth() , currentDate.getDate() + quantity);
                $('#endDate').attr('value', dateFormat(newDate))
            }
            function dateEndByMonth() {
                $('#endDate').empty();
                const quantity = parseInt($('#quantity').val());
                changeDate(quantity);
            }
            function dateEndByThreeMonth() {
                $('#endDate').empty();
                const quantity = parseInt($('#quantity').val()) * 3;
                changeDate(quantity);
            }
            function dateEndBySixMonth() {
                $('#endDate').empty();
                const quantity = parseInt($('#quantity').val()) * 6;
                changeDate(quantity);
            }
            function dateEndByYear() {
                $('#endDate').empty();
                const quantity = parseInt($('#quantity').val()) * 12;
                changeDate(quantity);
            }

            function changeDate(qty){
                let currentDate = new Date($('#startDate').val());
                let newDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + qty, currentDate.getDate());
                let month =new Date(currentDate.getFullYear(), currentDate.getMonth() + (qty + 1), 0);
                if(newDate.getMonth() != month.getMonth()){
                    newDate = month;
                }
                $('#endDate').attr('value', dateFormat(newDate))
            }


            $('#quantity').change(function(){
                let checked = $('input[name=Periode]:checked').val();
                if (checked === 'Harian') {
                    if($('#endDate').val() != ''){
                        dateEndByDay();
                    }
                }else if (checked === 'Mingguan') {
                    if($('#endDate').val() != ''){
                        dateEndByWeek();
                    }
                }else if (checked === 'Bulanan') {
                    if($('#endDate').val() != ''){
                        dateEndByMonth();
                    }
                }else if (checked === 'TigaBulan') {
                    if($('#endDate').val() != ''){
                        dateEndByThreeMonth();
                    }
                }else if (checked === 'EnamBulan') {
                    if($('#endDate').val() != ''){
                        dateEndBySixMonth();
                    }
                }else if (checked === 'Tahunan') {
                    if($('#endDate').val() != ''){
                        dateEndByYear();
                    }
                }
            })


            function nol(x){
                const y = (x>9)?(x>99)?x:''+x:'0'+x;
                return y;
            }

            function dateFormat(date){
                const bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const year = date.getFullYear();
                const month = date.getMonth();
                const dates = date.getDate();
                return nol(dates) + ' ' + bulan[month] + ' ' + year;
            }
        });



    </script>
@endsection
