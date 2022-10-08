<?php

use Illuminate\Support\Facades\Route;

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
//user routes
Route::get('/', 'HomeController@index');
Route::get('/index', 'HomeController@index')->name('index');
Route::get('/category/{id}', 'BillsController@bill_category')->name('bill_category');
Route::get('/buy/{slug}', 'BillsController@get_variation')->name('get_variation');
Route::get('/buys/{slug}', 'BillsController@DataVariation')->name('data_variation')->middleware('auth');
Route::post('/purchase/{slug}', 'BillsController@initiateTransaction')->name('initiateTransaction')->middleware('auth');
Route::post('/airtime-pay', 'BillsController@airtime_pay')->name('pay-airtime')->middleware('auth');
Route::post('/verify-account', 'BillsAPI@VTpassVerify')->name('verify-account')->middleware('auth');
Route::get('/settings', 'HomeController@user_settings')->name('settings')->middleware('auth');
Route::get('/profile', 'HomeController@profile')->name('profile')->middleware('auth');
Route::resource('/carts', 'cartController');
Route::get('/transactions', 'HomeController@transactions')->name('transactions')->middleware('auth');
Route::get('/mywallet', 'HomeController@my_wallet')->name('my_wallet')->middleware('auth');
Route::post('/transfunds', 'HomeController@transfer_fund')->name('transfer-funds')->middleware('auth');
Route::get('/transdetails/{id}', 'HomeController@trans_details')->name('trans_details')->middleware('auth');
Route::get('/items/{id}', 'HomeController@product_details')->name('product-details');
Route::get('/cart/{id}', 'CartController@add')->name('carts.add');
Route::get('/myorders', 'HomeController@myOrders')->name('my-orders')->middleware('auth');
Route::get('/orderDetails/{id}', 'HomeController@orderDetails')->name('orderDetails')->middleware('auth');
Route::get('/update/cart', 'CartController@update_cart')->name('update_cart')->middleware('auth');
Route::resource('/checkout', 'checkoutController')->middleware('auth');
Route::get('/cartss/{id}', 'CartController@carts_buy')->name('carts.buy_now');
Route::get('/edit/address', 'checkoutController@shipping_address')->name('shipping_address')->middleware('auth');
Route::post('/add/address', 'checkoutController@shipping')->name('shipping')->middleware('auth');
Route::post('/payment/method', 'checkoutController@payment_method')->name('payment_method')->middleware('auth');
Route::get('/payment/cash', 'checkoutController@cash_payment')->name('cash_payment')->middleware('auth');
Route::get('/payment/bank', 'checkoutController@bank_payment')->name('bank_payment')->middleware('auth');
Route::get('/checkout/pay/success', 'checkoutController@checkout_success')->name('checkout.success')->middleware('auth');
Route::get('/verify/walletpayment/{trxref}', 'HomeController@verify')->middleware('auth');
Route::get('/verify/orderpayment/{trxref}', 'checkoutController@verify')->middleware('auth');
Route::get('/verify/billpayment/{trxref}', 'BillsController@verify')->middleware('auth');
Route::get('/user/notifications', 'HomeController@notifications')->name('notifications')->middleware('auth');
Route::get('/user/notifications/details/{id}', 'HomeController@notifications_details')->name('notify-details')->middleware('auth');
Route::get('/notification/delete/{id}', 'HomeController@notificationDel')->name('del-notify')->middleware('auth');
Route::post('/add-reviews/{id}', 'HomeController@addReview')->name('add-reviews');
Route::get('/search-results', 'HomeController@search')->name('search-results');
Route::post('/manual/top-up', 'HomeController@manual_topUp')->name('manual-topUp');
Route::get('/products/categories/{id}', 'HomeController@productCatgory')->name('product_category')->middleware('auth');
Route::get('/manual/wallet/topUp', 'HomeController@topUp')->name('topUp')->middleware('auth');
Route::post('/activat/ewallet', 'HomeController@activate_wallet')->name('activate-wallet')->middleware('auth');
Route::get('/user/changespass', 'HomeController@changepass')->name('change-pass')->middleware('auth');
Route::post('/user/changespassword', 'HomeController@changePassword')->name('change-password')->middleware('auth');
Route::get('/user/products/categories/{id}', 'HomeController@productCategory')->name('products.categories');
route::post('/user/register', 'Auth\RegisterController@create_user')->name('register_user');
Route::get('/wallet/autowallet/',  'HomeController@payant');
Route::post('/register-referral', 'Auth\RegisterController@referral')->name('referral-register');
Route::get('/referral', 'Auth\RegisterController@referrals')->name('referral');
Route::get('/users/referrals/', 'HomeController@referrals')->name('my-referrals');
Route::get('webhook', 'WebhookController@webhook')->middleware('auth');
Route::get('/users/initiate/webhook/', 'WebhookController@initiate_pay')->middleware('auth');


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//Vendor functions 
Route::get('/shops/profile', 'vendorsController@shopsIndex')->name('shops.index')->middleware('auth');
Route::get('/shops/add_shop', 'vendorsController@add_shops')->name('add_shops')->middleware('auth');
Route::post('/shops/store', 'vendorsController@store_shops')->name('store-shops')->middleware('auth');
Route::get('/shops/sell', 'vendorsController@shop_sell')->name('shops-sell')->middleware('auth');
Route::get('/shops/subcat', 'vendorsController@getSub_cat')->name('sub-cat')->middleware('auth');
Route::post('/products/stores/', 'vendorsController@products_store')->name('products-store')->middleware('auth');
Route::get('/shops/my-products', 'vendorsController@my_products')->name('my-products')->middleware('auth');
Route::get('/shops/my-products/edit/{id}','vendorsController@my_productsEdit' )->name('my-productEdit')->middleware('auth');
Route::post('/shops/products/update/{id}', 'vendorsController@products_update')->name('products-update')->middleware('auth');
Route::get('/shops/my-products/delete/{id}','vendorsController@my_productsDelete' )->name('my-productDelete')->middleware('auth');
Route::post('/shops/vendorswith/{id}', 'vendorsController@accountSwitch')->name('accountSwitch')->middleware('auth');
Route::post('/shops/vendornotify/{id}', 'vendorsController@notifySwitch')->middleware('auth');
Route::get('/shops/vendor/myorders', 'vendorsController@vendorOrders')->name('vendor-orders')->middleware('auth');
Route::get('/shops/archiveProducts', 'vendorsController@archiveProducts')->name('archiveProducts')->middleware('auth');
Route::get('/shops/my-products/restore/{id}','vendorsController@my_productsRestore' )->name('my-productRestore');
Route::get('/shops/settlements/', 'vendorsController@payment_settlement')->name('payment-settlement')->middleware('auth');
Route::get('/shops/settlements/details/{id}', 'vendorsController@settlementDetails')->name('settlement-details')->middleware('auth');
Route::post('/shops/settlement/confirm/{id}', 'vendorsController@confirm_settlement')->name('confirm-settlement')->middleware('auth');
Route::get('/shops/vendororderDetails/{id}', 'vendorsController@VendorsorderDetails')->name('vendorsorderDetails')->middleware('auth');
Route::get('/shops/edit/shop', 'vendorsController@edit_shop')->name('edit-shop')->middleware('auth');
Route::post('/shops/update/shop', 'vendorsController@update_shops')->middleware('auth');
//super admin routes 

Route::prefix('dashboard')->group(function(){
    Route::get('/', 'Auth\AdminLoginController@Showlogin')->name('admin-login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/index', 'AdminController@index')->name('admin.index')->middleware('auth:admin');
    Route::resource('/category', 'CategoryController')->middleware('auth:admin');
    Route::post('/create_bills', 'ProductController@create_Bills')->middleware('auth:admin');
    Route::get('/bills_products', 'ProductController@bill_products')->name('bills_products')->middleware('auth:admin');
    Route::get('/bills_products/edit/{id}', 'ProductController@bills_edit')->middleware('auth:admin');
    Route::post('/bills_products/update/{id}', 'ProductController@bills_update')->middleware('auth:admin');
    Route::post('/bills_products/delete/{id}', 'ProductController@bills_delete')->middleware('auth:admin');
    Route::get('/bills_products/index', 'ProductController@bills_products_index')->name('bills.products.index')->middleware('auth:admin');
    Route::get('/bill_category/edit/{id}', 'CategoryController@bill_edit')->middleware('auth:admin');
    Route::post('/bill_category/update/{id}', 'CategoryController@bill_update')->middleware('auth:admin');
    Route::post('/bill_category/destroy/{id}', 'CategoryController@bill_destroy')->middleware('auth:admin');
     Route::get('/bills_categories', 'CategoryController@bills_categories')->name('bills.categories')->middleware('auth:admin');
     Route::post('/bills_category/store', 'CategoryController@bills_store')->middleware('auth:admin');
    Route::get('/bills_category', 'CategoryController@bills_category')->name('category.bills')->middleware('auth:admin');
    Route::get('/sub-category', 'CategoryController@sub')->name('category.sub-category')->middleware('auth:admin');
    Route::get('/edit-sub/{id}', 'CategoryController@edit_sub')->name('category.edit-sub')->middleware('auth:admin');
    Route::delete('/delete/{id}', 'CategoryController@delete')->name('category.sub-category-delete')->middleware('auth:admin');
    Route::resource('/products', 'ProductController')->middleware('auth:admin');
    Route::get('/createBills_products', 'ProductController@createBills')->name('bills-products')->middleware('auth:admin');
    Route::get('/orders', 'AdminController@orders')->name('admin.orders')->middleware('auth:admin');
    Route::get('/approve-pay/{id}', 'AdminController@approvePay')->middleware('auth:admin');
    Route::get('/approve-delivery/{id}', 'AdminController@approveDelivery')->middleware('auth:admin');
    Route::get('/transactions', 'AdminController@transaction')->name('admin.transaction')->middleware('auth:admin');
    Route::get('/users', 'AdminController@users')->name('admin.users')->middleware('auth:admin');
    Route::post('/users-transaction/{id}', 'AdminController@viewTrans')->name('admin.users-trans')->middleware('auth:admin');
    Route::post('/users-orders/{id}', 'AdminController@viewOrders')->name('admin.user-orders')->middleware('auth:admin');
    Route::get('/users/notify', 'AdminController@notify')->name('admin.notify')->middleware('auth:admin');
    Route::post('/users/notification', 'AdminController@push_notify')->name('admin.notification')->middleware('auth:admin');
    Route::get('/fund-request', 'AdminController@fund_request')->name('fund-request')->middleware('auth:admin');
    Route::post('/fund-request/approval/{id}', 'AdminController@approve_request')->middleware('auth:admin');
    Route::get('/activation-request', 'AdminController@activation_request')->name('activation-request')->middleware('auth:admin');
    Route::post('/wallet-activation/approval/{id}', 'AdminController@wallet_activation')->middleware('auth:admin');
    Route::post('/blockUser/{id}', 'AdminController@blockUser')->middleware('auth:admin');
    Route::get('/bills/transactions/', 'AdminController@bill_transactions')->name('users_bill_transactions')->middleware('auth:admin');
    Route::post('/bill/transaction/{id}', 'AdminController@bill_transaction')->name('user_bill_transactions')->middleware('auth:admin');
    Route::get('/users/settlements', 'AdminController@users_settlement')->name('users_settlements')->middleware('auth:admin');
    Route::post('/users/settlment/confirm/{id}', 'AdminController@confirm_settle')->middleware('auth:admin');
    Route::get('/order/details/{id}', 'AdminController@orderDetails')->name('Admin.orderDetails')->middleware('auth:admin');
});