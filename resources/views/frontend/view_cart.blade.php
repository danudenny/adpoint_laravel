@extends('frontend.layouts.app')
@section('content')
    <section class="slice-xs sct-color-2 border-bottom">
        <div class="container container-sm">
            <div class="row cols-delimited">
                <div class="col-4">
                    <div class="icon-block icon-block--style-1-v5 text-center">
                        <div class="block-icon mb-0">
                            <i class="la la-shopping-cart" style="color: #ff9400"></i>
                        </div>
                        <div class="block-content d-none d-md-block">
                            <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">1. {{__('My Cart')}}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="icon-block icon-block--style-1-v5 text-center">
                        <div class="block-icon c-gray-light mb-0">
                            <i class="la la-truck"></i>
                        </div>
                        <div class="block-content d-none d-md-block">
                            <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">2. {{__('Shipping info')}}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="icon-block icon-block--style-1-v5 text-center">
                        <div class="block-icon c-gray-light mb-0">
                            <i class="la la-credit-card"></i>
                        </div>
                        <div class="block-content d-none d-md-block">
                            <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">4. {{__('Payment')}}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="py-4 gry-bg" id="cart-summary">
        @if(Session::has('cart'))
            @php
                $cart = Session::get('cart');
            @endphp
            <div class="row px-5">
                <div class="col-md-9">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table">
                                @foreach ($cart as $seller_id => $c)
                                    @php
                                        $user = \App\User::where('id', $seller_id)->first();
                                    @endphp
                                    <tr>
                                        <th colspan="7" style="background: #fafafa">
                                            <img class="img-fluid rounded-circle mr-2" width="25" src="{{ url($user->avatar_original) }}" alt="">
                                            {{ $user->name }}
                                        </th>
                                    </tr>
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach ($c as $key => $cartItem)
                                        @php
                                            $product = \App\Product::find($cartItem['id']);
                                            $total += $cartItem['price']*$cartItem['quantity'];
                                            $product_name_with_choice = $product->name;
                                        
                                            foreach (json_decode($product->choice_options) as $choice){
                                                $str = $choice->title;
                                                $product_name_with_choice .= ' - '.$cartItem[$str];
                                            }
                                        @endphp
                                        <tr>
                                            <td>
                                                <img class="img-fluid mr-2" width="150" src="{{ asset($product->thumbnail_img) }}">
                                            </td>
                                            <td>
                                                <small>Name:</small><br>
                                                <strong>
                                                    <a href="{{ route('product', $product->slug) }}">
                                                        {{ $product_name_with_choice }}
                                                    </a>    
                                                </strong><br>
                                                @php
                                                    if ($cartItem['Periode'] === 'Harian') {
                                                        $end_date = date('d M Y', strtotime($cartItem['start_date']. ' + '.$cartItem['quantity'].' days'));
                                                        echo '<span class="badge badge-primary">'.$cartItem['start_date'].'</span>';
                                                        echo ' <small style="color:black">s/d</small> ';
                                                        echo '<span id="e" class="badge badge-primary">'.$end_date.'</span>';
                                                    }
                                                    if ($cartItem['Periode'] === 'Mingguan') {
                                                        $_qty = (int)$cartItem['quantity'] * 7;
                                                        $end_date = date('d M Y', strtotime($cartItem['start_date']. ' + '.$_qty.' days'));
                                                        echo '<span class="badge badge-primary">'.$cartItem['start_date'].'</span>';
                                                        echo ' <small style="color:black">s/d</small> ';
                                                        echo '<span id="e" class="badge badge-primary">'.$end_date.'</span>';
                                                    }
                                                    if ($cartItem['Periode'] === 'Bulanan') {
                                                        $end_date = date('d M Y', strtotime($cartItem['start_date']. ' + '.$cartItem['quantity'].' months'));
                                                        echo '<span class="badge badge-primary">'.$cartItem['start_date'].'</span>';
                                                        echo ' <small style="color:black">s/d</small> ';
                                                        echo '<span id="e" class="badge badge-primary">'.$end_date.'</span>';
                                                    }
                                                    if ($cartItem['Periode'] === 'TigaBulan') {
                                                        $_qty = (int)$cartItem['quantity'] * 3;
                                                        $end_date = date('d M Y', strtotime($cartItem['start_date']. ' + '.(string)$_qty.' months'));
                                                        echo '<span class="badge badge-primary">'.$cartItem['start_date'].'</span>';
                                                        echo ' <small style="color:black">s/d</small> ';
                                                        echo '<span id="e" class="badge badge-primary">'.$end_date.'</span>';
                                                    }
                                                    if ($cartItem['Periode'] === 'EnamBulan') {
                                                        $_qty = (int)$cartItem['quantity'] * 6;
                                                        $end_date = date('d M Y', strtotime($cartItem['start_date']. ' + '.(string)$_qty.' months'));
                                                        echo '<span class="badge badge-primary">'.$cartItem['start_date'].'</span>';
                                                        echo ' <small style="color:black">s/d</small> ';
                                                        echo '<span id="e" class="badge badge-primary">'.$end_date.'</span>';
                                                    }
                                                    if ($cartItem['Periode'] === 'Tahunan') {
                                                        $_qty = (int)$cartItem['quantity'] * 12;
                                                        $end_date = date('d M Y', strtotime($cartItem['start_date']. ' + '.(string)$_qty.' months'));
                                                        echo '<span class="badge badge-primary">'.$cartItem['start_date'].'</span>';
                                                        echo ' <small style="color:black">s/d</small> ';
                                                        echo '<span id="e" class="badge badge-primary">'.$end_date.'</span>';
                                                    }

                                                @endphp
                                                <b hidden id="start_{{ $cartItem['Periode'] }}" class="text-sm text-info">{{ $cartItem['start_date'] }}</b>
                                            </td>
                                            <td>
                                                <small>Price:</small><br>
                                                <strong>{{ single_price($cartItem['price']) }}</strong>
                                            </td>
                                            <td>
                                                <div class="input-group input-group--style-2 pr-4" style="width: 130px;">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-number" id="minus_{{ $cartItem['Periode'] }}" type="button" data-type="minus" data-field="quantity[{{ $cartItem['id'] }}]">
                                                            <i class="la la-minus"></i>
                                                        </button>
                                                    </span>
                                                    <input type="text" name="quantity[{{ $cartItem['id'] }}]" id="qty_{{ $cartItem['Periode'] }}" class="form-control input-number" placeholder="1" value="{{ $cartItem['quantity'] }}" min="1" max="10" onchange="updateQuantity(this.value, {{ $seller_id }}, {{ $key }}, $('#start_{{$cartItem['Periode']}}').text())">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-number" id="plus_{{ $cartItem['Periode'] }}" type="button" data-type="plus" data-field="quantity[{{ $cartItem['id'] }}]">
                                                            <i class="la la-plus"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <small>Total:</small><br>
                                                <strong>{{ single_price($cartItem['price']*$cartItem['quantity']) }}</strong>
                                            </td>
                                            <td>
                                                @if ($cartItem['advertising'] !== null)
                                                    <button class="btn btn-outline-success btn-circle btn-sm" disabled style="cursor: not-allowed">
                                                        <i class="fa fa-check"></i> Uploaded
                                                    </button>
                                                @else 
                                                    <button onclick="uploadAds({{$seller_id}}, {{$key}})" class="btn btn-outline-primary btn-circle btn-sm">
                                                        <i class="fa fa-upload"></i> Upload
                                                    </button>
                                                @endif
                                            </td>
                                            <td>
                                                <button onclick="confirm_delete(event, {{ $seller_id }}, {{ $key }})" class="text-right btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="row align-items-center mt-3 mb-3">
                        <div class="col-6">
                            <a href="{{ route('home') }}" class="btn btn-danger btn-circle">
                                <i class="la la-mail-reply"></i>
                                {{__('Return to shop')}}
                            </a>
                        </div>
                        <div class="col-6 text-right">
                            @if(Auth::check())
                                @php
                                    $advertising = [];
                                    $count = 0;
                                    foreach (Session::get('cart') as $seller_id => $c) {
                                        $count += count($c);
                                        foreach ($c as $key => $cartItem) {
                                            if ($cartItem['advertising'] !== null) {
                                                array_push($advertising, $cartItem['advertising']);
                                            }
                                        }
                                    }
                                @endphp
                                @if (count($advertising) === $count)
                                    <a href="{{ route('checkout.shipping_info') }}" class="btn btn-orange btn-circle">
                                        <i class="fa fa-shopping-bag"></i> {{__('Continue to Billing Details')}}
                                    </a>
                                @else 
                                    <button class="btn btn-orange btn-circle" onclick="showFrontendAlert('info', 'You have not uploaded the material')">
                                        <i class="fa fa-shopping-bag"></i> {{__('Continue to Billing Details')}}
                                    </button>
                                @endif
                            @else
                                <button class="btn btn-orange btn-circle" onclick="showCheckoutModal()">
                                    <i class="fa fa-shopping-bag"></i> {{__('Continue to Billing Details')}}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    @include('frontend.partials.cart_summary')
                </div>
            </div>
        @else
            <div class="dc-header text-center p-5">
                <h3 class="heading heading-6 strong-700">{{__('Your Cart is empty')}}</h3>
                <div class="col mt-3 d-flex justify-content-center">
                    <img src="{{ url('img/not-found.png') }}" alt="">
                </div>
            </div>
        @endif
    </section>

    <!-- Modal -->
    <div class="modal fade" id="GuestCheckout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">{{__('Login')}}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="card">
                                <div class="card-body px-4">
                                    <form class="form-default" role="form" action="{{ route('cart.login.submit') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="input-group input-group--style-1">
                                                        <input type="email" name="email" class="form-control" placeholder="{{__('Email')}}">
                                                        <span class="input-group-addon">
                                                            <i class="text-md ion-person"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <div class="input-group input-group--style-1">
                                                        <input type="password" name="password" class="form-control" placeholder="{{__('Password')}}">
                                                        <span class="input-group-addon">
                                                            <i class="text-md ion-locked"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <a href="#" class="link link-xs link--style-3">{{__('Forgot password?')}}</a>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button type="submit" class="btn btn-styled btn-base-1 px-4">{{__('Sign in')}}</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body px-4">
                                    @if(\App\BusinessSetting::where('type', 'google_login')->first()->value == 1)
                                        <a href="{{ route('social.login', ['provider' => 'google']) }}" class="btn btn-styled btn-block btn-google btn-icon--2 btn-icon-left px-4 my-4">
                                            <i class="icon fa fa-google"></i> {{__('Login with Google')}}
                                        </a>
                                    @endif
                                    @if (\App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1)
                                        <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="btn btn-styled btn-block btn-facebook btn-icon--2 btn-icon-left px-4 my-4">
                                            <i class="icon fa fa-facebook"></i> {{__('Login with Facebook')}}
                                        </a>
                                    @endif
                                    @if (\App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                                    <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="btn btn-styled btn-block btn-twitter btn-icon--2 btn-icon-left px-4 my-4">
                                        <i class="icon fa fa-twitter"></i> {{__('Login with Twitter')}}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="or or--1 mt-2">
                        <span>{{__('or')}}</span>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('checkout.shipping_info') }}" class="btn btn-styled btn-base-1">{{__('Guest Checkout')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uploadAds" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="width: 70%" role="document">
            <div class="modal-content position-relative">
                <div class="c-preloader">
                    <i class="fa fa-spin fa-spinner"></i>
                </div>
                <div id="uploadAdsbody">

                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">

        function uploadAds(seller_id, index) {
            $('#uploadAdsbody').html(null);
            $('#uploadAds').modal();
            $('.c-preloader').show();
            $.post('{{ route('form.upload.ads') }}', {_token:'{{ csrf_token() }}', seller_id:seller_id,index:index}, function(data){
                $('.c-preloader').hide();
                $('#uploadAdsbody').html(data);
            });
        }

        function updateQuantity(qty, seller_id, index, start_date){
            $.post('{{ route('cart.updateQuantity') }}', { 
                _token:'{{ csrf_token() }}', 
                seller_id:seller_id,
                index:index, 
                quantity: qty,
                start_date : start_date
            },function(data){
                updateNavCart();
                $('#cart-summary').html(data);
            });
        }
        
        function showCheckoutModal(){
            $('#GuestCheckout').modal();
        }

        function confirm_delete(e, seller_id, index) {
            if (confirm('Are you sure delete?')) {
                removeFromCart(seller_id, index);
                location.reload();
            }
        }

    </script>
@endsection


