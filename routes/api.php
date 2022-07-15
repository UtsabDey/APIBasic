<?php

use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/test', [TestController::class, 'index']);
Route::get('/teachers/{id?}', [TeacherController::class, 'index']);
Route::post('/add-teacher', [TeacherController::class, 'store']);
Route::post('/add-multiteacher', [TeacherController::class, 'storeMulti']);
Route::put('/teacher/{id}', [TeacherController::class, 'update']);
Route::delete('/teacher/{id}', [TeacherController::class, 'destroy']);

Route::post('/upload', [TeacherController::class, 'uploadImage']);