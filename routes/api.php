<?php

use App\Http\Controllers\departmentController;
use App\Http\Controllers\AuthController;
use App\Models\departments;
use Illuminate\Http\Request;
use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::group(['prefix' =>'V1', 'middleware' => 'api'], function () {
//     Route::get('/users', [userController::class, 'index']);
//     Route::post('/register',[userController::class, 'register']);


Route::group([
    'middleware' => 'api',
    //prefix' => 'api',
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);

    //useraccount endpoints
    //Route::get('/user', [AuthController::class, 'getusers']);
});

Route::group([
    'middleware' => 'api',
], function(){
Route::get('/user', [AuthController::class, 'getusers']);
});


//departments endpoints

Route::group([
    'middleware' => 'api',
], function(){
Route::get('/departments', [departmentController::class, 'getdepartments']);
Route::post('/departments', [departmentController::class, 'createdepartments']);
});
