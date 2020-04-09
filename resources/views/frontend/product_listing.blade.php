@extends('frontend.layouts.app')

@if (isset($subcategory_id))
    @php
        $meta_title = \App\SubCategory::find($subcategory_id)->meta_title;
        $meta_description = \App\SubCategory::find($subcategory_id)->meta_description;
    @endphp
@elseif (isset($category_id))
    @php
        $meta_title = \App\Category::find($category_id)->meta_title;
        $meta_description = \App\Category::find($category_id)->meta_description;
    @endphp
@elseif (isset($brand_id))
    @php
        $meta_title = \App\Brand::find($brand_id)->meta_title;
        $meta_description = \App\Brand::find($brand_id)->meta_description;
    @endphp
@else
    @php
        $meta_title = env('APP_NAME');
        $meta_description = \App\SeoSetting::first()->description;
    @endphp
@endif

@section('meta_description'){{ $meta_description }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $meta_title }}">
    <meta itemprop="description" content="{{ $meta_description }}">

    <!-- Twitter Card data -->
    <meta name="twitter:title" content="{{ $meta_title }}">
    <meta name="twitter:description" content="{{ $meta_description }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $meta_title }}" />
    <meta property="og:description" content="{{ $meta_description }}" />


@endsection

@section('content')

    <div class="breadcrumb-area">
        <div class="row pt-0 pl-4 pr-4">
            <div class="col">
                <ul class="breadcrumb">
                    <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                    <li><a href="{{ route('products') }}">{{__('All Categories')}}</a></li>
                    @if(isset($category_id))
                        <li class="active"><a href="{{ route('products.category', \App\Category::find($category_id)->slug) }}">{{ \App\Category::find($category_id)->name }}</a></li>
                    @endif
                    @if(isset($subcategory_id))
                        <li ><a href="{{ route('products.category', \App\SubCategory::find($subcategory_id)->category->slug) }}">{{ \App\SubCategory::find($subcategory_id)->category->name }}</a></li>
                        <li class="active"><a href="{{ route('products.subcategory', \App\SubCategory::find($subcategory_id)->slug) }}">{{ \App\SubCategory::find($subcategory_id)->name }}</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    @foreach ($products as $key => $product)
        <input type="hidden" id="prov" value="{{ $product->provinsi }}">
    @endforeach

    <section class="bg-gray py-2">
        <div class="row pl-4 pr-4">
            <div class="col-md-3 d-none d-md-block">
                <div class="bg-white sidebar-box mb-3">
                    <div class="box-title text-center">
                        {{__('Categories')}}
                    </div>
                    <div class="box-content">
                        <div class="category-accordion">
                            @foreach (\App\Category::all() as $key => $category)
                                <div class="single-category">
                                    <button class="btn w-100 category-name collapsed" type="button" data-toggle="collapse" data-target="#category-{{ $key }}" aria-expanded="true">
                                        {{ __($category->name) }}
                                    </button>

                                    <div id="category-{{ $key }}" class="collapse">
                                        @foreach ($category->subcategories as $key2 => $subcategory)
                                            <div class="single-sub-category">
                                                <ul class="sub-sub-category-list">
                                                    <li>
                                                        <a href="{{ route('products.subcategory', $subcategory->slug) }}">
                                                            {{ __($subcategory->name) }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="bg-white sidebar-box mb-3">
                    <div class="box-title text-center">
                        {{__('Price range')}}
                    </div>
                    <div class="box-content">
                        <div class="range-slider-wrapper mt-3">
                            <!-- Range slider container -->
                            <div id="input-slider-range" data-range-value-min="{{ filter_products(\App\Product::all())->min('unit_price') }}" data-range-value-max="{{ filter_products(\App\Product::all())->max('unit_price') }}"></div>
                            <!-- Range slider values -->
                            <div class="row">
                                <div class="col-6">
                                    <span class="range-slider-value value-low"
                                        @if (isset($min_price))
                                            data-range-value-low="{{ $min_price }}"
                                        @elseif($products->min('unit_price') > 0)
                                            data-range-value-low="{{ $products->min('unit_price') }}"
                                        @else
                                            data-range-value-low="0"
                                        @endif
                                          id="input-slider-range-value-low">
                                    </span>
                                </div>

                                <div class="col-6 text-right">
                                    <span class="range-slider-value value-high"
                                        @if (isset($max_price))
                                            data-range-value-high="{{ $max_price }}"
                                        @elseif($products->max('unit_price') > 0)
                                            data-range-value-high="{{ $products->max('unit_price') }}"
                                        @else
                                            data-range-value-high="0"
                                        @endif
                                        id="input-slider-range-value-high">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                    <div class="brands-bar row bg-white py-3">
                        <div class="col-11">
                            <form class="" id="search-form" action="{{ route('search') }}" method="GET">
                            @isset($category_id)
                                <input type="hidden" name="category" value="{{ \App\Category::find($category_id)->slug }}">
                            @endisset
                            @isset($subcategory_id)
                                <input type="hidden" name="subcategory" value="{{ \App\SubCategory::find($subcategory_id)->slug }}">
                            @endisset
                            @isset($subsubcategory_id)
                                <input type="hidden" name="subsubcategory" value="{{ \App\SubSubCategory::find($subsubcategory_id)->slug }}">
                            @endisset
                            

                            <div class="row bg-white pt-0">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>State</label>
                                        <select class="form-control" data-placeholder="{{__('All State')}}" name="location" onchange="filter()">
                                            <option value="" selected disabled>{{__('All State')}}</option>
                                            @foreach (\App\State::all() as $key => $state)
                                                <option value="{{ urlencode($state->name) }}" @isset($states) @if ($states == $state->name) selected @endif @endisset>{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Display</label><br>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" id="grid" class="p-2 btn btn-secondary active" title="Grid View">
                                                <i class="fa fa-th"></i> Grid
                                            </button>
                                            <button type="button" id="list" class="p-2 btn btn-secondary" title="List View">
                                                <i class="fa fa-list"></i> List
                                            </button>
                                            <button type="button" id="list" class="p-2 btn btn-secondary" title="List View">
                                                <i class="fa fa-sort"></i> Sort
                                            </button>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row no-gutters">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>{{__('Sort by')}}</label>
                                                <select class="form-control" data-minimum-results-for-search="Infinity" name="sort_by" onchange="filter()">
                                                    <option value="1" @isset($sort_by) @if ($sort_by == '1') selected @endif @endisset>{{__('Newest')}}</option>
                                                    <option value="2" @isset($sort_by) @if ($sort_by == '2') selected @endif @endisset>{{__('Oldest')}}</option>
                                                    <option value="3" @isset($sort_by) @if ($sort_by == '3') selected @endif @endisset>{{__('Price low to high')}}</option>
                                                    <option value="4" @isset($sort_by) @if ($sort_by == '4') selected @endif @endisset>{{__('Price high to low')}}</option>
                                                    <option value="5" @isset($sort_by) @if ($sort_by == '5') selected @endif @endisset>{{__('Highest Rating')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="min_price" value="">
                            <input type="hidden" name="max_price" value="">
                        </form>
                        </div>
                    </div>
                        

                    <div class="row bg-white mt-2">
                        <div class="col-md-12">
                            @if ($products->total() > 0)
                                <div class="row md-no-gutters gutters-5 p-2">
                                    @foreach ($products as $key => $product)
                                        <div id="product_view" class="col-md-3 col-6">
                                            <div class="product-box-2 bg-white alt-box my-2">
                                                <div class="position-relative overflow-hidden">
                                                    <a href="{{ route('product', $product->slug) }}" class="d-block product-image h-100" style="background-image:url('{{ asset($product->thumbnail_img) }}');" tabindex="0">
                                                    </a>
                                                    <div class="product-btns clearfix">
                                                        <button class="btn add-wishlist" title="Add to Wishlist" onclick="addToWishList({{ $product->id }})" tabindex="0">
                                                            <i class="la la-heart-o"></i>
                                                        </button>
                                                        <button class="btn add-compare" title="Add to Compare" onclick="addToCompare({{ $product->id }})" tabindex="0">
                                                            <i class="la la-refresh"></i>
                                                        </button>
                                                        <button class="btn quick-view" title="Quick view" onclick="showAddToCartModal({{ $product->id }})" tabindex="0">
                                                            <i class="la la-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="p-3 border-top">
                                                    <h2 class="product-title p-0 text-truncate">
                                                        <a href="{{ route('product', $product->slug) }}" tabindex="0">{{ __($product->name) }}</a>

                                                    </h2>
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <div class="star-rating mb-1">
                                                                {{ renderStarRating($product->rating) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix">
                                                        @if (Auth::check())
                                                            <div class="price-box float-left">
                                                                @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                                    <del class="old-product-price strong-400">{{ home_base_price($product->id) }}</del>
                                                                @endif
                                                                <span class="product-price strong-600">{{ home_discounted_base_price($product->id) }}</span>
                                                            </div>
                                                        @else
                                                            <span class="product-price strong-600" title="Please login for show price">Login to show price</span>
                                                        @endif
                                                    </div>
                                                    <p>
                                                        {{ substr($product->alamat, 0, 50) }}
                                                    </p>
                                                </div>
                                            </div>
                                            @if ($product->available === 1)
                                                <div class="ribbon ribbon-top-left">
                                                    <span class="bg-success">Available</span>
                                                </div>
                                            @else
                                                <div class="ribbon ribbon-top-left">
                                                    <span class="bg-danger">Not Available</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="col mt-3 d-flex justify-content-center">
                                    <img src="{{ url('img/not-found.png') }}" alt="">
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row bg-white justify-content-center p-2">
                        <nav aria-label="Center aligned pagination">
                            <ul class="pagination justify-content-center">
                                {{ $products->links() }}
                            </ul>
                        </nav>
                    </div>

                <!-- </div> -->
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script type="text/javascript">
        $('#list').on('click', function() {
            var productList = document.querySelectorAll('#product_view');
            productList.forEach(element => {
                $(element).removeClass('col-md-3');
                $(element).removeClass('col-6');
                $(element).addClass('col-md-12')
                $(element).addClass('col-12')
            });
            $(this).addClass('active');
            $('#grid').removeClass('active');
        });
        $('#grid').on('click', function() {
            var productList = document.querySelectorAll('#product_view');
            productList.forEach(element => {
                $(element).removeClass('col-md-12');
                $(element).removeClass('col-12');
                $(element).addClass('col-md-3')
                $(element).addClass('col-6')
            });
            $(this).addClass('active');
            $('#list').removeClass('active');
        });
        function filter(){
            $('#search-form').submit();
        }
        function rangefilter(arg){
            $('input[name=min_price]').val(arg[0]);
            $('input[name=max_price]').val(arg[1]);
            filter();
        }

        function locations(e){
            $('#location').val(encodeURI(e));
            filter();
        }
    </script>
@endsection
