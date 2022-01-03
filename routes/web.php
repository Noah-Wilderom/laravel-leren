<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Post;
use App\Models\Country;
use App\Models\Photo;

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
Route::resource('/post', '\App\Http\Controllers\PostController');

Route::get('/contact', '\App\Http\Controllers\PostController@contact');

Route::get('/posts/{id}', '\App\Http\Controllers\PostController@showPost');


/* 
============================
= Database Raw SQL Queries =
============================
*/

// Route::get('/delete/{id}', function ($id) {
//     DB::delete("DELETE FROM posts WHERE id= :id", [$id]);
// });

// Route::get('/update', function () {
//     DB::update('UPDATE posts SET title= "updateded title" WHERE id = :id', [6]);
// });

// Route::get('/read/{id}', function ($id) {
//     $results = DB::select('SELECT * FROM posts WHERE id= :id', [$id]);
//     foreach($results as $row) {
//         echo "title: " . $row->title . "<br>"; 
//         echo "content: " . $row->body . "<br>"; 
//         echo "creator: " . $row->creator . "<br><br>"; 
//     }
// });

// Route::get('/insert/{title}/{creator}', function($title, $creator) {

// DB::insert('INSERT INTO posts (title, body, creator) VALUES (:title, :body, :creator)', [$title, "LaravelDev", $creator]);

// });

/* 
============================
= ELOQUENT (ORM) =
============================
*/
Route::get('/find', function () {

    $posts = Post::find(7);

    return $posts->title;
    // foreach($posts as $post) {
    //     echo $post->title . "<br>";
    // }
});

Route::get('/findwhere', function () {
    $posts = Post::where('id', 8)->orderBy('id', 'desc')->take(1)->get();
    return $posts;
});

Route::get('/findmore', function () {
    $posts = Post::findOrFail(1);

    return $posts;
});

Route::get('/where', function () {
    $posts = Post::where('users_count', '<', 50)->firstOrFail();
});

Route::get('/basicinsert', function () {
    $post = new Post;

    $post->title = 'new ORM title';
    $post->body = 'Testing Eloquent';
    $post->creator = 'NoahDev';
    return $post->save();

});


// vind de id, en update
Route::get('/basicinsert2', function () {
    $post = Post::find(8);

    $post->title = 'new ORM title 2';
    $post->body = 'Testing Eloquent 2';
    $post->creator = 'NoahDev';
    $post->save();

});

// Als je de $fillables niet zet in de model dan krijg je een error MassAssignmentException
// Zodra de $fillables in de model staan dan kag dit wel
Route::get('/create', function() {
    Post::create(['title' => 'Create method testing', 'body' => 'testing the /create']);
});


Route::get('/update', function() {
    Post::where('id', 7)->where('is_admin', 0)->update(['title' => 'New update method testing', 'body' => 'testing update method', 'creator' => 'NoahDev']);
});

Route::get('/delete', function() {
    $post = Post::find(7);
    $post->delete();
});

Route::get('/delete2', function() {
    Post::destroy([9, 12]);
});

Route::get('/softdelete', function() {
    Post::find(16)->delete();
});

Route::get('/readsoftdelete', function() {
    return Post::onlyTrashed()->get();
});

Route::get('/restoresoftdelete', function() {
    return Post::withTrashed()->restore();;
});

Route::get('/forcedelete', function() {
    Post::onlyTrashed()->where('id', 16)->forceDelete();
});


// =======================
// Eloquent relationships
// =======================
// 
Route::get('/user/{id}/post', function($id) { 
    return User::find($id)->post;
});
// Inversed relationship
Route::get('/post/{id}/user', function($id) {
    return Post::find($id)->user->name;
});

Route::get('/posts', function () {
    $user = User::find(1);
    foreach($user->posts as $post) {
       echo $post->title . "<br>"; 
    }
});
// Pivot
Route::get('/user/{id}/role', function($id) {
    return User::find($id)->roles;
});


// Accesing the intermediate table / pivot
Route::get('/user/pivot', function () {
    $user = User::find(1);

    foreach($user->roles as $role) {
        echo $role->pivot->created_at . "<br>";
    }
});

Route::get('/user/country', function() {
    $country = Country::find(1);
    foreach($country->posts as $post) {
        return $post->title;
    }
});


// ===============
//   Polymorphic
// ===============

Route::get('/user/photos/{id}', function($id) {
    $post = Post::find($id);
    // $user = User::find($id);

    foreach($post->photos as $photo) {
        echo $photo->path . "<br>";
    }
});

Route::get('photo/{id}/post', function($id) {
    $photo = Photo::findOrFail($id);
    $imageable = $photo->imageable;
    return $imageable;
}); 
