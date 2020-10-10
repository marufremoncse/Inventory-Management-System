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



Auth::routes();

Route::group(['middleware'=>'auth'],function() {
    Route::resource('/user','UserController');
    Route::resource('/product','ProductController');
    Route::resource('/customer','CustomerController');
    Route::resource('/supplier','SupplierController');
    Route::resource('/sale','SaleController');
    Route::resource('/purchase','PurchaseController');
    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
    Route::get('/', 'HomeController@index');
    Route::get('/report/sale-report','SaleReportController@index')->name('sale-report');
    Route::get('/report/sale-report/daily-sale','SaleReportController@daily_sale')->name('daily-sale');
    Route::get('/report/sale-report/daily-sale/{date}','SaleReportController@daily_sale_details')->name('daily-sale-details');
    Route::get('/report/sale-report/monthly-sale','SaleReportController@monthly_sale')->name('monthly-sale');
    Route::get('/report/sale-report/monthly-sale/{year}/{month}','SaleReportController@monthly_sale_details')->name('monthly-sale-details');
    Route::get('/report/sale-report/yearly-sale','SaleReportController@yearly_sale')->name('yearly-sale');
    Route::get('/report/sale-report/monthly-sale/{year}','SaleReportController@yearly_sale_details')->name('yearly-sale-details');

    Route::get('/report/purchase-report','PurchaseReportController@index')->name('purchase-report');
    Route::get('/report/purchase-report/daily-purchase','PurchaseReportController@daily_purchase')->name('daily-purchase');
    Route::get('/report/purchase-report/daily-purchase/{date}','PurchaseReportController@daily_purchase_details')->name('daily-purchase-details');
    Route::get('/report/purchase-report/monthly-purchase','PurchaseReportController@monthly_purchase')->name('monthly-purchase');
    Route::get('/report/purchase-report/monthly-purchase/{year}/{month}','PurchaseReportController@monthly_purchase_details')->name('monthly-purchase-details');
    Route::get('/report/purchase-report/yearly-purchase','PurchaseReportController@yearly_purchase')->name('yearly-purchase');
    Route::get('/report/purchase-report/monthly-purchase/{year}','PurchaseReportController@yearly_purchase_details')->name('yearly-purchase-details');
});
