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
                                    </a>
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

<script type="text/javascript">
    cartQuantityInitialize();
</script>
