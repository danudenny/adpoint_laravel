<a href="" class="nav-box-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="la la-shopping-cart d-inline-block nav-box-icon"></i>
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
<ul class="dropdown-menu dropdown-menu-right px-0">
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
                                                <img src="{{ asset($product->thumbnail_img) }}" class="img-fluid" alt="">
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
                                            <button onclick="removeFromCart({{ $seller_id }}, {{ $key }})">
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
