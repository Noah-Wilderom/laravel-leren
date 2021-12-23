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

Route::get('/', function () {
    return view('welcome');
});

// // $_GET request in laravel, bijvoorbeeld voor een productpagina of in dit geval een postpagina
// Route::get('/post/{id}', function ($id) {
//     return 'Plog post id: ' . $id;
// });

// // Geef de url een nickname om later de function route('admin.home); te gebruiken, zodat je niet de hele url hoeft uit te typen
// Route::get('/admin/posts/example', array('as' => 'admin.home', function () {
//     $url = route('admin.home');

//     return 'This url is ' . $url;
// }));

// {id} is de parameter voor de method index in \App\Http\Controllers\PostController
// Route::get('/post/{id}', '\App\Http\Controllers\PostController@index'); // 2e parameter is hoe je een controller bind aan een Route (Laravel 8.0)

// Net zoals dat je --resource in php artisan make:controller kan gebruiken kan je ook Route::resource($nickname, $controller) gebruiken om alles al een nickname en route te geven. (laravel 8.0)
Route::resource('post', '\App\Http\Controllers\PostController');

Route::get('contact', '\App\Http\Controllers\PostController@contact');

Route::get('posts/{id}', '\App\Http\Controllers\PostController@showPost');