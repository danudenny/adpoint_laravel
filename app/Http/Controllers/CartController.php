<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\SubSubCategory;
use App\Category;
use Session;
use App\Color;

use Auth;

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

    public function form_upload_ads(Request $request)
    {
        $data['seller_id'] = $request->seller_id;
        $data['index'] = $request->index;
        return view('frontend.form_upload_ads_cart', compact('data'));
    }

    public function upload_ads_proses(Request $request)
    {
        if ($request->hasFile('image')) {
            $filegambar = [];
            $arr = [];
            foreach ($request->image as $key => $g) {
                $path = $g->store('uploads/materi_advertising');
                array_push($arr, $path);
                $filegambar['gambar'] = $arr;
            }
        }else {
            $filegambar['gambar'] = null;
        }
        if ($request->hasFile('video')) {
            $filevideo = [];
            $arr = [];
            foreach ($request->video as $key => $v) {
                $path = $v->store('uploads/materi_advertising');
                array_push($arr, $path);
                $filevideo['video'] = $arr;
            }
        }else {
            $filevideo['video'] = null;
        }

        if ($request->input('link')) {
            $filelink = [];
            $arr = [];
            foreach ($request->link as $key => $l) {
                $path = $l;
                array_push($arr, $path);
                $filelink['link'] = $arr;
            }
        }else {
            $filelink['link'] = null;
        }
        $result = array_merge($filegambar, $filevideo, $filelink);
        $advertising = json_encode($result);

        $cart = Session::get('cart');
        foreach ($cart as $seller_id => $c) {
            if ($seller_id === (int)$request->seller_id) {
                foreach ($c as $key => $cartItem) {
                    if ($key === (int)$request->index) {
                        $cartItem['advertising'] = $advertising;
                    }
                    $c[$key] = $cartItem;
                }
                $cart[$seller_id] = $c;
            }
        }
        $request->session()->put('cart', $cart);
        return back();

    }

    public function addToCart(Request $request)
    {
        
        $product = Product::find($request->id);
        $data = array();
        $data['id'] = $product->id;
        $data['user_id'] = $product->user_id;
        $str = '';

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
            if ($product->available === 0) {
                return view('frontend.partials.outOfStockCart');
            }
            // if($variations->$str->qty >= $request['quantity']){

            // }else{
            //     return view('frontend.partials.outOfStockCart');
            // }
        }else{
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
        $data['start_date'] = $request['start_date'];
        $data['end_date'] = $request['end_date'];
        $data['advertising'] = null;

        if (Auth::check()) {
            if ((int)$product->user_id !== (int)Auth::user()->id) {
                if($request->session()->has('cart')){
                    $cart = $request->session()->get('cart');
                    if (isset($cart[$product->user_id])) {
                        $product_same = false;
                        foreach ($cart as $seller_id => $c) {
                            foreach ($c as $key => $cartItem) {
                                if ((int)$cartItem['id'] === (int)$data['id']) {
                                    $product_same = true;
                                }
                                // else {
                                //     $c[$key+1] = $data;
                                // }
                            }
                            // $cart[$product->user_id] = $c;
                        }
                        if ($product_same === true) {
                            return view('frontend.partials.ItemHashCart');
                        }else {
                            $cart[$product->user_id][] = $data;
                        }
                    }else {
                        $cart[$product->user_id][] = $data;
                    }
                    $request->session()->put('cart', $cart);
                } else{
                    $result[$product->user_id] = [$data];
                    $request->session()->put('cart', $result);
                }
                return view('frontend.partials.addedToCart', compact('product', 'data'));
            }else {
                return view('frontend.partials.same_seller');
            }
        }else{
            return view('frontend.partials.cart_login');
        }
    }

    //removes from Cart
    public function removeFromCart(Request $request)
    {
        if($request->session()->has('cart')){
            $cart = $request->session()->get('cart');
            foreach ($cart as $seller_id => $c) {
                if ($seller_id === (int)$request->seller_id) {
                    $file = json_decode($c[$request->key]['advertising']);
                    if ($file !== null) {
                        if ($file->gambar !== null) {
                            foreach ($file->gambar as $key => $g) {
                                if (file_exists($g)) {
                                    unlink($g);
                                }
                            }
                        }
                        if ($file->video !== null) {
                            foreach ($file->video as $key => $v) {
                                if (file_exists($v)) {
                                    unlink($v);
                                }
                            }
                        }
                    }
                    unset($c[$request->key]);
                    $cart[$seller_id] = $c;
                    if (count($cart[$seller_id]) === 0) {
                        unset($cart[$seller_id]);
                        $cart = $cart;
                    }
                }
            }
            $request->session()->put('cart', $cart);
        }
        $cart = $request->session()->get('cart');
        if (count($cart) === 0) {
            $request->session()->forget('cart');
        }

        return view('frontend.partials.cart_details');
    }

    //updated the quantity for a cart item
    public function updateQuantity(Request $request)
    {
        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');
            foreach ($cart as $seller_id => $c) {
                if ($seller_id === (int)$request->seller_id) {
                    foreach ($c as $key => $cartItem) {
                        if ($key === (int)$request->index) {
                            if ($cartItem['Periode'] === 'Harian') {
                                $cartItem['quantity'] = $request->quantity;
                                $cartItem['start_date'] = $request->start_date;
                                $cartItem['end_date'] = date('d M Y', strtotime($request->start_date. ' + '.$request->quantity.' days'));
                            }
                            if ($cartItem['Periode'] === 'Mingguan') {
                                $_qty = (int)$request->quantity * 7;
                                $cartItem['quantity'] = $request->quantity;
                                $cartItem['start_date'] = $request->start_date;
                                $cartItem['end_date'] = date('d M Y', strtotime($request->start_date. ' + '.$_qty.' days'));
                            }
                            if ($cartItem['Periode'] === 'Bulanan') {
                                $cartItem['quantity'] = $request->quantity;
                                $cartItem['start_date'] = $request->start_date;
                                $cartItem['end_date'] = date('d M Y', strtotime($request->start_date. ' + '.$request->quantity.' months'));
                            }
                            if ($cartItem['Periode'] === 'TigaBulan') {
                                $_qty = (int)$request->quantity * 3;
                                $cartItem['quantity'] = $request->quantity;
                                $cartItem['start_date'] = $request->start_date;
                                $cartItem['end_date'] = date('d M Y', strtotime($request->start_date. ' + '.(string)$_qty.' months'));
                            }
                            if ($cartItem['Periode'] === 'EnamBulan') {
                                $_qty = (int)$request->quantity * 6;
                                $cartItem['quantity'] = $request->quantity;
                                $cartItem['start_date'] = $request->start_date;
                                $cartItem['end_date'] = date('d M Y', strtotime($request->start_date. ' + '.(string)$_qty.' months'));
                            }
                            if ($cartItem['Periode'] === 'Tahunan') {
                                $_qty = (int)$request->quantity * 12;
                                $cartItem['quantity'] = $request->quantity;
                                $cartItem['start_date'] = $request->start_date;
                                $cartItem['end_date'] = date('d M Y', strtotime($request->start_date. ' + '.(string)$_qty.' months'));
                            }
                            $c[$key] = $cartItem;
                        }
                    }
                    $cart[$seller_id] = $c;
                }
            }
        }

        $request->session()->put('cart', $cart);
        return view('frontend.partials.cart_details');
    }

    public function adjust_budget(Request $request) {
        $this->validate($request,[
            'budget' => 'required|numeric'
        ]);
        $request->session()->put('budget', $request->input('budget'));
        return redirect()->back()->with('table_id',$request->input('budget'));
    }
}
