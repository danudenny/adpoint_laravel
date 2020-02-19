<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Redis;
Route::get('/redis', function () {
    $p = Redis::incr('p');
    return $p;
});
Auth::routes(['verify' => true]);
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::post('/language', 'LanguageController@changeLanguage')->name('language.change');
Route::post('/currency', 'CurrencyController@changeCurrency')->name('currency.change');

Route::get('/social-login/redirect/{provider}', 'Auth\LoginController@redirectToProvider')->name('social.login');
Route::get('/social-login/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name('social.callback');
Route::get('/users/login', 'HomeController@login')->name('user.login');
Route::post('/users/login', 'HomeController@login_proses')->name('login.user');
Route::get('/users/registration', 'HomeController@registration')->name('user.registration');
Route::post('/users/registration', 'HomeController@registration_proses')->name('register.user');
//Route::post('/users/login', 'HomeController@user_login')->name('user.login.submit');
Route::post('/users/login/cart', 'HomeController@cart_login')->name('cart.login.submit');




// reset password
Route::get('/users/reset-password', 'HomeController@resetPassword')->name('reset.password');
Route::post('/users/reset-password', 'PasswordResetController@sendEmailReset')->name('send.email.reset');
Route::get('/users/change-password', 'PasswordResetController@formResetPassword')->name('form.reset');
Route::post('/users/set-password', 'PasswordResetController@setPassword')->name('set.password');

Route::post('/subcategories/get_subcategories_by_category', 'SubCategoryController@get_subcategories_by_category')->name('subcategories.get_subcategories_by_category');
Route::post('/subsubcategories/get_subsubcategories_by_subcategory', 'SubSubCategoryController@get_subsubcategories_by_subcategory')->name('subsubcategories.get_subsubcategories_by_subcategory');
Route::post('/subsubcategories/get_brands_by_subsubcategory', 'SubSubCategoryController@get_brands_by_subsubcategory')->name('subsubcategories.get_brands_by_subsubcategory');
Route::post('/subsubcategories/get_brands_by_subcategory', 'SubCategoryController@get_brands_by_subcategory')->name('subcategories.get_brands_by_subcategory');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/sitemap.xml', function(){
	return base_path('sitemap.xml');
});

// push notif
Route::post('/push','HomeController@push');

Route::get('/product/{slug}', 'HomeController@product')->name('product');
Route::get('/products', 'HomeController@listing')->name('products');
// list product untuk di konsum jquery
Route::get('/listproduct', 'HomeController@getlistProduct');
Route::get('/search?location={location_slug}', 'HomeController@search')->name('products.location');
Route::get('/search?category={category_slug}', 'HomeController@search')->name('products.category');
Route::get('/search?subcategory={subcategory_slug}', 'HomeController@search')->name('products.subcategory');
Route::get('/search?subsubcategory={subsubcategory_slug}', 'HomeController@search')->name('products.subsubcategory');
Route::get('/search?brand={brand_slug}', 'HomeController@search')->name('products.brand');
Route::post('/product/variant_price', 'HomeController@variant_price')->name('products.variant_price');
Route::get('/shops/visit/{slug}', 'HomeController@shop')->name('shop.visit');
Route::get('/shops/visit/{slug}/{type}', 'HomeController@filter_shop')->name('shop.visit.type');

Route::get('/cart', 'CartController@index')->name('cart');
Route::post('/cart/nav-cart-items', 'CartController@updateNavCart')->name('cart.nav_cart');
Route::post('/cart/show-cart-modal', 'CartController@showCartModal')->name('cart.showCartModal');
Route::post('/cart/addtocart', 'CartController@addToCart')->name('cart.addToCart');
Route::post('/cart/removeFromCart', 'CartController@removeFromCart')->name('cart.removeFromCart');
Route::post('/cart/updateQuantity', 'CartController@updateQuantity')->name('cart.updateQuantity');

Route::post('/cart/upload_ads', 'CartController@form_upload_ads')->name('form.upload.ads');
Route::post('/cart/upload_ads_proses', 'CartController@upload_ads_proses')->name('upload.ads.proses');

Route::post('/checkout/payment', 'CheckoutController@checkout')->name('payment.checkout');
Route::get('/checkout', 'CheckoutController@get_shipping_info')->name('checkout.shipping_info');
Route::post('/checkout/payment_select', 'CheckoutController@store_shipping_info')->name('checkout.store_shipping_infostore');
Route::post('/checkout/upload_advertising', 'CheckoutController@upload_advertising')->name('checkout.upload_advertising');
Route::get('/checkout/payment_select', 'CheckoutController@get_payment_info')->name('checkout.payment_info');
Route::post('/checkout/apply_coupon_code', 'CheckoutController@apply_coupon_code')->name('checkout.apply_coupon_code');
Route::post('/checkout/remove_coupon_code', 'CheckoutController@remove_coupon_code')->name('checkout.remove_coupon_code');

//Paypal START
Route::get('/paypal/payment/done', 'PaypalController@getDone')->name('payment.done');
Route::get('/paypal/payment/cancel', 'PaypalController@getCancel')->name('payment.cancel');
//Paypal END

// SSLCOMMERZ Start
Route::get('/sslcommerz/pay', 'PublicSslCommerzPaymentController@index');
Route::POST('/sslcommerz/success', 'PublicSslCommerzPaymentController@success');
Route::POST('/sslcommerz/fail', 'PublicSslCommerzPaymentController@fail');
Route::POST('/sslcommerz/cancel', 'PublicSslCommerzPaymentController@cancel');
Route::POST('/sslcommerz/ipn', 'PublicSslCommerzPaymentController@ipn');
//SSLCOMMERZ END

//Stipe Start
Route::get('stripe', 'StripePaymentController@stripe');
Route::post('stripe', 'StripePaymentController@stripePost')->name('stripe.post');
//Stripe END

Route::get('/compare', 'CompareController@index')->name('compare');
Route::get('/compare/reset', 'CompareController@reset')->name('compare.reset');
Route::post('/compare/addToCompare', 'CompareController@addToCompare')->name('compare.addToCompare');

Route::resource('subscribers','SubscriberController');

Route::get('/brands', 'HomeController@all_brands')->name('brands.all');
Route::get('/categories', 'HomeController@all_categories')->name('categories.all');
Route::get('/search', 'HomeController@search')->name('search');
Route::get('/search?q={search}', 'HomeController@search')->name('suggestion.search');
Route::post('/ajax-search', 'HomeController@ajax_search')->name('search.ajax');
Route::post('/config_content', 'HomeController@product_content')->name('configs.update_status');

Route::get('/sellerpolicy', 'HomeController@sellerpolicy')->name('sellerpolicy');
Route::get('/returnpolicy', 'HomeController@returnpolicy')->name('returnpolicy');
Route::get('/supportpolicy', 'HomeController@supportpolicy')->name('supportpolicy');
Route::get('/terms', 'HomeController@terms')->name('terms');
Route::get('/privacypolicy', 'HomeController@privacypolicy')->name('privacypolicy');

Route::group(['middleware' => ['user', 'verified']], function(){
	Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
	Route::get('/profile', 'HomeController@profile')->name('profile');
	Route::post('/customer/update-profile', 'HomeController@customer_update_profile')->name('customer.profile.update');
	Route::post('/seller/update-profile', 'HomeController@seller_update_profile')->name('seller.profile.update');

	Route::resource('purchase_history','PurchaseHistoryController');
	Route::post('/purchase_history/details', 'PurchaseHistoryController@purchase_history_details')->name('purchase_history.details');
	Route::post('/purchase_history/item_details', 'PurchaseHistoryController@item_details')->name('item.details');
	Route::post('/purchase_history/show_bukti_tayang', 'PurchaseHistoryController@show_bukti_tayang')->name('show.bukti.tayang');
	Route::get('/purchase_history/my_order/{id}', 'PurchaseHistoryController@my_order')->name('my.order');
	Route::get('/purchase_history/destroy/{id}', 'PurchaseHistoryController@destroy')->name('purchase_history.destroy');

	// load get from ajax
	Route::get('place-order', 'PurchaseHistoryController@order_place')->name('myorder.place.order');
	Route::get('review-order', 'PurchaseHistoryController@order_review')->name('myorder.review.order');
	Route::get('active-order', 'PurchaseHistoryController@order_active')->name('myorder.active.order');
	Route::get('complete-order', 'PurchaseHistoryController@order_complete')->name('myorder.complete.order');
	Route::get('cancelled-order', 'PurchaseHistoryController@order_cancelled')->name('myorder.cancelled.order');

	Route::post('find_myorder', 'PurchaseHistoryController@find_myorder')->name('find.myorder');


	Route::get('/transaction', 'TransactionController@trx_page_buyer')->name('trx.page.buyer');
	Route::post('/transaction/show_transaction_details', 'TransactionController@show_transaction_details')->name('show.transaction.details');

	// load get from ajax
	Route::get('trx-unpaid', 'TransactionController@trx_unpaid')->name('trx.unpaid');
	Route::get('trx-paid', 'TransactionController@trx_paid')->name('trx.paid');

	Route::post('find-trx-unpaid', 'TransactionController@find_trx_unpaid')->name('find.trx.unpaid');
	Route::post('find-trx-paid', 'TransactionController@find_trx_paid')->name('find.trx.paid');


	Route::resource('wishlists','WishlistController');
	Route::post('/wishlists/remove', 'WishlistController@remove')->name('wishlists.remove');

	Route::get('/wallet', 'WalletController@index')->name('wallet.index');
	Route::post('/recharge', 'WalletController@recharge')->name('wallet.recharge');

	Route::resource('support_ticket','SupportTicketController');
	Route::post('support_ticket/reply','SupportTicketController@seller_store')->name('support_ticket.seller_store');
});

Route::group(['prefix' =>'seller', 'middleware' => ['seller', 'verified']], function(){
	Route::get('/products', 'HomeController@seller_product_list')->name('seller.products');
	Route::get('/product/upload', 'HomeController@show_product_upload_form')->name('seller.products.upload');
	Route::get('/product/{id}/edit', 'HomeController@show_product_edit_form')->name('seller.products.edit');
	Route::resource('payments','PaymentController');

	Route::get('/shop/apply_for_verification', 'ShopController@verify_form')->name('shop.verify');
	Route::post('/shop/apply_for_verification', 'ShopController@verify_form_store')->name('shop.verify.store');

	Route::get('/reviews', 'ReviewController@seller_reviews')->name('reviews.seller');
});

Route::group(['middleware' => ['auth']], function(){
	Route::post('/products/store/','ProductController@store')->name('products.store');
	Route::post('/products/update/{id}','ProductController@update')->name('products.update');
	Route::get('/products/destroy/{id}', 'ProductController@destroy')->name('products.destroy');
	Route::get('/products/duplicate/{id}', 'ProductController@duplicate')->name('products.duplicate');
	Route::post('/products/sku_combination', 'ProductController@sku_combination')->name('products.sku_combination');
	Route::post('/products/sku_combination_edit', 'ProductController@sku_combination_edit')->name('products.sku_combination_edit');
	Route::post('/products/featured', 'ProductController@updateFeatured')->name('products.featured');
	Route::post('/products/published', 'ProductController@updatePublished')->name('products.published');

	Route::get('invoice/customer/{order_id}', 'InvoiceController@customer_invoice_download')->name('customer.invoice.download');
	Route::get('invoice/seller/{order_id}', 'InvoiceController@seller_invoice_download')->name('seller.invoice.download');

	Route::resource('orders','OrderController');
	Route::post('/orders/item_details', 'OrderController@item_details_seller')->name('item.details.seller');
	Route::get('/orders/approve_by_seller/{id}', 'OrderController@approve_by_seller')->name('approve.by.seller');
	Route::get('/orders/approve_all_by_seller', 'OrderController@approve_all_by_seller')->name('approved.all.by.seller');
	Route::post('/orders/disapprove_by_seller', 'OrderController@disapprove_by_seller')->name('disapprove.by.seller');

	// load get from ajax
	Route::get('place-order-seller', 'OrderController@order_place')->name('orders.place.order');
	Route::get('review-order-seller', 'OrderController@order_review')->name('orders.review.order');
	Route::get('active-order-seller', 'OrderController@order_active')->name('orders.active.order');
	Route::get('complete-order-seller', 'OrderController@order_completes')->name('orders.complete.order');
	Route::get('cancelled-order-seller', 'OrderController@order_cancelled')->name('orders.cancelled.order');

	Route::post('post-process-active', 'OrderController@post_process_active')->name('post.process.active');

	Route::post('find_orders', 'OrderController@find_orders')->name('find.orders');


	Route::get('/orders/destroy/{id}', 'OrderController@destroy')->name('orders.destroy');
	Route::post('/orders/details', 'OrderController@order_details')->name('orders.details');
	Route::post('/orders/update_delivery_status', 'OrderController@update_delivery_status')->name('orders.update_delivery_status');
	Route::post('/orders/update_payment_status', 'OrderController@update_payment_status')->name('orders.update_payment_status');
	Route::get('/confirm_payment', 'OrderController@confirm_payment')->name('confirm.payment');
	Route::get('/continue_payment/{id}', 'OrderController@continue_payment')->name('continue.payment');
	Route::get('/confirm_payment/{id}', 'OrderController@confirm_payment_id')->name('confirm.payment.id');
	Route::post('/confirm_payment/insert', 'OrderController@insert_confirm_payment')->name('insert.confirm.payment');
	Route::post('/order_activate', 'OrderController@activate')->name('order.activate');
	Route::get('/order_complete/{id}', 'OrderController@complete')->name('order.complete');

	Route::resource('broadcast_proof', 'EvidenceController');
	Route::get('/broadcast_proof/aktifkan/{id}', 'EvidenceController@aktifkan')->name('aktifkan');
	Route::get('/broadcast_proof/bukti_tayang/{id}', 'EvidenceController@bukti_tayang')->name('bukti.tayang');
	Route::post('/broadcast_proof/upload_bukti_tayang', 'EvidenceController@upload_bukti_tayang')->name('upload.bukti.tayang');
	Route::post('/broadcast_proof/update_bukti_tayang', 'EvidenceController@update_bukti_tayang')->name('update.bukti.tayang');
	Route::post('/broadcast_proof/delete_file_image', 'EvidenceController@delete_file_image')->name('delete.file.image');
	Route::post('/broadcast_proof/delete_file_video', 'EvidenceController@delete_file_video')->name('delete.file.video');
	Route::get('/broadcast_proof/complete/{id}', 'EvidenceController@complete')->name('complete');
	Route::get('/broadcast', 'EvidenceController@broadcast_customer')->name('broadcast.index');
	Route::post('/broadcast/details', 'EvidenceController@broadcast_details')->name('broadcast.details');

	Route::post('bukti_tayang_detail', 'EvidenceController@bukti_tayang_detail')->name('bukti.tayang.detail');

	Route::resource('/reviews', 'ReviewController');
	Route::post('/review/review_product', 'ReviewController@review_product')->name('review.product');
	Route::post('/review/create_review_product', 'ReviewController@create_review_product')->name('create.review.product');
});

Route::resource('shops', 'ShopController');
Route::get('/track_your_order', 'HomeController@trackOrder')->name('orders.track');

Route::get('/instamojo/payment/pay-success', 'InstamojoController@success')->name('instamojo.success');

Route::post('rozer/payment/pay-success', 'RazorpayController@payment')->name('payment.rozer');

Route::get('/paystack/payment/callback', 'PaystackController@handleGatewayCallback');
