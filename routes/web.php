<?php

use App\Http\Controllers\V1\userController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\V1'], function() {
    Route::get('/users', userController::class);

});
*/
