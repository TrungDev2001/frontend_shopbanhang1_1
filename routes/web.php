<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\VNPAYController;


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

Route::get('/', 'HomeController@index')->name('home.index');

Route::prefix('/')->group(function () {
    Route::get('/category/{slug}/{id}', [
        'as' => 'categoryProduct.shop',
        'uses' => 'ShopController@index'
    ]);
    Route::get('/brand/{id}', [
        'as' => 'brandProduct.shop',
        'uses' => 'ShopController@brand'
    ]);
});
// Route::get('/product/detail/{id}/{slug}', [
//     'as' => 'ProductDetail',
//     'uses' => 'ProductDetailController@index'
// ]);

Route::prefix('product')->group(function () {
    Route::get('/tag/{slug}', [
        'as' => 'product.tagProducts',
        'uses' => 'ProductDetailController@tagProducts'
    ]);
    Route::get('/detail/{id}/{slug}', [
        'as' => 'ProductDetail',
        'uses' => 'ProductDetailController@index'
    ]);
    Route::post('rating-star', [
        'as' => 'ProductDetail.rating_star',
        'uses' => 'ProductDetailController@rating_star',
    ]);
    Route::get('getRatedStar', [
        'as' => 'ProductDetail.getRatedStar',
        'uses' => 'ProductDetailController@getRatedStar',
    ]);
    Route::get('getRatedStarUserAuth', [
        'as' => 'ProductDetail.getRatedStarUserAuth',
        'uses' => 'ProductDetailController@getRatedStarUserAuth',
    ]);
    Route::post('addComment', [
        'as' => 'ProductDetail.addComment',
        'uses' => 'ProductDetailController@addComment',
    ]);
    Route::post('addCommentReply', [
        'as' => 'ProductDetail.addCommentReply',
        'uses' => 'ProductDetailController@addCommentReply',
    ]);
    Route::post('LoginAndComment', [
        'as' => 'ProductDetail.LoginAndComment',
        'uses' => 'ProductDetailController@LoginAndComment',
    ]);
    Route::get('GetComment/{id}', [
        'as' => 'CommentController.index',
        'uses' => 'CommentController@index',
    ]);
    Route::get('get_comment_childent/{id}', [
        'as' => 'CommentController.get_comment_childent',
        'uses' => 'CommentController@get_comment_childent',
    ]);
});
Route::prefix('home')->group(function () {
    Route::get('/search', [
        'as' => 'home.header.search_product',
        'uses' => 'HomeController@search_product'
    ]);
    Route::post('/search/result', [
        'as' => 'home.header.search_product_result',
        'uses' => 'HomeController@search_product_result'
    ]);
    Route::get('wishlist', [
        'as' => 'home.header.wishlist',
        'uses' => 'HomeController@wishlist'
    ]);
    Route::get('/bought', [
        'as' => 'home.header.bought',
        'uses' => 'HomeController@bought',
        'middleware' => 'CheckLogin'
    ]);
    Route::get('/bought/show/{id}', [
        'as' => 'home.header.show_bought',
        'uses' => 'HomeController@show_bought',
        'middleware' => 'CheckLogin'
    ]);
    Route::delete('/bought/delete/{id}', [
        'as' => 'home.header.delete_bought',
        'uses' => 'HomeController@delete_bought',
        'middleware' => 'CheckLogin'
    ]);
});
Route::prefix('shop')->group(function () {
    Route::get('/video', [
        'as' => 'home.video.index',
        'uses' => 'HomeController@videoIndex'
    ]);
    Route::get('/video/{slug}', [
        'as' => 'home.video.play',
        'uses' => 'HomeController@videoPlay'
    ]);
});

Route::prefix('Cart')->group(function () {
    Route::get('/', [
        'as' => 'cart.index',
        'uses' => 'CartController@index',
    ]);
    Route::post('/product/add_to_cart/{id}', [
        'as' => 'add_to_cart.index',
        'uses' => 'CartController@add_to_cart'
    ]);
    Route::get('/product/show_cart', [
        'as' => 'cart.show_cart',
        'uses' => 'CartController@show_cart',
    ]);
    Route::post('/product/update_cart/{id}', [
        'as' => 'cart.update_cart',
        'uses' => 'CartController@update_cart'
    ]);
    Route::delete('/product/delete_cart/{id}', [
        'as' => 'cart.delete_cart',
        'uses' => 'CartController@delete_cart'
    ]);
    Route::get('/product/checkout', [
        'as' => 'cart.checkout',
        'uses' => 'CartController@checkout',
        'middleware' => 'CheckLogin'
    ]);
    Route::post('/product/payment', [
        'as' => 'cart.payment',
        'uses' => 'CartController@payment',
        'middleware' => 'CheckLogin'
    ]);
    Route::get('/product/paymentSuccess', [
        'as' => 'cart.paymentSuccess',
        'uses' => 'CartController@paymentSuccess',
        'middleware' => 'CheckLogin'
    ]);
    Route::get('/product/SentMailSuccess', [
        'as' => 'cart.SentMailSuccess',
        'uses' => 'CartController@SentMailSuccess',
        'middleware' => 'CheckLogin'
    ]);
    Route::post('/product/Card/CouponCode', [
        'uses' => 'CartController@coupon_code'
    ]);
    //Lấy địa chỉ
    Route::get('/product/fecthAddress', [
        'as' => 'cart.fecthAddress',
        'uses' => 'CartController@fecthAddress'
    ]);
    //Lấy phí ship
    Route::get('/product/fetchPriceShip', [
        'as' => 'cart.fetchPriceShip',
        'uses' => 'CartController@fetchPriceShip'
    ]);
});
// Thanh toán paypal
Route::get('create-transaction', [PayPalController::class, 'createTransaction'])->name('createTransaction');
Route::get('process-transaction', [PayPalController::class, 'processTransaction'])->name('processTransaction');
Route::get('success-transaction', [PayPalController::class, 'successTransaction'])->name('successTransaction');
Route::get('cancel-transaction', [PayPalController::class, 'cancelTransaction'])->name('cancelTransaction');
// Thanh toán VNPAY
Route::post('VNPAY-transaction', [VNPAYController::class, 'processVNPAY'])->name('processVNPAY');
Route::get('vnpay_php/vnpay_return', [VNPAYController::class, 'vnpay_return'])->name('vnpay_return');


Route::prefix('blog')->group(function () {
    Route::get('/', [
        'as' => 'blog.index',
        'uses' => 'BlogController@index'
    ]);
    Route::get('/{id}/{slug}', [
        'as' => 'blog.show',
        'uses' => 'BlogController@show'
    ]);
    Route::get('detail/{id}/{slug}', [
        'as' => 'blog.detail',
        'uses' => 'BlogController@detail'
    ]);
    Route::get('/tag/{id}/{tagName}', [
        'as' => 'blog.tag',
        'uses' => 'BlogController@postTag',
    ]);
});
Route::prefix('contact')->group(function () {
    Route::get('/', [
        'as' => 'contact.index',
        'uses' => 'ContactController@index'
    ]);
    Route::post('/store', [
        'as' => 'contact.store',
        'uses' => 'ContactController@store'
    ]);
});
Route::prefix('authentication')->group(function () {
    Route::get('/', [
        'as' => 'login.index',
        'uses' => 'AuthenticationController@index'
    ]);
    Route::post('/login', [
        'as' => 'login',
        'uses' => 'AuthenticationController@login'
    ]);
    Route::post('/register', [
        'as' => 'register',
        'uses' => 'AuthenticationController@register'
    ]);
    Route::get('/logout', [
        'as' => 'logout',
        'uses' => 'AuthenticationController@logout'
    ]);
});
