<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

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
View::addExtension('html','blade');



Route::get('/', function()
{
    return View::make('home/home');
});

Route::get('/token', function()
{
    return View::make('apitoken/apitoken');
});


Route::get('/register', function()
{
    return View::make('register/register');
});