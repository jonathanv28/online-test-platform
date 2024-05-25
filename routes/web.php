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
use App\Http\Controllers\Admin\TestController as AdminTestController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;


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

// Route::get('/val', function () {
//     return view('form', [
//         'title' => 'Home | Online Test Platform',
//         'active' => 'home',
//     ]);
// })->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/', [IndexController::class, 'visitHome'])->name('home');
    Route::get('/profile', [UsersController::class, 'show'])->name('profile.show');
    Route::get('/validate', [PhotosController::class, 'showForm'])->name('validation.show');
    Route::post('/validate', [PhotosController::class, 'submitForm'])->name('validation.submit');
    Route::post('/tests', [ResultsController::class, 'store'])->name('tests.store');
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/tests/{test}/validate', [TestsController::class, 'validateFace'])->name('tests.validate');
    Route::get('/tests/{test}', [TestsController::class, 'show'])->name('tests.show');
    Route::post('/tests/{test}/start', [TestsController::class, 'startTest'])->name('tests.start');
    // Route::post('/submit-test', [TestsController::class, 'submit'])->name('tests.submit');
    Route::get('/tests/{test}/{questionNumber?}', [TestsController::class, 'show'])->name('tests.show');
    Route::post('/tests/{test}/submit', [TestsController::class, 'submit'])->name('tests.submit');
    Route::get('/tests/{test}/result', [TestsController::class, 'result'])->name('tests.result');
});

Route::middleware('auth:sanctum')->post('/create-token', [LoginController::class, 'createToken']);

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->middleware('throttle:10,1');
    Route::get('/register', [UsersController::class, 'create']);
    Route::post('/register', [UsersController::class, 'store']);
});

// Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
//     Route::resource('tests', Admin\TestController::class);
//     Route::resource('users', Admin\UserController::class);
// });

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'index'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'authenticate']);
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('tests', AdminTestController::class);
        Route::resource('users', AdminUserController::class);
    });
});

// Fall back route
Route::fallback(function () {
    return view('errors.404');
});