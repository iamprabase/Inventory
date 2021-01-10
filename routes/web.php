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

Route::get('/', 'LandingPageController@index')->name('welcome');

Route::get('artisan-migrate', function(){
  \Artisan::call('migrate');
});
Route::get('artisan-seed', function(){
  \Artisan::call("db:seed"); 
});

Route::group(['prefix' => '', 'namespace' => 'Admin'], function () {
  Route::name('admin.')->group( function () {
    Auth::routes(['register' => true]);
    Route::group(['middleware' => 'auth:admins'], function () {
      Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
      Route::resource('brands', 'BrandController');
      Route::resource('categories', 'CategoryController');
      Route::resource('products', 'ProductController');
      Route::resource('suppliers', 'SupplierController')->middleware('isadmin');
      Route::resource('purchase-orders', 'PurchaseOrderController');
      Route::post('delete-purchase-orders-detail', 'PurchaseOrderController@deletePurchaseOrderDetail')->name('purchase-orders.deletePurchaseOrderDetail');
      Route::resource('locations', 'LocationController')->middleware('isadmin');
      Route::resource('stock-transfers', 'StockTransferController')->middleware('isadmin');
      Route::post('delete-stock-transfers-detail', 'StockTransferController@deleteStockTransferDetail')->name('stock-transfers.deleteStockTransferDetail')->middleware('isadmin');
      
    });
  });
});


