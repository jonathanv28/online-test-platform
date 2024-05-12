<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TestsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\ResultsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\FaceValidationController;


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
    return view('form', [
        'title' => 'Home | Online Test Platform',
        'active' => 'home',
    ]);
})->middleware('auth');

Route::get('/test-s3', function () {
    $filePath = 'testfile.txt';
    $contents = 'Hello, world!';
    Storage::disk('s3')->put($filePath, $contents);
    return 'File was saved to S3';
});


// Route::get('/validate', [PhotosController::class, 'showForm'])->middleware('auth');
// Route::post('/validate', [PhotosController::class, 'submitForm'])->middleware('auth');
// Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
// Route::post('/login', [LoginController::class, 'authenticate']);
// Route::post('/logout', [LoginController::class, 'logout']);
// Route::get('/register', [UsersController::class, 'create']);
// Route::post('/register', [UsersController::class, 'store']);
// // Route::resource('/register', RegisterController::class);
// Route::get('/', [IndexController::class, 'visitHome'])->middleware('auth');
// Route::post('/tests', [ResultsController::class, 'store'])->name('tests.store')->middleware('auth');
// Route::get('/profile', [UsersController::class, 'show'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/', [IndexController::class, 'visitHome']);
    Route::get('/profile', [UsersController::class, 'show'])->name('profile.show');
    Route::get('/validate', [PhotosController::class, 'showForm'])->name('validation.show');
    Route::post('/validate', [PhotosController::class, 'submitForm'])->name('validation.submit');
    Route::post('/tests', [ResultsController::class, 'store'])->name('tests.store');
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/tests/{test}/validate', [TestsController::class, 'validateFace'])->name('tests.validate');
    // Route::post('/validate-face', [FaceValidationController::class, 'validateFace']);
    Route::get('/files/{filename}', 'FileController@getFile')->name('files.get');
    // In routes/web.php
    // Route::post('/validate-face', [FaceValidationController::class, 'validateFace'])->name('validate-face');

});

Route::middleware('auth:sanctum')->post('/create-token', [LoginController::class, 'createToken']);

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->middleware('throttle:10,1');
    Route::get('/register', [UsersController::class, 'create']);
    Route::post('/register', [UsersController::class, 'store']);
});
