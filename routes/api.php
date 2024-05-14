<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaceValidationController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/validate-face', [FaceValidationController::class, 'validateFace'])
//      ->middleware('auth'); // or just 'auth' if using session-based auth

Route::middleware('auth:sanctum')->post('validate-face', [FaceValidationController::class, 'validateFace']);