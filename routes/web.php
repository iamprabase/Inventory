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
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('brands', 'BrandController');
    Route::resource('categories', 'CategoryController');
    Route::resource('products', 'ProductController');
  });

});
