<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;
use Hash;
use DB;
use App\Category;
use App\Brand;
use App\SubCategory;
use App\SubSubCategory;
use App\Product;
use App\User;
use App\Seller;
use App\Shop;
use App\Color;
use App\Order;
use App\State;
use App\BusinessSetting;
use App\Http\Controllers\SearchController;
use ImageOptimizer;
use App\Pushy;
use Tracker;

// Notif
use Notification;
use App\Notifications\UserRegister;
use App\Events\UserRegisterEvent;


// Mail
use Mail;
use App\Mail\User\RegistUser;
use App\Mail\Admin\AdminUserRegister;
use Illuminate\Support\Facades\Cache;


class HomeController extends Controller
{
    public function get_all_notif_admin()
    {
        return view('real-notif.admin_notif');
    }

    public function get_all_notif_member()
    {
        return view('real-notif.member_notif');
    }

    public function count_notif_admin()
    {
        $user = Auth::user();
        return $user->unreadNotifications->count();
    }

    public function count_notif_member()
    {
        $user = Auth::user();
        if ($user->user_type == "customer") {
            return $user->unreadNotifications->count();
        }else if($user->user_type == "seller") {
            return $user->unreadNotifications->count();
        }
    }

    public function mark_as_read($id) {
        $user = Auth::user();
        foreach ($user->unreadNotifications as $notif) {
            if ($notif->id === $id) {
                $notif->markAsRead();
            }
        }
        return back();
    }

    public function mark_all_as_read() {
        $user = Auth::user();
        foreach ($user->unreadNotifications as $notif) {
            $notif->markAsRead();
        }
        return back();
    }

    public function login()
    {
        if(Auth::check()){
            if (Auth::user()->verified == 1) {
                return redirect()->route('home');
            }
        }
        return view('frontend.user_login');
    }

    public function registration()
    {
        if(Auth::check()){
            if (Auth::user()->verified == 1) {
                return redirect()->route('home');
            }
        }
        return view('frontend.user_registration');
    }

    public function resetPassword()
    {
        return view('frontend.user_reset_password');
    }

    public function registration_proses(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'ktp' => 'required',
            'npwp' => 'required',
            'captcha' => 'captcha'
        ]);
        
        $register = new User;
        $register->name = $request->name;
        $register->email = $request->email;
        $register->password = Hash::make($request->password);
        $register->ktp = $request->file('ktp')->store('uploads/users');
        $register->npwp = $request->file('npwp')->store('uploads/users');
        $user['name'] = $register->name;
        $user['email'] = $register->email;
        if ($register->save()) {
            $push = DB::table('pushy_tokens as pt')
                    ->join('users as u', 'u.id', '=', 'pt.user_id')
                    ->where(['u.user_type' => 'admin'])
                    ->select(['pt.*'])
                    ->first();
            if ($push !== null) {
                $tokenPushy = $push->device_token;
                $data = array('message' => 'New user has registered ('.$request->name.')');
                $to = array($tokenPushy);
                $options = array(
                    'notification' => array(
                        'badge' => 1,
                        'sound' => 'ping.aiff',
                        'body'  => 'New user has registered ('.$request->name.')'
                    )
                );
                Pushy::sendPushNotification($data, $to, $options);
            }
            $register->verified = 0;
            $admin = User::where('user_type','admin')->first();
            $request->session()->flash('message', 'Thanks for your registration, please check your email!.');
            Notification::send($admin, new UserRegister($request->name));
            event(new UserRegisterEvent('New user has registered '.$request->name));
            Mail::to($request->email)->send(new RegistUser($user));
            Mail::to($admin->email)->send(new AdminUserRegister($admin));
            return back();
        }
        return back();
    }

    public function login_proses(Request $request)
    {
        $valid = Auth::attempt(['email' => $request->email, 'password' => $request->password,'verified'=> 1]);
        $user = User::where('email', $request->email)->first();
        dd($user);
        if ($user !== null) {
            if (password_verify($request->password, $user->password)) {
                if ($user->verified === 1) {
                    if ($user->user_type === 'customer' || $user->user_type === 'seller') {
                        flash(__('Your logged!'))->success();
                        return redirect()->route('dashboard');
                    }else if($user->user_type === 'admin') {
                        return redirect()->route('admin.dashboard');
                    }
                }else {
                    $request->session()->flash('message', 'Your account has not been verified');
                    return back();
                }
            }else {
                $request->session()->flash('message', 'Your password does not match');
                return back();
            }
        }else{
            $request->session()->flash('message', 'Your email not registered');
            return back();
        }
    }

    public function logout(){
        if (Auth::check()) {
            if (Auth::user()->user_type !== "admin") {
                Auth::logout();
                return redirect('/');
            }else{
                Auth::logout();
                return redirect('/login');
            }
        } else {
            return redirect('/');
        }
    }

    public function cart_login(Request $request)
    {
        $user = User::whereIn('user_type', ['customer', 'seller'])->where('email', $request->email)->first();

        if($user != null){
            updateCartSetup();
            if(Hash::check($request->password, $user->password)){
                if($request->has('remember')){
                    auth()->login($user, true);
                }
                else{
                    auth()->login($user, false);
                }
            }
        }
        return back();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_dashboard()
    {
        return view('dashboard');
    }

    /**
     * Show the customer/seller dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if(Auth::user()->user_type == 'seller'){
            return view('frontend.seller.dashboard');
        }
        elseif(Auth::user()->user_type == 'customer'){
            return view('frontend.customer.dashboard');
        }
        else {
            abort(404);
        }
    }

    public function profile(Request $request)
    {
        if(Auth::user()->user_type == 'customer'){
            return view('frontend.customer.profile');
        }
        elseif(Auth::user()->user_type == 'seller'){
            return view('frontend.seller.profile');
        }
    }

    public function customer_update_profile(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->phone = $request->phone;

        if($request->new_password != null && ($request->new_password == $request->confirm_password)){
            $user->password = Hash::make($request->new_password);
        }

        if($request->hasFile('photo')){
            $user->avatar_original = $request->photo->store('uploads/users');
        }

        if($user->save()){
            flash(__('Your Profile has been updated successfully!'))->success();
            return back();
        }

        flash(__('Sorry! Something went wrong.'))->error();
        return back();
    }


    public function seller_update_profile(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->phone = $request->phone;

        if($request->new_password != null && ($request->new_password == $request->confirm_password)){
            $user->password = Hash::make($request->new_password);
        }

        if($request->hasFile('photo')){
            $user->avatar_original = $request->photo->store('uploads');
        }

        $seller = $user->seller;
        $seller->cash_on_delivery_status = $request->cash_on_delivery_status;
        $seller->sslcommerz_status = $request->sslcommerz_status;
        $seller->ssl_store_id = $request->ssl_store_id;
        $seller->ssl_password = $request->ssl_password;
        $seller->paypal_status = $request->paypal_status;
        $seller->paypal_client_id = $request->paypal_client_id;
        $seller->paypal_client_secret = $request->paypal_client_secret;
        $seller->stripe_status = $request->stripe_status;
        $seller->stripe_key = $request->stripe_key;
        $seller->stripe_secret = $request->stripe_secret;
        $seller->instamojo_status = $request->instamojo_status;
        $seller->instamojo_api_key = $request->instamojo_api_key;
        $seller->instamojo_token = $request->instamojo_token;
        $seller->razorpay_status = $request->razorpay_status;
        $seller->razorpay_api_key = $request->razorpay_api_key;
        $seller->razorpay_secret = $request->razorpay_secret;
        $seller->paystack_status = $request->paystack_status;
        $seller->paystack_public_key = $request->paystack_public_key;
        $seller->paystack_secret_key = $request->paystack_secret_key;

        if($user->save() && $seller->save()){
            flash(__('Your Profile has been updated successfully!'))->success();
            return back();
        }

        flash(__('Sorry! Something went wrong.'))->error();
        return back();
    }

    /**
     * Show the application frontend home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Cache::remember("products", 10 * 60, function () {
            return Product::all();
        });

        $query = Cache::remember("brands", 10 * 60, function () {
            return Brand::all();
        });

        if (Auth::check()) {
            if (Auth::user()->user_type === "admin") {
                return redirect('/admin');
            }else {
                return view('frontend.index');
            }
        }else {
            return view('frontend.index');
        }

    }

    public function trackOrder(Request $request)
    {
        if($request->has('order_code')){
            $order = Order::where('code', $request->order_code)->first();
            if($order != null){
                return view('frontend.track_order', compact('order'));
            }else {
                flash(__('No order not found!'))->error();
            }
        }
        return view('frontend.track_order');
    }

    public function product($slug)
    {
        $product  = Product::where('slug', $slug)->first();
        if($product!=null){
            updateCartSetup();
            return view('frontend.product_details', compact('product'));
        }
        abort(404);
    }

    public function shop($slug)
    {
        $shop  = Shop::where('slug', $slug)->first();
        if($shop!=null){
            return view('frontend.seller_shop', compact('shop'));
        }
        abort(404);
    }

    public function filter_shop($slug, $type)
    {
        $shop  = Shop::where('slug', $slug)->first();
        if($shop!=null && $type != null){
            return view('frontend.seller_shop', compact('shop', 'type'));
        }
        abort(404);
    }

    public function listing(Request $request)
    {
        $products = filter_products(Product::orderBy('created_at', 'desc'))->paginate(12);
        return view('frontend.product_listing', compact('products'));
    }

    public function all_categories(Request $request)
    {
        $categories = Category::all();
        return view('frontend.all_category', compact('categories'));
    }
    public function all_brands(Request $request)
    {
        $categories = Category::all();
        return view('frontend.all_brand', compact('categories'));
    }

    public function show_product_upload_form(Request $request)
    {
        $categories = Category::all();
        return view('frontend.seller.product_upload', compact('categories'));
    }

    public function show_product_edit_form(Request $request, $id)
    {
        $categories = Category::all();
        $product = Product::find(decrypt($id));
        return view('frontend.seller.product_edit', compact('categories', 'product'));
    }

    public function seller_product_list(Request $request)
    {
        $products = Product::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('frontend.seller.products', compact('products'));
    }

    public function ajax_search(Request $request)
    {
        $keywords = array();
        $products = Product::where('published', 1)->where('tags', 'like', '%'.$request->search.'%')->get();
        foreach ($products as $key => $product) {
            foreach (explode(',',$product->tags) as $key => $tag) {
                if(stripos($tag, $request->search) !== false){
                    if(sizeof($keywords) > 5){
                        break;
                    }
                    else{
                        if(!in_array(strtolower($tag), $keywords)){
                            array_push($keywords, strtolower($tag));
                        }
                    }
                }
            }
        }

        $products = filter_products(Product::where('published', 1)->where('name', 'like', '%'.$request->search.'%'))->get()->take(3);

        $subsubcategories = SubSubCategory::where('name', 'like', '%'.$request->search.'%')->get()->take(3);

        $shops = Shop::where('name', 'like', '%'.$request->search.'%')->get()->take(3);

        if(sizeof($keywords)>0 || sizeof($subsubcategories)>0 || sizeof($products)>0 || sizeof($shops) >0){
            return view('frontend.partials.search_content', compact('products', 'subsubcategories', 'keywords', 'shops'));
        }
        return '0';
    }

    public function search(Request $request)
    {

        $query = $request->q;
        $brand_id = (Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
        $sort_by = $request->sort_by;
        $category_id = (Category::where('slug', $request->category)->first() != null) ? Category::where('slug', $request->category)->first()->id : null;
        $subcategory_id = (SubCategory::where('slug', $request->subcategory)->first() != null) ? SubCategory::where('slug', $request->subcategory)->first()->id : null;
        // $subsubcategory_id = (SubSubCategory::where('slug', $request->subsubcategory)->first() != null) ? SubSubCategory::where('slug', $request->subsubcategory)->first()->id : null;
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $seller_id = $request->seller_id;
        $states = urldecode($request->location);
        // dd($states);
        $alamat = $request->alamat;

        $conditions = ['published' => 1];

        if($brand_id != null){
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }
        if($category_id != null){
            $conditions = array_merge($conditions, ['category_id' => $category_id]);
        }
        if($subcategory_id != null){
            $conditions = array_merge($conditions, ['subcategory_id' => $subcategory_id]);
        }
        if ($states != null) {
            $conditions = array_merge($conditions, ['provinsi' => $states]);
        }
        if($seller_id != null){
            $conditions = array_merge($conditions, ['user_id' => Seller::findOrFail($seller_id)->user->id]);
        }

        // if ($alamat) {
        //     $products = Product::where($conditions)->where('alamat', 'LIKE', '%'.$alamat.'%');
        // }

        $products = Product::where($conditions);
        if($min_price != null && $max_price != null){
            $products = $products->where('unit_price', '>=', $min_price)->where('unit_price', '<=', $max_price);
        }

        if($query != null){
            $searchController = new SearchController;
            $searchController->store($request);
            $products = $products->where('name', 'like', '%'.$query.'%');
        }

        if($sort_by != null){
            switch ($sort_by) {
                case '1':
                    $products->orderBy('created_at', 'desc');
                    break;
                case '2':
                    $products->orderBy('created_at', 'asc');
                    break;
                case '3':
                    $products->orderBy('unit_price', 'asc');
                    break;
                case '4':
                    $products->orderBy('unit_price', 'desc');
                    break;
                case '5':
                    $products->orderBy('rating', 'desc');
                    break;
                default:
                    // code...
                    break;
            }
        }

        $products = filter_products($products)->paginate(12)->appends(request()->query());

        return view('frontend.product_listing', compact('products', 'states', 'query', 'category_id', 'subcategory_id', 'brand_id', 'sort_by', 'seller_id','min_price', 'max_price'));
    }

    public function product_content(Request $request){
        $connector  = $request->connector;
        $selector   = $request->selector;
        $select     = $request->select;
        $type       = $request->type;
        productDescCache($connector,$selector,$select,$type);
    }

    public function home_settings(Request $request)
    {
        return view('home_settings.index');
    }

    public function top_10_settings(Request $request)
    {
        foreach (Category::all() as $key => $category) {
            if(in_array($category->id, $request->top_categories)){
                $category->top = 1;
                $category->save();
            }
            else{
                $category->top = 0;
                $category->save();
            }
        }

        foreach (Brand::all() as $key => $brand) {
            if(in_array($brand->id, $request->top_brands)){
                $brand->top = 1;
                $brand->save();
            }
            else{
                $brand->top = 0;
                $brand->save();
            }
        }

        flash(__('Top 10 categories and brands have been updated successfully'))->success();
        return redirect()->route('home_settings.index');
    }

    public function how_to_settings(Request $request)
    {
        $bs = BusinessSetting::where('type', 'how_to')->first();
        $result['buy'] = $request->buy;
        $result['sell'] = $request->sell;

        $bs->value = json_encode($result);
        $bs->save();
        return back();
    }

    public function variant_price(Request $request)
    {
        $product = Product::find($request->id);
        $str = '';
        $quantity = 0;

        if($request->has('color')){
            $data['color'] = $request['color'];
            $str = Color::where('code', $request['color'])->first()->name;
        }

        foreach (json_decode(Product::find($request->id)->choice_options) as $key => $choice) {
            if($str != null){
                $str .= $request[$choice->title];
            }
            else{
                $str .= $request[$choice->title];
            }
        }

        if($str != null){
            $price = json_decode($product->variations)->$str->price;
            $quantity = json_decode($product->variations)->$str->qty;
        }
        else{
            $price = $product->unit_price;
        }

        //discount calculation
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
        return array('price' => single_price($price*$request->quantity), 'quantity' => $quantity);
    }

    public function sellerpolicy(){
        return view("frontend.policies.sellerpolicy");
    }

    public function returnpolicy(){
        return view("frontend.policies.returnpolicy");
    }

    public function supportpolicy(){
        return view("frontend.policies.supportpolicy");
    }

    public function terms(){
        return view("frontend.policies.terms");
    }

    public function privacypolicy(){
        return view("frontend.policies.privacypolicy");
    }

    public function getlistProduct(){

        return Product::with('products')->all();
    }

    public function push(Request $request)
    {
        $this->validate($request,[
            'endpoint'    => 'required',
            'keys.auth'   => 'required',
            'keys.p256dh' => 'required'
        ]);
        $endpoint = $request->endpoint;
        $token = $request->keys['auth'];
        $key = $request->keys['p256dh'];
        $user = Auth::user();
        $user->updatePushSubscription($endpoint, $key, $token);
        return response()->json(['success' => true],200);
    }


    public function notification()
    {
        return view('frontend.dropdown.dropdown_notif');
    }

    public function notif_buyer()
    {
        return view('frontend.dropdown.notif_buyer');
    }

    public function notif_seller()
    {
        return view('frontend.dropdown.notif_seller');
    }

    public function notif_trx()
    {
        return view('frontend.dropdown.notif_trx');
    }

    public function notif_update()
    {
        return view('frontend.dropdown.notif_update');
    }


    public function how_to_buy()
    {
        return view('frontend.howtobuy');
    }

    public function how_to_sell()
    {
        return view('frontend.howtosell');
    }

}
