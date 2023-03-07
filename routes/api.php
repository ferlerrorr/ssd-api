<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

// ------------AuthController----------------
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



// ------------ProductsController----------------
//!Public Route for Search
Route::get('product/search-products/{slug}','App\Http\Controllers\ProductController@show');

Route::get('product/search-products/{generic_name}/{product}','App\Http\Controllers\ProductController@search');

Route::get('product/all-generics','App\Http\Controllers\ProductController@generics');

//!Must be Hidden/Admin Route 
Route::group(['middleware'=>'api','prefix'=>'admin'],function($router){

    Route::resource('/product/add-products', App\Http\Controllers\ProductController::class)->only([
        'store'
    ]);

    // ------------ShofipyController----------------
    Route::resource('/shopify/all-products', App\Http\Controllers\ShopifyController::class)->only([
        'index'
    ]);

   

     // ------------OrderController---------------
    Route::get('/ssd/orders','App\Http\Controllers\OrderController@index');
});


    //!Need Auth JWT-Token
    Route::group(['middleware'=>'api','prefix'=>'auth'],function($router){
    Route::post('/register',[AuthController::class,'register']);
    Route::post('/token-access',[AuthController::class,'token']);
    Route::post('/logout',[AuthController::class,'logout']);
    Route::get('/verify/{email}',[AuthController::class,'verify']);
    // Route::get('/profile',[AuthController::class,'profile']);
   
    
    // ------------SSDController---------------
    Route::get('/sdd/all-products',[App\Http\Controllers\ProductController::class,'index']);
    Route::get('/ssd/search-product/{pid}','App\Http\Controllers\ShopifyController@show');


       // ------------OrderController---------------
    Route::post('/ssd/products/order',[App\Http\Controllers\OrderController::class,'order']);
});


    


    