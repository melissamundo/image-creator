<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Image\ImageController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Session;

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


/* Vista de login y logout */
Route::get('/', function () {
    return view('auth.login');
})->name('home');
Route::get('/info', function () {
    echo phpinfo();
})->name('info');
Route::get('/logout', function () {
    Session::put('session_login', "0000");
    return view('auth.login');
})->name('logout');

Route::get('/image-form', function () {
    if(Session::get('session_login') == "1234"){
        return view('image.image-form',['url' => config('app.url')."/images/"]);
    }
    return view('auth.login');
})->name('image-form');


Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::post('/phrases', [ImageController::class, 'phrases'])->name('phrases');
Route::get('/images/{filename}', [ImageController::class, 'getImages'])->name('images');

