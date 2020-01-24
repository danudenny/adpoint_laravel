<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'jsonify'], function () {
    Route::post('login', 'Api\LoginCtrl@login');
    Route::post('register', 'Api\RegisterCtrl@register');
});

Route::group(['middleware' => ['auth.jwt','jsonify']], function () {
    // User
    Route::get('users', 'Api\UserCtrl@index');
    Route::get('user/{id}', 'Api\UserCtrl@show');

    // Upload Services
    Route::post('upload', 'Api\UploadCtrl@single_upload');

    // Product
    Route::get('products', 'Api\ProductCtrl@index');
    Route::get('product/{id}', 'Api\ProductCtrl@show');
    Route::post('product/add', 'Api\ProductCtrl@store');
    Route::put('product/edit/{id}', 'Api\ProductCtrl@update');
    Route::delete('product/{id}', 'Api\ProductCtrl@destroy');
    
    // Brands
    Route::get('brands', 'Api\BrandCtrl@index');
    Route::get('brand/{id}', 'Api\BrandCtrl@show');
    Route::get('search_brand', 'Api\BrandCtrl@search');
    Route::post('brand/add', 'Api\BrandCtrl@store');
    Route::put('brand/edit/{id}', 'Api\BrandCtrl@update');
    Route::delete('brand/{id}', 'Api\BrandCtrl@destroy');

    // Category
    Route::get('categories', 'Api\CategoryCtrl@index');
    Route::get('category/{id}', 'Api\CategoryCtrl@show');
    Route::post('category/add', 'Api\CategoryCtrl@store');
    Route::put('category/edit/{id}', 'Api\CategoryCtrl@update');
    Route::delete('category/{id}', 'Api\CategoryCtrl@destroy');

    // Subcategory
    Route::get('subcategories', 'Api\SubCategoryCtrl@index');
    Route::get('subcategory/{id}', 'Api\SubCategoryCtrl@show');
    Route::post('subcategory/add', 'Api\SubCategoryCtrl@store');
    Route::put('subcategory/edit/{id}', 'Api\SubCategoryCtrl@update');
    Route::delete('subcategory/{id}', 'Api\SubCategoryCtrl@destroy');

    // Flashdeal
    Route::get('flashdeals', 'Api\FlashDealCtrl@index');
    Route::get('flashdeal/{id}', 'Api\FlashDealCtrl@show');
    Route::get('flashdeal_products', 'Api\FlashDealCtrl@get_all_flashdeal_product');
    Route::get('flashdeal_product/{id}', 'Api\FlashDealCtrl@get_flashdeal_prouduct_by_id');
    Route::post('flashdeal/add', 'Api\FlashDealCtrl@store');
    Route::put('flashdeal/edit/{id}', 'Api\FlashDealCtrl@update');
    Route::delete('flashdeal/{id}', 'Api\FlashDealCtrl@destroy');

    // Order
    Route::get('orders', 'Api\OrderCtrl@index');
    Route::get('order/{id}', 'Api\OrderCtrl@show');
    Route::post('order/add', 'Api\OrderCtrl@store');

});

// Pushy
Route::get('pushy_token', 'Api\PushyCtrl@index');
Route::post('pushy_token/register/device', 'Api\PushyCtrl@store');