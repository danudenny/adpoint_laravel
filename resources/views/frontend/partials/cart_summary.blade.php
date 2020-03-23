<div class="card sticky-top">
    <div class="card-title">
        <div class="row align-items-center">
            <div class="col-6">
                <h6 class="heading">
                    <span>{{__('Summary')}}</span>
                </h6>
            </div>

            <div class="col-6 text-right">
                @php
                    $count = 0;
                    foreach (Session::get('cart') as $key => $c) {
                        $count += count($c);
                    }
                @endphp
                <span class="badge badge-md badge-success">{{ $count }} {{__('Items')}}</span>
            </div>
        </div>
    </div>
    @php
        $cart = Session::get('cart');
        $total_kes = [];
    @endphp
    <div class="card-body p-0">
        @foreach ($cart as $seller_id => $c)
            <div class="border-0 p-0">
                @php
                    $user = \App\User::where('id', $seller_id)->first();
                @endphp
                <div data-toggle="collapse" href="#headSeller{{$user->id}}" role="button" aria-expanded="false" aria-controls="headSeller{{$user->id}}" style="height: 40px; background: #FBFBFB; border-bottom: 1px solid #ccc; cursor: pointer;">
                    <b style="line-height: 40px;" class="ml-2">
                        # {{ $user->name }}
                        <span class="pull-right mr-2 text-primary">
                            <i class="fa fa-eye"></i> Detail
                        </span>
                    </b>
                </div>
                <div class="collapse" id="headSeller{{$user->id}}">
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
                                    $tax = 0.1;
                                @endphp
                                @foreach ($c as $key => $cartItem)
                                    @php
                                        $product = \App\Product::find($cartItem['id']);
                                        $subtotal += $cartItem['price']*$cartItem['quantity'];
                                        $product_name_with_choice = $product->name;
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
                                    <th>{{__('Total')}}</th>
                                    <td class="text-right">
                                        <span class="strong-600">{{ single_price($subtotal) }}</span>
                                    </td>
                                </tr>
                                <tr class="cart-subtotal">
                                    <th>{{__('Tax 10%')}}</th>
                                    <td class="text-right">
                                        <span class="strong-600">{{ single_price($subtotal*$tax) }}</span>
                                    </td>
                                </tr>
                                <tr class="cart-subtotal">
                                    <th>{{__('Subtotal')}}</th>
                                    <td class="text-right">
                                        <span class="strong-600">{{ single_price(($subtotal*$tax)+$subtotal) }}</span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            @php
                array_push($total_kes, ($subtotal*$tax)+$subtotal);
            @endphp
        @endforeach
        @php
            $total_keseluruhan = array_sum($total_kes);
        @endphp
        <div class="border-0" style="background: #FBFBFB;">
            <div class="card p-2">
                <table class="table-cart table-cart-review">
                    <tfoot>
                        @php
                            $total = $total_keseluruhan;
                            if(Session::has('coupon_discount')){
                                $total -= Session::get('coupon_discount');
                            }
                            $budget = \Session::get('budget');
                            if (Session::has('budget')) {
                                $budget -= $total;
                            }
                        @endphp
                        <tr>
                            <td align="center">
                                <b>{{__('GRAND TOTAL')}}</b>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <div style="border: 1px dashed; border-radius: 10px; padding:10px; width: 100%; text-align: center; background-color: #f9f9f9">
                                    <h4 class="text-danger strong-700">{{ single_price($total) }}</h4>
                                </div>
                            </td>
                        </tr>
                        @if (Session::has('budget'))
                            <tr>
                                <td align="center">
                                    <b>{{__('YOUR CURRENT BUDGET')}}</b>
                                    @if ($budget < 0)
                                        <span class="badge badge-danger"> Overlimit</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <div style="border: 1px dashed; border-radius: 10px; padding:10px; width: 100%; text-align: center; background-color: #f9f9f9">
                                        <h4 class="text-warning strong-700">{{ single_price($budget) }}</h4>
                                    </div>
                                </td>
                            </tr>
                        @endif
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
