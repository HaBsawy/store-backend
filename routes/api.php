<?php

use Illuminate\Support\Facades\Route;

/*
 * Auth
 */
Route::group(['namespace' => 'Auth'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('forgetPassword', 'AuthController@forgetPassword');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('resendWelcomeMail', 'AuthController@resendWelcomeMail');
        Route::post('resetPassword/{token}', 'AuthController@resetPassword');
        Route::get('verify/{token}', 'AuthController@verify');
    });
});

Route::group(['middleware' => 'auth:api'], function () {

    /*
     * Home
     */
    Route::get('/home', 'HomeController@index');

    /*
     * Suppliers
     */
    Route::group(['prefix' => 'suppliers'], function () {
        Route::get('', 'SupplierController@index');
        Route::post('', 'SupplierController@store');
        Route::get('{id}', 'SupplierController@show');
        Route::put('{id}', 'SupplierController@update');
        Route::delete('{id}', 'SupplierController@delete');
    });

    /*
     * Clients
     */
    Route::group(['prefix' => 'clients'], function () {
        Route::get('', 'ClientController@index');
        Route::post('', 'ClientController@store');
        Route::get('{id}', 'ClientController@show');
        Route::put('{id}', 'ClientController@update');
        Route::delete('{id}', 'ClientController@delete');
    });

    /*
     * Categories
     */
    Route::group(['prefix' => 'categories'], function () {
        Route::get('', 'CategoryController@index');
        Route::post('', 'CategoryController@store');
        Route::put('{id}', 'CategoryController@update');
        Route::delete('{id}', 'CategoryController@delete');
    });

    /*
     * Products
     */
    Route::group(['prefix' => 'products'], function () {
        Route::get('', 'ProductController@index');
        Route::post('', 'ProductController@store');
        Route::get('{id}', 'ProductController@show');
        Route::put('{id}', 'ProductController@update');
        Route::delete('{id}', 'ProductController@delete');
    });

    /*
     * Purchases
     */
    Route::group(['prefix' => 'purchases'], function () {
        Route::get('', 'PurchaseController@index');
        Route::post('', 'PurchaseController@store');
        Route::get('{id}', 'PurchaseController@show');
        Route::put('{id}', 'PurchaseController@update');
        Route::delete('{id}', 'PurchaseController@delete');
    });

    /*
     * Sales
     */
    Route::group(['prefix' => 'sales'], function () {
        Route::get('', 'SaleController@index');
        Route::post('', 'SaleController@store');
        Route::get('{id}', 'SaleController@show');
        Route::put('{id}', 'SaleController@update');
        Route::delete('{id}', 'SaleController@delete');
    });

    /*
     * Incomes
     */
    Route::group(['prefix' => 'incomes'], function () {
        Route::post('', 'IncomeController@store');
        Route::delete('{id}', 'IncomeController@delete');
    });

    /*
     * Outcomes
     */
    Route::group(['prefix' => 'outcomes'], function () {
        Route::post('', 'OutcomeController@store');
        Route::delete('{id}', 'OutcomeController@delete');
    });
});
