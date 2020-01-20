<div class="container">
    @php
        $cart = [];
        $data = [];
        foreach (Session::get('cart') as $sc) {
            array_push($cart, $sc);
        }
        foreach ($cart as $c) {
            $data[$c['user_id']][] = $c;
        }
    @endphp
    <div class="row cols-xs-space cols-sm-space cols-md-space">
        <div class="col-xl-8">
            @foreach ($data as $seller => $d)
                <div class="card">
                    @php
                        $user = \App\User::where('id', $seller)->first();
                    @endphp
                    <div style="height: 50px; background: #0f355a; color: white; border-bottom: 2px solid #fd7e14">
                        <div style="line-height: 45px; margin-left: 30px;">
                            <img class="img-fluid rounded-circle mr-2" width="30" src="{{ url($user->avatar_original) }}" alt="">
                            {{ $user->name }}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-default bg-white p-4">
                            <div class="">
                                <div class="">
                                    <table class="table-cart border-bottom">
                                        <thead>
                                            <tr>
                                                <th class="product-image"></th>
                                                <th class="product-name">{{__('Product')}}</th>
                                                <th class="product-price d-none d-lg-table-cell">{{__('Price')}}</th>
                                                <th class="product-quanity d-none d-md-table-cell">{{__('Quantity')}}</th>
                                                <th class="product-total">{{__('Total')}}</th>
                                                <th class="product-remove"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $total = 0;
                                            @endphp
                                            @foreach ($d as $key => $cartItem)
                                                @php
                                                $product = \App\Product::find($cartItem['id']);
                                                $total = $total + $cartItem['price']*$cartItem['quantity'];
                                                $product_name_with_choice = $product->name;
                                                // dd($cartItem);
                                                if(isset($cartItem['color'])){
                                                    $product_name_with_choice .= ' - '.\App\Color::where('code', $cartItem['color'])->first()->name;
                                                }
                                                foreach (json_decode($product->choice_options) as $choice){
                                                    $str = $choice->title; // example $str =  choice_0
                                                    $product_name_with_choice .= ' - '.$cartItem[$str];
                                                }
                                                @endphp
                                                <tr class="cart-item">
                                                    <td class="product-image">
                                                        <a href="#" class="mr-3">
                                                            <img class="img-fluid" src="{{ asset($product->thumbnail_img) }}">
                                                        </a>
                                                    </td>
                                                    
                                                    <td class="product-name">
                                                        <span class="pr-4 d-block">{{ $product_name_with_choice }}</span>
                                
                                                        @php
                                                            if ($cartItem['Periode'] === 'Harian') {
                                                                $end_date = date('d M Y', strtotime($cartItem['start_date']. ' + '.$cartItem['quantity'].' days'));
                                                                echo '<span class="badge badge-warning">'.$cartItem['start_date'].'</span>';
                                                                echo ' s/d ';
                                                                echo '<span id="e" class="badge badge-warning">'.$end_date.'</span>';
                                                            }
                                                            if ($cartItem['Periode'] === 'Mingguan') {
                                                                $_qty = (int)$cartItem['quantity'] * 7;
                                                                $end_date = date('d M Y', strtotime($cartItem['start_date']. ' + '.$_qty.' days'));
                                                                echo '<span class="badge badge-warning">'.$cartItem['start_date'].'</span>';
                                                                echo ' s/d ';
                                                                echo '<span id="e" class="badge badge-warning">'.$end_date.'</span>';
                                                            }
                                                            if ($cartItem['Periode'] === 'Bulanan') {
                                                                $end_date = date('d M Y', strtotime($cartItem['start_date']. ' + '.$cartItem['quantity'].' months'));
                                                                echo '<span class="badge badge-warning">'.$cartItem['start_date'].'</span>';
                                                                echo ' s/d ';
                                                                echo '<span id="e" class="badge badge-warning">'.$end_date.'</span>';
                                                            }
                                                            if ($cartItem['Periode'] === 'TigaBulan') {
                                                                $_qty = (int)$cartItem['quantity'] * 3;
                                                                $end_date = date('d M Y', strtotime($cartItem['start_date']. ' + '.(string)$_qty.' months'));
                                                                echo '<span class="badge badge-warning">'.$cartItem['start_date'].'</span>';
                                                                echo ' s/d ';
                                                                echo '<span id="e" class="badge badge-warning">'.$end_date.'</span>';
                                                            }
                                                            if ($cartItem['Periode'] === 'EnamBulan') {
                                                                $_qty = (int)$cartItem['quantity'] * 6;
                                                                $end_date = date('d M Y', strtotime($cartItem['start_date']. ' + '.(string)$_qty.' months'));
                                                                echo '<span class="badge badge-warning">'.$cartItem['start_date'].'</span>';
                                                                echo ' s/d ';
                                                                echo '<span id="e" class="badge badge-warning">'.$end_date.'</span>';
                                                            }
                                                            if ($cartItem['Periode'] === 'Tahunan') {
                                                                $_qty = (int)$cartItem['quantity'] * 12;
                                                                $end_date = date('d M Y', strtotime($cartItem['start_date']. ' + '.(string)$_qty.' months'));
                                                                echo '<span class="badge badge-warning">'.$cartItem['start_date'].'</span>';
                                                                echo ' s/d ';
                                                                echo '<span id="e" class="badge badge-warning">'.$end_date.'</span>';
                                                            }

                                                        @endphp
                                                        <b hidden id="start_{{ $cartItem['Periode'] }}" class="text-sm text-info">{{ $cartItem['start_date'] }}</b>
                                                    </td>
                                                    
                                                    <td class="product-price d-none d-lg-table-cell">
                                                        <span class="pr-3 d-block">{{ single_price($cartItem['price']) }}</span>
                                                    </td>

                                                    <td class="product-quantity d-none d-md-table-cell">
                                                        <div class="input-group input-group--style-2 pr-4" style="width: 130px;">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-number" id="minus_{{ $cartItem['Periode'] }}" type="button" data-type="minus" data-field="quantity[{{ $cartItem['id'] }}]">
                                                                    <i class="la la-minus"></i>
                                                                </button>
                                                            </span>
                                                            <input type="text" name="quantity[{{ $cartItem['id'] }}]" id="qty_{{ $cartItem['Periode'] }}" class="form-control input-number" placeholder="1" value="{{ $cartItem['quantity'] }}" min="1" max="10" onchange="updateQuantity( {{ $cartItem['id'] }}, this, $('#start_{{$cartItem['Periode']}}').text(), $('#e').text())">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-number" id="plus_{{ $cartItem['Periode'] }}" type="button" data-type="plus" data-field="quantity[{{ $cartItem['id'] }}]">
                                                                    <i class="la la-plus"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td class="product-total">
                                                        <span>{{ single_price($cartItem['price']*$cartItem['quantity']) }}</span>
                                                    </td>
                                                    <td class="product-remove">
                                                        <a href="#" onclick="removeFromCartView(event, {{ $cartItem['id'] }})" class="text-right pl-4">
                                                            <i class="la la-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="row align-items-center pt-4">
                <div class="col-6">
                    <a href="{{ route('home') }}" class="link link--style-3">
                        <i class="la la-mail-reply"></i>
                        {{__('Return to shop')}}
                    </a>
                </div>
                <div class="col-6 text-right">
                    @if(Auth::check())
                        <a href="{{ route('checkout.shipping_info') }}" class="btn btn-styled btn-base-1">{{__('Continue to Billing Details')}}</a>
                    @else
                        <button class="btn btn-styled btn-base-1" onclick="showCheckoutModal()">{{__('Continue to Billing Details')}}</button>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-4 ml-lg-auto">
            @include('frontend.partials.cart_summary')
        </div>
    </div>
</div>

<script type="text/javascript">
    cartQuantityInitialize();
</script>
