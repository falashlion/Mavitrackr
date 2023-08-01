<?php

use App\Http\Controllers\departmentController;
use App\Http\Controllers\positionsController;
use App\Http\Controllers\objectivesController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
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
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile',[AuthController::class,  'userProfile']);
    Route::get('/user/{id}', [AuthController::class, 'getusersbyid']);

    //useraccount endpoints
    //Route::get('/user', [AuthController::class, 'getusers']);
});

Route::group([
    'middleware' => 'api',
], function(){
Route::get('/user', [AuthController::class, 'getusers']);
Route::get('/user/{id}', [AuthController::class, 'getusersbyid']);
Route::get('/departments/{id}/manager', [departmentController::class, 'getmanagerbyid']);
});


//departments endpoints

Route::group([
    'middleware' => 'api',
], function(){
Route::get('/departments', [departmentController::class, 'getdepartments']);
Route::post('/departments', [departmentController::class, 'createdepartments']);
Route::put('/departments/{id}', [departmentController::class, 'updatedepartments']);
Route::delete('/departments/{id}',[departmentController::class,'deletedepartments'] );
Route::get('/departments/{id}',[departmentController::class,'getdepartmentsbyid'] );
// jobtitle endpoints
Route::get('/job_titles', [positionsController::class, 'getpositions']);
Route::post('/job_titles', [positionsController::class, 'createpositions']);
Route::put('/job_titles/{id}', [positionsController::class, 'updatepositions']);
Route::delete('/job_titles/{id}',[positionsController::class,'deletepositions'] );
// stratergic domains endpoints
Route::get('/strategic_domains', [objectivesController::class, 'getstrategic_domains']);
Route::post('/strategic_domains', [objectivesController::class, 'createstrategic_domains']);
Route::put('/strategic_domains/{id}', [objectivesController::class,'updatestrategic_domains']);
Route::delete('/strategic_domains/{id}',[objectivesController::class,'deletestrategic_domains']);
Route::get('/strategic_domains/{id}',[objectivesController::class,'getdepartmentsbyid']);
// key performance areas endpoints

Route::get('/Kpas', [objectivesController::class, 'getKpa']);
Route::post('/Kpas', [objectivesController::class, 'createKpa']);
Route::put('/Kpas/{id}', [objectivesController::class,'updateKpa']);
Route::delete('/Kpas/{id}',[objectivesController::class,'deleteKpa']);
Route::get('/Kpas/{id}',[objectivesController::class,'getKpabyid']);
// key performance indicators endpoints

Route::get('/Kpis', [objectivesController::class, 'getKpi']);
Route::post('/Kpis', [objectivesController::class, 'createKpi']);
Route::put('/Kpis/{id}', [objectivesController::class,'updateKpi']);
Route::delete('/Kpis/{id}',[objectivesController::class,'deleteKpi']);

// key performance indicatoras scoring

Route::get('/Kpis/scoring ', [objectivesController::class, 'getKpiscore']);
Route::post('/Kpis/scoring ', [objectivesController::class, 'createKpiscore']);
Route::put('/Kpis/{id}/scoring ', [objectivesController::class,'updateKpiscore']);
Route::delete('/Kpis/{id}/scoring ',[objectivesController::class,'deleteKpiscore']);
Route::get('/Kpis/{id}/scoring ',[objectivesController::class, 'getKpibyid']);

// feedbacks endpoints
Route::get('/Kpis/feedback ', [objectivesController::class, 'getfeedback']);
Route::post('/Kpis/{id}/feedback ', [objectivesController::class, 'createfeedback']);
Route::put('/Kpis/{id}/feedback ', [objectivesController::class,'updatefeedback']);
Route::delete('/Kpis/{id}/feedback ',[objectivesController::class,'deletefeedback']);

});
