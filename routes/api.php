<?php

use App\Http\Controllers\departmentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\positionsController;
use App\Http\Controllers\objectivesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\KpaController;
use App\Http\Controllers\KpiController;
use App\Http\Controllers\KpiScoringController;
use App\Http\Controllers\RoleController;
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




Route::group([
    'middleware' => 'api',
    //prefix' => 'api',
],
function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register']);
});



Route::group
([
    'middleware' => 'api',
    // 'prefix' => 'auth'

],
function ()
    {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/users/{paginate?}', [AuthController::class, 'getUsers']);
        Route::get('/user/{id}', [AuthController::class, 'getUserById']);
        Route::put('/user/{id}', [AuthController::class, 'UpdateUser']);
        Route::delete('/user/{id}', [AuthController::class, 'deleteUser']);
    }
);


Route::group([


],
function()
    {
        //departments endpoints
        Route::get('/department/users/{id}', [AuthController::class, 'getDepartmentMembers']);
        Route::get('/departments/{paginate?}', [departmentController::class, 'getdepartments']);
        Route::post('/departments', [departmentController::class, 'createdepartments']);
        Route::put('/departments/{id}', [departmentController::class, 'updatedepartments']);
        Route::delete('/departments/{id}',[departmentController::class,'deletedepartments'] );
        Route::get('/department/{uuid}',[departmentController::class,'getdepartmentsbyid'] );
        // jobtitle endpoints
        Route::get('/job_titles/{paginate?}', [positionsController::class, 'getpositions']);
        Route::post('/job_titles', [positionsController::class, 'createpositions']);
        Route::put('/job_titles/{id}', [positionsController::class, 'updatepositions']);
        Route::delete('/job_titles/{id}',[positionsController::class,'deletepositions'] );
        Route::get('/job_titles/{id}',[positionsController::class,'getpositionsbyid'] );
        // stratergic domains endpoints
        Route::get('/strategic_domains', [objectivesController::class, 'getstrategic_domains']);
        Route::post('/strategic_domains', [objectivesController::class, 'createstrategic_domains']);
        Route::put('/strategic_domains/{id}', [objectivesController::class,'updatestrategic_domains']);
        Route::delete('/strategic_domains/{id}',[objectivesController::class,'deletestrategic_domains']);
        Route::get('/strategic_domains/{id}',[objectivesController::class,'getStrategicDomainById']);
        // key performance areas endpoints
        Route::get('/Kpas/{paginate?}', [KpaController::class, 'getKpa']);
        Route::post('/Kpas', [KpaController::class, 'createKpa']);
        Route::put('/Kpas/{id}', [KpaController::class,'updateKpa']);
        Route::delete('/Kpas/{id}',[KpaController::class,'deleteKpa']);
        Route::get('/Kpas/{id}',[KpaController::class,'getKpabyid']);
        // key performance indicators endpoints
        Route::get('/Kpis/{paginate?}', [KpiController::class, 'getKpi']);
        Route::post('/Kpis', [KpiController::class, 'createKpi']);
        Route::put('/Kpis/{id}', [KpiController::class,'updateKpi']);
        Route::delete('/Kpis/{id}',[KpiController::class,'deleteKpi']);
        Route::get('/Kpi/{id}',[KpiController::class,'getKpibyid']);
        // key performance indicatoras scoring
        Route::get('/Kpis/scoring/{paginate?}', [KpiScoringController::class, 'getKpiScoring']);
        Route::post('/Kpis/{id}/scoring', [KpiScoringController::class, 'updateKpiScoring']);
        Route::put('/Kpis/{id}/scoring', [KpiScoringController::class,'updateKpisScoring']);
        Route::delete('/Kpis/{id}/scoring',[KpiScoringController::class,'deleteKpiScoring']);
        Route::get('/Kpis/{id}/scoring',[KpiScoringController::class, 'getKpiScoringbyid']);

        // feedbacks endpoints
        Route::get('/Kpis/feedback/{paginate?} ', [FeedbackController::class, 'getfeedback']);
        Route::post('/Kpis/{id}/feedback ', [FeedbackController::class, 'createfeedback']);
        Route::put('/Kpis/{id}/feedback ', [FeedbackController::class,'updatefeedback']);
        Route::delete('/Kpis/{id}/feedback ',[FeedbackController::class,'deletefeedback']);
        Route::get('/Kpis/{id}/feedback', [FeedbackController::class, 'getfeedbackbyKpiid']);
        //password reset endpoints

        Route::post('/forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
        Route::post('/reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
        // manager endpoints
        Route::get('/user/{id}/manager', [departmentController::class, 'getmanager'])->name('manager');
        Route::get('/user/manager/{id}', [departmentController::class, 'getdirectreports'])->name('managerReport');
        // Roles endpoint
        Route::get('/Roles/{paginate?}', [RoleController::class, 'getRoles']);
        Route::post('/Role', [RoleController::class, 'createRole']);
        Route::put('/Role/{id}', [RoleController::class,'updateRole']);
        Route::delete('/Role/{id}',[RoleController::class,'deleteRole']);
        Route::get('/Role/{id}',[RoleController::class,'getRolebyid']);
    }
);


