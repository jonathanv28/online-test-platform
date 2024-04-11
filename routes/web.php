<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\RegisterController;

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

Route::get('/val', function () {
    return view('facevalidate', [
        'title' => 'Home | Online Test Platform',
        'active' => 'home',
    ]);
});

Route::get('/validate', [PhotosController::class, 'showForm']);
Route::post('/validate', [PhotosController::class, 'submitForm']);
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/register', [UsersController::class, 'create']);
Route::post('/register', [UsersController::class, 'store']);
// Route::resource('/register', RegisterController::class);
Route::get('/', [IndexController::class, 'visitHome'])->middleware('auth');