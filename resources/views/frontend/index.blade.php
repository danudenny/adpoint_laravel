@extends('frontend.layouts.app')

@section('content')
    <style>
        .form-filter-area {
            padding: 6px;
        }
    </style>
    <section class="home-banner-area">
        <div class="container">
            <div class="main-banner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="title-head">Cari space iklan yang sesuai dengan <br> kebutuhan Anda sekarang juga</h1>
                    </div>
                </div>
                <form action="{{ route('search') }}">
                    <div class="row form-filter pt-3 mt-5">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text" class="form-control pb-2 form-filter-area" placeholder="ex: Ampera Raya" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="category" class="form-control">
                                    <option value="" selected disabled>{{__('Chose Media')}}</option>
                                    @foreach (\App\Category::all() as $category)
                                        <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <select class="form-control" name="location" onchange="filter()">
                                    <option value="" selected disabled>{{__('Chose State')}}</option>
                                    @foreach (\App\State::all() as $key => $state)
                                        <option value="{{ urlencode($state->name) }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-dark btn-lg button-search"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="mb-4">
        <div class="container">
            <div class="row mt-5">
                <div class="col-md-12">
                    <h2 class="explore-media">Explore by Media Categories</h2>
                </div>
            </div>
            @php
                $lessCat = [];
                $moreCat = [];
                foreach (\App\Category::all() as $key => $cat) {
                    if ($key <= 5) {
                        $lessCat[$key] = [
                            'icon' => $cat->icon,
                            'count' => $cat->products->count(),
                            'slug' => $cat->slug
                        ];
                    }else {
                        $moreCat[$key] = [
                            'icon' => $cat->icon,
                            'count' => $cat->products->count(),
                            'slug' => $cat->slug
                        ];
                    }
                }
                // dd($lessCat);
            @endphp
            <div class="row" id="lessBox">
                @foreach ($lessCat as $key => $les)
                <div class="col-md-2 col-lg-2 col-sm-4 col-6 d-flex justify-content-center">
                    <a href="{{ route('products.category', $les['slug']) }}">
                        <div class="box-cat">

                            <img src="{{ asset($les['icon']) }}" alt="" class="img-fluid img">
                            <p id="overlay-text">{{ $les['count'] }}</p>

                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="row" id="moreBox" style="display: none">
                @foreach ($moreCat as $key => $mor)
                <div class="col-md-2 col-lg-2 col-sm-4 col-6 d-flex justify-content-center">
                    <a href="{{ route('products.category', $mor['slug']) }}">
                        <div class="box-cat">
                            <img src="{{ asset($mor['icon']) }}" alt="" class="img-fluid img">
                            <p id="overlay-text">{{ $mor['count'] }}</p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <div class="row mt-3 justify-content-center">
                <button class="btn btn-lg btn-dark" id="moreless-button">Show More</button>
            </div>
        </div>
    </section>

    <section class="pt-5 pb-5 bg-gray">
        <div class="container">
            <div class="row">
                <div class="mt-2 col-md-6 d-flex justify-content-center">
                    <div class="card">
                        <div class="card-body text-center">
                            <h3 class="card-title">Are You a Seller?</h3>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-orange">Sell with us</a>
                        </div>
                    </div>
                </div>
                <div class="mt-2 col-md-6 d-flex justify-content-center">
                    <div class="card">
                        <div class="card-body text-center">
                            <h3 class="card-title">Are You a Buyer?</h3>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-success">Buy Ad Space</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-4">
        <div class="container">
            <div class="row mt-3">
                <div class="col-md-12">
                    <img class="img-responsive img-fluid" src="{{ asset('img/bg-img/mid-banner.png') }}" >
                    <div class="row tag-line">
                        <div class="col-5">
                            <h2 class="heading-tag">Memasang iklan lebih mudah dan nyaman, dengan pilihan media</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-4">
        <div class="container" style="margin-top: 20px;">
            <h2 style="text-align: center">Benefits of Joining Us</h2>
            <p style="text-align: center; font-size:16px;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
        </div>
    </section>

    <section class="mb-4">
        @php
            $flash_deal = \App\FlashDeal::where('status', 1)->first();
        @endphp
        @if($flash_deal != null && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date)
        <div class="container">
            <div class="px-2 py-4 p-md-4 bg-white shadow-sm">
                <div class="section-title-1 clearfix">
                    <h3 class="heading-5 strong-700 mb-0 float-left">
                        <span class="mr-4">{{__('Flash Deal')}}</span> <br><br>
                        <div class="countdown countdown--style-1 countdown--style-1-v1" data-countdown-date="{{ date('m/d/Y', $flash_deal->end_date) }}" data-countdown-label="show"></div>
                    </h3>
                </div>
                <div class="caorusel-box">
                    <div class="slick-carousel" data-slick-items="6" data-slick-xl-items="5" data-slick-lg-items="4"  data-slick-md-items="3" data-slick-sm-items="2" data-slick-xs-items="2">
                        @foreach ($flash_deal->flash_deal_products as $key => $flash_deal_product)
                        @php
                            $product = \App\Product::find($flash_deal_product->product_id);
                        @endphp
                        @if ($product != null)
                        <div class="product-card-2 card card-product m-2 shop-cards shop-tech">
                            <div class="card-body p-0">

                                <div class="card-image">
                                    <a href="{{ route('product', $product->slug) }}" class="d-block" style="background-image:url('{{ asset($product->flash_deal_img) }}');">
                                    </a>
                                </div>

                                <div class="p-3" style="height: 150px;">
                                    <div class="price-box">
                                        @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                            <del class="old-product-price strong-400">{{ home_base_price($product->id) }}</del>
                                        @endif
                                        <span class="product-price strong-600">{{ home_discounted_base_price($product->id) }}</span>
                                    </div>
                                    <div class="star-rating star-rating-sm mt-1">
                                        {{ renderStarRating($product->rating) }}
                                    </div>
                                    <h2 class="product-title p-0 text-truncate-2">
                                        <a href="{{ route('product', $product->slug) }}">{{ __($product->name) }}</a>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @else
            <div class="container" hidden></div>
        @endif
    </section>

    @if (\App\BusinessSetting::where('type', 'best_selling')->first()->value == 1)
        <section class="mb-4">
            <div class="container">
                <div class="px-2 py-4 p-md-4 bg-white shadow-sm">
                    <div class="section-title-1 clearfix">
                        <h3 class="heading-5 strong-700 mb-0">
                            <span class="mr-4">{{__('Recommended Ad Space')}}</span>
                        </h3>
                    </div>
                    <div class="caorusel-box">
                        <div class="slick-carousel" data-slick-items="3" data-slick-lg-items="3"  data-slick-md-items="2" data-slick-sm-items="1" data-slick-xs-items="1" data-slick-dots="true" data-slick-rows="4">
                            @foreach (filter_products(\App\Product::where('published', 1)->orderBy('num_of_sale', 'desc'))->limit(20)->get() as $key => $product)
                                <div class="p-2">
                                    <div class="row no-gutters product-box-2 align-items-center">
                                        <div class="col-4">
                                            <div class="position-relative overflow-hidden h-100">
                                                <a href="{{ route('product', $product->slug) }}" class="d-block product-image h-100" style="background-image:url('{{ asset($product->thumbnail_img) }}');">
                                                </a>
                                                <div class="product-btns">
                                                    <button class="btn add-wishlist" title="Add to Wishlist" onclick="addToWishList({{ $product->id }})">
                                                        <i class="la la-heart-o"></i>
                                                    </button>
                                                    <button class="btn add-compare" title="Add to Compare" onclick="addToCompare({{ $product->id }})">
                                                        <i class="la la-refresh"></i>
                                                    </button>
                                                    <button class="btn quick-view" title="Quick view" onclick="showAddToCartModal({{ $product->id }})">
                                                        <i class="la la-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-8 border-left">
                                            <div class="p-3">
                                                <h2 class="product-title mb-0 p-0 text-truncate-2">
                                                    <a href="{{ route('product', $product->slug) }}">{{ __($product->name) }}</a>
                                                </h2>
                                                <div>
                                                    <a target="_blank" href="{{ route('shop.visit', $product->user->shop->slug) }}">
                                                        <i class="text-primary">{{ $product->user->shop->name }}</i>
                                                    </a>
                                                </div>
                                                <div class="star-rating star-rating-sm mb-2">
                                                    {{ renderStarRating($product->rating) }}
                                                </div>
                                                <div class="clearfix">
                                                    <div class="price-box float-left">
                                                        @if (Auth::check())
                                                            @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                                <del class="old-product-price strong-400">{{ home_base_price($product->id) }}</del>
                                                            @endif<br>
                                                            <span class="product-price strong-600">{{ home_discounted_base_price($product->id) }}</span>
                                                        @else 
                                                            <span class="product-price strong-600" title="Please login for show price">xxx</span>
                                                        @endif
                                                    </div>
                                                    <div class="float-right">
                                                        <button class="add-to-cart btn" title="Add to Cart" onclick="showAddToCartModal({{ $product->id }})">
                                                            <i class="la la-shopping-cart"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif


    @if (\App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
        @php
            $array = array();
            foreach (\App\Seller::all() as $key => $seller) {
                if($seller->user != null && $seller->user->shop != null){
                    $total_sale = 0;
                    foreach ($seller->user->products as $key => $product) {
                        $total_sale += $product->num_of_sale;
                    }
                    $array[$seller->id] = $total_sale;
                }
            }
            asort($array);
        @endphp
        <section class="mb-5">
            <div class="container">
                <div class="px-2 py-4 p-md-4 bg-white shadow-sm">
                    <div class="section-title-1 clearfix">
                        <h3 class="heading-5 strong-700 mb-0 float-left">
                            <span class="mr-4">{{__('Media Partner')}}</span>
                        </h3>
                    </div>
                    <div class="caorusel-box">
                        <div class="slick-carousel" data-slick-items="5" data-slick-lg-items="5"  data-slick-md-items="2" data-slick-sm-items="2" data-slick-xs-items="1" data-slick-dots="true" data-slick-rows="2"  data-slick-autoplay="true">
                            @php
                                $count = 0;
                            @endphp
                            @foreach ($array as $key => $value)
                                @if ($count < 20)
                                    @php
                                        $count ++;
                                        $seller = \App\Seller::find($key);
                                        $total = 0;
                                        $rating = 0;
                                        foreach ($seller->user->products as $key => $seller_product) {
                                            $total += $seller_product->reviews->count();
                                            $rating += $seller_product->reviews->sum('rating');
                                        }
                                    @endphp
                                    <div class="p-2">
                                        <div class="row no-gutters box-3 align-items-center border" style="height: 91px;">
                                            <div class="col-4">
                                                <a href="{{ route('shop.visit', $seller->user->shop->slug) }}" class="d-block product-image p-3">
                                                    <img src="{{ asset($seller->user->shop->logo) }}" alt="" class="img-fluid">
                                                </a>
                                            </div>
                                            <div class="col-8 border-left">
                                                <div class="p-3">
                                                    <h2 class="product-title mb-0 p-0 text-truncate">
                                                        <a href="{{ route('shop.visit', $seller->user->shop->slug) }}">{{ __($seller->user->shop->name) }}</a>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

@endsection

@section('script')
    <script>
       $('#moreless-button').on('click', function() {
            $('#moreBox').slideToggle('fast');
            if ($('#moreless-button').text() == "Show More") {
                $(this).text("Show Less");
            } else {
                $(this).text("Show More");
            } 
       })
    </script>
@endsection
