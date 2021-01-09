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

Route::group(['prefix' => '', 'namespace' => 'Admin'], function () {
  Route::name('admin.')->group( function () {
    Auth::routes(['register' => false]);
    Route::group(['middleware' => 'auth:admins'], function () {
      Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
      Route::resource('brands', 'BrandController');
      Route::resource('categories', 'CategoryController');
      Route::resource('products', 'ProductController');
      Route::resource('suppliers', 'SupplierController');
      Route::resource('purchase-orders', 'PurchaseOrderController');
      Route::post('delete-purchase-orders-detail', 'PurchaseOrderController@deletePurchaseOrderDetail')->name('purchase-orders.deletePurchaseOrderDetail');
      Route::resource('locations', 'LocationController');
      Route::resource('stock-transfers', 'StockTransferController');
      Route::post('delete-purchase-orders-detail', 'StockTransferController@deleteStockTransferDetail')->name('stock-transfers.deleteStockTransferDetail');
      
    });
  });
});

