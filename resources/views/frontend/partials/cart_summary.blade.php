<div class="card sticky-top">
    <div class="card-title">
        <div class="row align-items-center">
            <div class="col-6">
                <h4 class="heading heading-4 strong-300 mb-0">
                    <span>{{__('Summary')}}</span>
                </h4>
            </div>

            <div class="col-6 text-right">
                <span class="badge badge-md badge-success">{{ count(Session::get('cart')) }} {{__('Items')}}</span>
            </div>
        </div>
    </div>
    @php
        $cart = [];
        $data = [];
        foreach (Session::get('cart') as $sc) {
            array_push($cart, $sc);
        }
        foreach ($cart as $c) {
            $data[$c['user_id']][] = $c;
        }
        $total_kes = [];
    @endphp
    <div class="card-body">
        @foreach ($data as $seller => $d)
            <div class="border-0">
                @php
                    $user = \App\User::where('id', $seller)->first();
                @endphp
                <div style="height: 40px; background: #0f355a; color: white; border-bottom: 2px solid #fd7e14">
                    <p style="line-height: 40px; margin-left: 10px">{{ $user->name }}</p>
                </div>
                <div class="card-body">
                    <table class="table-cart table-cart-review">
                        <thead>
                            <tr>
                                <th class="product-name">{{__('Product')}}</th>
                                <th class="product-total text-right">{{__('Total')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $subtotal = 0;
                                $tax = 0;
                                $shipping = 0;
                            @endphp
                            @foreach ($d as $key => $cartItem)
                                @php
                                    $product = \App\Product::find($cartItem['id']);
                                    $subtotal += $cartItem['price']*$cartItem['quantity'];
                                    $tax += $cartItem['tax']*$cartItem['quantity'];
                                    $shipping += $cartItem['shipping']*$cartItem['quantity'];
                                    $product_name_with_choice = $product->name;
                                    if(isset($cartItem['color'])){
                                        $product_name_with_choice .= ' - '.\App\Color::where('code', $cartItem['color'])->first()->name;
                                    }
                                    foreach (json_decode($product->choice_options) as $choice){
                                        $str = $choice->title;
                                        $product_name_with_choice .= ' - '.$cartItem[$str];
                                    }
                                @endphp
                                <tr class="cart_item">
                                    <td class="product-name">
                                        {{ $product_name_with_choice }}
                                        <strong class="product-quantity">× {{ $cartItem['quantity'] }}</strong>
                                    </td>
                                    <td class="product-total text-right">
                                        <span class="pl-4">{{ single_price($cartItem['price']*$cartItem['quantity']) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <hr>
                    <table class="table-cart table-cart-review">
                        <tfoot>
                            <tr class="cart-subtotal">
                                <th>{{__('Subtotal')}}</th>
                                <td class="text-right">
                                    <span class="strong-600">{{ single_price($subtotal) }}</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            @php
                array_push($total_kes, $subtotal);
               
                @endphp
        @endforeach
        @php
            $total_keseluruhan = array_sum($total_kes);
        @endphp
        <div class="border-0" style="background: #F79F1F;">
            <div class="card-body">
                <table class="table-cart table-cart-review">
                    <tfoot>
                        @php
                            $pajak = $total_keseluruhan*0.01;
                        @endphp
                        <tr class="cart-shipping">
                            <th class="text-white">{{__('Tax 10%')}}</th>
                            <td class="text-right">
                                <span class="text-italic text-white">{{ single_price($pajak) }}</span>
                            </td>
                        </tr>
                        @php
                            $total = $total_keseluruhan+$pajak;
                            if(Session::has('coupon_discount')){
                                $total -= Session::get('coupon_discount');
                            }
                        @endphp
                        <tr class="cart-total">
                            <th class="text-white"><span class="strong-700">{{__('Grand Total')}}</span></th>
                            <td class="text-right text-white">
                                <strong><span>{{ single_price($total) }}</span></strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        

        @if (Auth::check() && \App\BusinessSetting::where('type', 'coupon_system')->first()->value == 1)
            @if (Session::has('coupon_discount'))
                <div class="mt-3">
                    <form class="form-inline" action="{{ route('checkout.remove_coupon_code') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group flex-grow-1">
                            <div class="form-control bg-gray w-100">{{ \App\Coupon::find(Session::get('coupon_id'))->code }}</div>
                        </div>
                        <button type="submit" class="btn btn-base-1">{{__('Change Coupon')}}</button>
                    </form>
                </div>
            @else
                <div class="mt-3">
                    <form class="form-inline" action="{{ route('checkout.apply_coupon_code') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group flex-grow-1">
                            <input type="text" class="form-control w-100" name="code" placeholder="Have coupon code? Enter here" required>
                        </div>
                        <button type="submit" class="btn btn-base-1">{{__('Apply')}}</button>
                    </form>
                </div>
            @endif
        @endif

    </div>
</div>
