<?php

namespace App\Http\Controllers;

use App\Bundle;
use App\Pushy;
use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Language;
use Auth;
use App\SubSubCategory;
use Ixudra\Curl\Facades\Curl;
use Session;
use ImageOptimizer;

use DB;
use GuzzleHttp\Client;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_products()
    {
        $type = 'In House';
        $products = Product::where('added_by', 'admin')->orderBy('created_at', 'desc')->get();
        return view('products.index', compact('products','type'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function seller_products()
    {
        $type = 'Seller';
        $products = Product::where('added_by', 'seller')->orderBy('created_at', 'desc')->get();
        return view('products.index', compact('products','type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'description' => 'required',
            'photos' => 'required',
            // 'thumbnail_img' => 'required',
            // 'featured_img' => 'required',
            // 'flash_deal_img' => 'required',
            // 'meta_title' => 'required',
            // 'meta_description' => 'required',
            // 'meta_img' => 'required',
            'unit_price' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            // 'audien_target' => 'required',
            // 'statistik_masyarakat' => 'required',
            // 'jumlah_pendengarradio' => 'required',
            // 'target_pendengarradio' => 'required',
            'periode' => 'required'
        ]);
        $product = new Product;
        $product->name = $request->name;
        $product->added_by = $request->added_by;
        $product->user_id = Auth::user()->id;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->subsubcategory_id = $request->subsubcategory_id;
        $product->brand_id = $request->brand_id;

        $photos = array();

        if($request->hasFile('photos')){
            foreach ($request->photos as $key => $photo) {
                $path = $photo->store('uploads/products/photos');
                array_push($photos, $path);
                //ImageOptimizer::optimize(base_path('public/').$path);
            }
            $product->photos = json_encode($photos);
        }

        if($request->hasFile('thumbnail_img')){
            $product->thumbnail_img = $request->thumbnail_img->store('uploads/products/thumbnail');
            //ImageOptimizer::optimize(base_path('public/').$product->thumbnail_img);
        }

        if($request->hasFile('featured_img')){
            $product->featured_img = $request->featured_img->store('uploads/products/featured');
            //ImageOptimizer::optimize(base_path('public/').$product->featured_img);
        }

        if($request->hasFile('flash_deal_img')){
            $product->flash_deal_img = $request->flash_deal_img->store('uploads/products/flash_deal');
            //ImageOptimizer::optimize(base_path('public/').$product->flash_deal_img);
        }

        // $product->unit = $request->unit;
        $product->tags = implode('|',$request->tags);
        $product->description = $request->description;
        $product->termin_pembayaran = $request->termin_pembayaran;
        $product->video_provider = $request->video_provider;
        $product->video_link = $request->video_link;
        $product->unit_price = $request->unit_price;
        $product->purchase_price = $request->purchase_price;
        $product->tax = $request->tax;
        $product->tax_type = $request->tax_type;
        $product->discount = $request->discount;
        $product->discount_type = $request->discount_type;
        $product->shipping_type = $request->shipping_type;
        if($request->shipping_type == 'free'){
            $product->shipping_cost = 0;
        }
        elseif ($request->shipping_type == 'local_pickup') {
            $product->shipping_cost = $request->local_pickup_shipping_cost;
        }
        elseif ($request->shipping_type == 'flat_rate') {
            $product->shipping_cost = $request->flat_shipping_cost;
        }
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;

        if($request->hasFile('meta_img')){
            $product->meta_img = $request->meta_img->store('uploads/products/meta');
            //ImageOptimizer::optimize(base_path('public/').$product->meta_img);
        }

        if($request->hasFile('pdf')){
            $product->pdf = $request->pdf->store('uploads/products/pdf');
        }

        $product->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.str_random(5);

        $product->latlong = $request->latlong;
        $product->alamat = $request->alamat;
        $product->provinsi = $request->provinsi;
        $product->kota = $request->kota;
        $product->kecamatan = $request->kecamatan;

        $product->audien_target = $request->audien_target;
        $product->statistik_masyarakat = $request->statistik_masyarakat;
        $product->jumlah_pendengarradio = $request->jumlah_pendengarradio;
        $product->target_pendengarradio = $request->target_pendengarradio;

        // if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
        //     $product->colors = json_encode($request->colors);
        // }
        // else {
        //     $colors = array();
        //     $product->colors = json_encode($colors);
        // }

        // $choice_options = array();

        // if($request->has('choice')){
        //     foreach ($request->choice_no as $key => $no) {
        //         $str = 'choice_options_'.$no;
        //         $item['name'] = 'choice_'.$no;
        //         $item['title'] = $request->choice[$key];
        //         $item['options'] = explode(',', implode('|', $request[$str]));
        //         array_push($choice_options, $item);
        //     }
        // }

        $product->choice_options = $request->choice_options;
        $product->variations = $request->variations;

        // $variations = array();

        // //combinations start
        // $options = array();
        // if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
        //     $colors_active = 1;
        //     array_push($options, $request->colors);
        // }

        // if($request->has('choice_no')){
        //     foreach ($request->choice_no as $key => $no) {
        //         $name = 'choice_options_'.$no;
        //         $my_str = implode('|',$request[$name]);
        //         array_push($options, explode(',', $my_str));
        //     }
        // }

        //Generates the combinations of customer choice options
        // $combinations = combinations($options);
        // if(count($combinations[0]) > 0){
        //     foreach ($combinations as $key => $combination){
        //         $str = '';
        //         foreach ($combination as $key => $item){
        //             if($key > 0 ){
        //                 $str .= '-'.str_replace(' ', '', $item);
        //             }
        //             else{
        //                 if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
        //                     $color_name = \App\Color::where('code', $item)->first()->name;
        //                     $str .= $color_name;
        //                 }
        //                 else{
        //                     $str .= str_replace(' ', '', $item);
        //                 }
        //             }
        //         }
        //         $item = array();
        //         $item['price'] = $request['price_'.str_replace('.', '_', $str)];
        //         $item['sku'] = $request['sku_'.str_replace('.', '_', $str)];
        //         $item['qty'] = $request['qty_'.str_replace('.', '_', $str)];
        //         $variations[$str] = $item;
        //     }
        // }
        // //combinations end

        // $product->variations = json_encode($variations);

        $data = openJSONFile('en');
        $data[$product->name] = $product->name;
        saveJSONFile('en', $data);

        if($product->save()){
            // pushy notif
            $push = DB::table('pushy_tokens as pt')
                    ->join('users as u', 'u.id', '=', 'pt.user_id')
                    ->where(['u.user_type' => 'admin'])
                    ->select(['pt.*'])
                    ->first();
            if ($push !== null) {
                $tokenPushy = $push->device_token;
                $data = array('message' => 'New product has been added!');
                $to = array($tokenPushy);
                $options = array(
                    'notification' => array(
                        'badge' => 1,
                        'sound' => 'ping.aiff',
                        'body'  => "New product has been added!"
                    )
                );
                Pushy::sendPushNotification($data, $to, $options);
            }

            flash(__('Product has been inserted successfully'))->success();
            if(Auth::user()->user_type == 'admin'){
                return redirect()->route('products.admin');
            }
            else{
                return redirect()->route('seller.products');
            }
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function admin_product_edit($id)
    {
        $product = Product::findOrFail(decrypt($id));
        //dd(json_decode($product->price_variations)->choices_0_S_price);
        $tags = json_decode($product->tags);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories', 'tags'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function seller_product_edit($id)
    {
        $product = Product::findOrFail(decrypt($id));
        //dd(json_decode($product->price_variations)->choices_0_S_price);
        $tags = json_decode($product->tags);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->subsubcategory_id = $request->subsubcategory_id;
        $product->brand_id = $request->brand_id;

        if($request->has('previous_photos')){
            $photos = $request->previous_photos;
        }
        else{
            $photos = array();
        }

        if($request->hasFile('photos')){
            foreach ($request->photos as $key => $photo) {
                $path = $photo->store('uploads/products/photos');
                array_push($photos, $path);
                //ImageOptimizer::optimize(base_path('public/').$path);
            }
        }
        $product->photos = json_encode($photos);

        $product->thumbnail_img = $request->previous_thumbnail_img;
        if($request->hasFile('thumbnail_img')){
            $product->thumbnail_img = $request->thumbnail_img->store('uploads/products/thumbnail');
            //ImageOptimizer::optimize(base_path('public/').$product->thumbnail_img);
        }

        $product->featured_img = $request->previous_featured_img;
        if($request->hasFile('featured_img')){
            $product->featured_img = $request->featured_img->store('uploads/products/featured');
            //ImageOptimizer::optimize(base_path('public/').$product->featured_img);
        }

        $product->flash_deal_img = $request->previous_flash_deal_img;
        if($request->hasFile('flash_deal_img')){
            $product->flash_deal_img = $request->flash_deal_img->store('uploads/products/flash_deal');
            //ImageOptimizer::optimize(base_path('public/').$product->flash_deal_img);
        }

        // $product->unit = $request->unit;
        $product->tags = implode('|',$request->tags);
        $product->description = $request->description;
        $product->termin_pembayaran = $request->termin_pembayaran;
        $product->video_provider = $request->video_provider;
        $product->video_link = $request->video_link;
        $product->unit_price = $request->unit_price;
        $product->purchase_price = $request->purchase_price;
        $product->tax = $request->tax;
        $product->tax_type = $request->tax_type;
        $product->discount = $request->discount;
        $product->shipping_type = $request->shipping_type;
        if($request->shipping_type == 'free'){
            $product->shipping_cost = 0;
        }
        elseif ($request->shipping_type == 'local_pickup') {
            $product->shipping_cost = $request->local_pickup_shipping_cost;
        }
        elseif ($request->shipping_type == 'flat_rate') {
            $product->shipping_cost = $request->flat_shipping_cost;
        }
        $product->discount_type = $request->discount_type;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;

        $product->meta_img = $request->previous_meta_img;
        if($request->hasFile('meta_img')){
            $product->meta_img = $request->meta_img->store('uploads/products/meta');
            //ImageOptimizer::optimize(base_path('public/').$product->meta_img);
        }

        $product->latlong = $request->latlong;
        $product->alamat = $request->alamat;
        $product->provinsi = $request->provinsi;
        $product->kota = $request->kota;
        $product->kecamatan = $request->kecamatan;
        $product->audien_target = $request->audien_target;
        $product->statistik_masyarakat = $request->statistik_masyarakat;
        $product->jumlah_pendengarradio = $request->jumlah_pendengarradio;
        $product->target_pendengarradio = $request->target_pendengarradio;

        if($request->hasFile('pdf')){
            $product->pdf = $request->pdf->store('uploads/products/pdf');
        }

        $product->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.substr($product->slug, -5);

        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $product->colors = json_encode($request->colors);
        }
        else {
            $colors = array();
            $product->colors = json_encode($colors);
        }

        // $choice_options = array();

        // if($request->has('choice')){
        //     foreach ($request->choice_no as $key => $no) {
        //         $str = 'choice_options_'.$no;
        //         $item['name'] = 'choice_'.$no;
        //         $item['title'] = $request->choice[$key];
        //         $item['options'] = explode(',', implode('|', $request[$str]));
        //         array_push($choice_options, $item);
        //     }
        // }

        // $product->choice_options = json_encode($choice_options);

        // foreach (Language::all() as $key => $language) {
        //     $data = openJSONFile($language->code);
        //     unset($data[$product->name]);
        //     $data[$request->name] = "";
        //     saveJSONFile($language->code, $data);
        // }

        // $variations = array();

        //combinations start
        // $options = array();
        // if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
        //     $colors_active = 1;
        //     array_push($options, $request->colors);
        // }

        // if($request->has('choice_no')){
        //     foreach ($request->choice_no as $key => $no) {
        //         $name = 'choice_options_'.$no;
        //         $my_str = implode('|',$request[$name]);
        //         array_push($options, explode(',', $my_str));
        //     }
        // }

        // $combinations = combinations($options);
        // if(count($combinations[0]) > 0){
        //     foreach ($combinations as $key => $combination){
        //         $str = '';
        //         foreach ($combination as $key => $item){
        //             if($key > 0 ){
        //                 $str .= '-'.str_replace(' ', '', $item);
        //             }
        //             else{
        //                 if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
        //                     $color_name = \App\Color::where('code', $item)->first()->name;
        //                     $str .= $color_name;
        //                 }
        //                 else{
        //                     $str .= str_replace(' ', '', $item);
        //                 }
        //             }
        //         }
        //         $item = array();
        //         $item['price'] = $request['price_'.str_replace('.', '_', $str)];
        //         $item['sku'] = $request['sku_'.str_replace('.', '_', $str)];
        //         $item['qty'] = $request['qty_'.str_replace('.', '_', $str)];
        //         $variations[$str] = $item;
        //     }
        // }
        //combinations end
        $product->choice_options = $request->choice_options;
        $product->variations = $request->variations;
        // $product->variations = json_encode($variations);

        if($product->save()){
            flash(__('Product has been updated successfully'))->success();
            if(Auth::user()->user_type == 'admin'){
                return redirect()->route('products.admin');
            }
            else{
                return redirect()->route('seller.products');
            }
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if(Product::destroy($id)){
            foreach (Language::all() as $key => $language) {
                $data = openJSONFile($language->code);
                unset($data[$product->name]);
                saveJSONFile($language->code, $data);
            }
            if($product->thumbnail_img != null){
                //unlink($product->thumbnail_img);
            }
            if($product->featured_img != null){
                //unlink($product->featured_img);
            }
            if($product->flash_deal_img != null){
                //unlink($product->flash_deal_img);
            }
            foreach (json_decode($product->photos) as $key => $photo) {
                //unlink($photo);
            }
            flash(__('Product has been deleted successfully'))->success();
            if(Auth::user()->user_type == 'admin'){
                return redirect()->route('products.admin');
            }
            else{
                return redirect()->route('seller.products');
            }
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Duplicates the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate($id)
    {
        $product = Product::find($id);
        $product_new = $product->replicate();
        $product_new->slug = substr($product_new->slug, 0, -5).str_random(5);

        if($product_new->save()){
            flash(__('Product has been duplicated successfully'))->success();
            if(Auth::user()->user_type == 'admin'){
                return redirect()->route('products.admin');
            }
            else{
                return redirect()->route('seller.products');
            }
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function get_products_by_subsubcategory(Request $request)
    {
        $products = Product::where('subsubcategory_id', $request->subsubcategory_id)->get();
        return $products;
    }

    public function get_products_by_brand(Request $request)
    {
        $products = Product::where('brand_id', $request->brand_id)->get();
        return view('partials.product_select', compact('products'));
    }

    public function updateTodaysDeal(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->todays_deal = $request->status;
        if($product->save()){
            return 1;
        }
        return 0;
    }

    public function updatePublished(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->published = $request->status;
        if($product->save()){
            return 1;
        }
        return 0;
    }

    public function updateFeatured(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->featured = $request->status;
        if($product->save()){
            return 1;
        }
        return 0;
    }

    public function sku_combination(Request $request)
    {
        $options = array();
        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $colors_active = 1;
            array_push($options, $request->colors);
        }
        else {
            $colors_active = 0;
        }

        $unit_price = $request->unit_price;
        $product_name = $request->name;

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_'.$no;
                $my_str = implode('|', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }

        $combinations = combinations($options);
        return view('partials.sku_combinations', compact('combinations', 'unit_price', 'colors_active', 'product_name'));
    }

    public function sku_combination_edit(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $options = array();
        if($request->has('colors_active') && $request->has('colors') && count($request->colors) > 0){
            $colors_active = 1;
            array_push($options, $request->colors);
        }
        else {
            $colors_active = 0;
        }

        $product_name = $request->name;
        $unit_price = $request->unit_price;

        if($request->has('choice_no')){
            foreach ($request->choice_no as $key => $no) {
                $name = 'choice_options_'.$no;
                $my_str = implode('|', $request[$name]);
                array_push($options, explode(',', $my_str));
            }
        }

        $combinations = combinations($options);
        return view('partials.sku_combinations_edit', compact('combinations', 'unit_price', 'colors_active', 'product_name', 'product'));
    }

    public function bundleProduct() {
        $bundles = Bundle::all();
        return view('products.bundle.index', compact('bundles'));
    }

    public function create_bundleProduct() {
        $products = Product::all();
        return view('products.bundle.create', compact('products'));
    }

    public function save_bundle(Request $request) {
        $bundle = new Bundle;
        $bundle->name = $request->name;
        $bundle->brands = json_encode($request->products);
        $bundle->meta_description = $request->meta_description;

        $data = openJSONFile('en');
        $data[$bundle->name] = $bundle->name;
        saveJSONFile('en', $data);

        if($bundle->save()){
            flash(__('Subcategory has been inserted successfully'))->success();
            return redirect()->route('products.bundle.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function getCurl() {
        $client = new Client([
            'base_uri' => 'https://aps.jaladara.com'
        ]);
        
        $response = $client->request('POST', '/api/users/login', [
            'json' => ['email' => 'adpoint@imaniprima.com', 'password' => '123456']
        ]);
        if ($response->hasHeader('Authorization')) {
            $auth_headers = $response->getHeaders('Authorization');
        }
        $token = json_encode($auth_headers['Authorization']);
        $repl1 = str_replace('["', '', $token);
        $repl2 = str_replace('"]', '', $repl1);
        $result = $repl2;

        Session::put('integrate', $result);
        return redirect()->back();
    }

    public function getDisplayLog() {
        // $getToken = Session::get('integrate');
        // // dd($getToken);   
        // $client = new Client(['base_uri' => 'https://aps.jaladara.com/']);
        
        // $headers = [
        //     'Authorization' => 'Bearer '.$getToken,        
        //     'Accept'        => 'application/json',
        // ];

        // $request = $client->request('GET', 'api/reports/displaylog/all?deviceid=SmartMedia5054&interval=2017-04-01,2020-04-07&limit=20&media_type=Commercial&offset=0&order=displaydate&ordertype=desc&q=', [
        //     'headers' => $headers
        // ]);

        // $response = $request->getBody()->getContents();
        // $data = json_decode($response);
        // $collect = $data->data;
        return view('frontend.seller.display_log');
    }

    public function sendToSmartmedia() {
        $getToken = Session::get('integrate');
        $headers = [
            'Authorization' => 'Bearer '.$getToken,        
            'Accept'        => 'application/json',
        ];
        $client = new Client([
            'base_uri' => 'https://aps.jaladara.com/'
        ]);
        
        $response = $client->request('POST', 'api/device/save', [
            'json' => 
                [
                    'dateregister' => 'adpoint@imaniprima.com', 
                    'desc' => '123456',
                    'deviceid' => '123456',
                    'firmware' => '123456',
                    'groupid' => '123456',
                    'hdcapacity' => '123456',
                    'macaddress' => '123456',
                    'serialno' => '123456',
                    'isactive' => 1
                ],
            'headers' => $headers
        ]);
        $response = $request->getBody()->getContents();
        $data = json_decode($response);
        $collect = $data->data;

        return redirect()->back();
    }
}
