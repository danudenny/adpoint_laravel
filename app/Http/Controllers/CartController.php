<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\SubSubCategory;
use App\Category;
use Session;
use App\Color;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $cart = $request->session()->get('cart');
        return view('frontend.view_cart', compact('categories', 'cart'));
    }

    public function showCartModal(Request $request)
    {
        $product = Product::find($request->id);
        return view('frontend.partials.addToCart', compact('product'));
    }

    public function updateNavCart(Request $request)
    {
        return view('frontend.partials.cart');
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);
        $data = array();
        $data['id'] = $product->id;
        $data['user_id'] = $product->user_id;
        $str = '';
        $tax = 0;

        //check the color enabled or disabled for the product
        if($request->has('color')){
            $data['color'] = $request['color'];
            $str = Color::where('code', $request['color'])->first()->name;
        }

        //Gets all the choice values of customer choice option and generate a string like Black-S-Cotton
        foreach (json_decode(Product::find($request->id)->choice_options) as $key => $choice) {
            $data[$choice->title] = $request[$choice->title];
            if($str != null){
                $str .= $request[$choice->title];
            }
            else{
                $str .= $request[$choice->title];
            }
        }

        //Check the string and decreases quantity for the stock
        if($str != null){
            $variations = json_decode($product->variations);
            $price = $variations->$str->price;
            if($variations->$str->qty >= $request['quantity']){
                // $variations->$str->qty -= $request['quantity'];
                // $product->variations = json_encode($variations);
                // $product->save();
            }
            else{
                return view('frontend.partials.outOfStockCart');
            }
        }
        else{
            $price = $product->unit_price;
        }

        //discount calculation based on flash deal and regular discount
        //calculation of taxes
        $flash_deal = \App\FlashDeal::where('status', 1)->first();
        if ($flash_deal != null && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
            $flash_deal_product = \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first();
            if($flash_deal_product->discount_type == 'percent'){
                $price -= ($price*$flash_deal_product->discount)/100;
            }
            elseif($flash_deal_product->discount_type == 'amount'){
                $price -= $flash_deal_product->discount;
            }
        }
        else{
            if($product->discount_type == 'percent'){
                $price -= ($price*$product->discount)/100;
            }
            elseif($product->discount_type == 'amount'){
                $price -= $product->discount;
            }
        }

        if($product->tax_type == 'percent'){
            $price += ($price*$product->tax)/100;
        }
        elseif($product->tax_type == 'amount'){
            $price += $product->tax;
        }

        $data['quantity'] = $request['quantity'];
        $data['price'] = $price;
        $data['tax'] = $tax;
        $data['shipping_type'] = $product->shipping_type;
        $data['start_date'] = $request['start_date'];
        $data['end_date'] = $request['end_date'];

        if($product->shipping_type == 'free'){
            $data['shipping'] = 0;
        }
        else{
            $data['shipping'] = $product->shipping_cost;
        }

        if($request->session()->has('cart')){
            $cart = $request->session()->get('cart', collect([]));
            $cart->push($data);
        }
        else{
            $cart = collect([$data]);
            $request->session()->put('cart', $cart);
        }
        return view('frontend.partials.addedToCart', compact('product', 'data'));
    }

    //removes from Cart
    public function removeFromCart(Request $request)
    {
        if($request->session()->has('cart')){
            $cart = $request->session()->get('cart', collect([]));
            $cart->forget($request->key);
            $request->session()->put('cart', $cart);
        }

        return view('frontend.partials.cart_details');;
    }

    //updated the quantity for a cart item
    public function updateQuantity(Request $request)
    {   
        $cart = $request->session()->get('cart', collect([]));
        // dd($cart);
        $cart = $cart->map(function ($object, $key) use ($request) {
            if((string)$object['id'] === $request->key){   
                if ($object['Periode'] === 'Harian') {
                    $object['quantity'] = $request->quantity;
                    $object['start_date'] = $request->start_date;
                    $object['end_date'] = date('d M Y', strtotime($request->start_date. ' + '.$request->quantity.' days'));
                }
                if ($object['Periode'] === 'Mingguan') {
                    $_qty = (int)$request->quantity * 7;
                    $object['quantity'] = $request->quantity;
                    $object['start_date'] = $request->start_date;
                    $object['end_date'] = date('d M Y', strtotime($request->start_date. ' + '.$_qty.' days'));
                }
                if ($object['Periode'] === 'Bulanan') {
                    $object['quantity'] = $request->quantity;
                    $object['start_date'] = $request->start_date;
                    $object['end_date'] = date('d M Y', strtotime($request->start_date. ' + '.$request->quantity.' months'));
                }
                if ($object['Periode'] === 'TigaBulan') {
                    $_qty = (int)$request->quantity * 3;
                    $object['quantity'] = $request->quantity;
                    $object['start_date'] = $request->start_date;
                    $object['end_date'] = date('d M Y', strtotime($request->start_date. ' + '.(string)$_qty.' months'));
                }
                if ($object['Periode'] === 'EnamBulan') {
                    $_qty = (int)$request->quantity * 6;
                    $object['quantity'] = $request->quantity;
                    $object['start_date'] = $request->start_date;
                    $object['end_date'] = date('d M Y', strtotime($request->start_date. ' + '.(string)$_qty.' months'));
                }
                if ($object['Periode'] === 'Tahunan') {
                    $_qty = (int)$request->quantity * 12;
                    $object['quantity'] = $request->quantity;
                    $object['start_date'] = $request->start_date;
                    $object['end_date'] = date('d M Y', strtotime($request->start_date. ' + '.(string)$_qty.' months'));
                }
            }
            return $object;
        });
        $request->session()->put('cart', $cart);
        return view('frontend.partials.cart_details');
    }
}
