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
        Route::get('/users', [AuthController::class, 'getAllUsers']);
        Route::get('/user/{id}', [AuthController::class, 'getUserById']);
        Route::post('/user/{id}', [AuthController::class, 'updateUserDetails']);
        Route::delete('/user/{id}', [AuthController::class, 'deleteUser']);

    }
);


Route::
// middleware('jwt.auth')
group([],
function()
    {
        Route::get('users/reports',[AuthController::class,'getAllDirectReportsForUser']);
        //departments endpoints
        Route::get('/departments', [departmentController::class, 'getAllDepartments']);
        Route::post('/department', [departmentController::class, 'createNewDepartment']);
        Route::put('/department/{id}', [departmentController::class, 'updateDepartmentDetails']);
        Route::delete('/department/{id}',[departmentController::class,'deleteDepartmentDetails'] );
        Route::get('/department/{id}',[departmentController::class,'getdepartmentsbyid'] );
        Route::get('department/members/{id}',[departmentController::class,'getDepartmentMembers']);
        // jobtitle endpoints
        Route::get('/job_titles', [positionsController::class, 'getPositions']);
        Route::post('/job_title', [positionsController::class, 'createPositions']);
        Route::put('/job_title/{id}', [positionsController::class, 'updatePositions']);
        Route::delete('/job_title/{id}',[positionsController::class,'deletePositions'] );
        Route::get('/job_title/{id}',[positionsController::class,'getPositionsbyid'] );
        // stratergic domains endpoints
        Route::get('/strategic_domains', [objectivesController::class, 'getStrategicDomains']);
        Route::post('/strategic_domain', [objectivesController::class, 'createStrategicDomain']);
        Route::put('/strategic_domain/{id}', [objectivesController::class,'updateStrategicDomain']);
        Route::delete('/strategic_domain/{id}',[objectivesController::class,'deleteStrategicDomain']);
        Route::get('/strategic_domain/{id}',[objectivesController::class,'getStrategicDomainById']);
        // key performance areas endpoints
        Route::get('/Kpas', [KpaController::class, 'getAllKpa']);
        Route::post('/Kpa', [KpaController::class, 'createKpa']);
        Route::put('/Kpa/{id}', [KpaController::class,'updateKpa']);
        Route::delete('/Kpa/{id}',[KpaController::class,'deleteKpa']);
        Route::get('/Kpa/{id}',[KpaController::class,'getKpaById']);
        // key performance indicators endpoints
        Route::get('/Kpis', [KpiController::class, 'getAllKpis']);
        Route::post('/Kpi', [KpiController::class, 'createKpi']);
        Route::put('/Kpi/{id}', [KpiController::class,'updateKpi']);
        Route::delete('/Kpi/{id}',[KpiController::class,'deleteKpi']);
        Route::get('/Kpi/{id}',[KpiController::class,'getKpiById']);
        Route::get('/Kpis/reports',[KpiController::class,'getKpisForAllDirectReports']);
        Route::get('Kpi/weight/{id}',[KpiController::class,'createKpiWeight']);
        Route::get('Kpi/score/{id}',[KpiController::class,'createKpiScore']);
        Route::get('/Kpis/user/{id}',[KpiController::class,'getKpiByUserId']);
        // key performance indicators scoring
        Route::get('/Kpis/scoring/', [KpiScoringController::class, 'getKpiScoring']);
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
        // Roles endpoint
        Route::get('/Roles', [RoleController::class, 'getRoles']);
        Route::post('/Role', [RoleController::class, 'createRole']);
        Route::put('/Role/{id}', [RoleController::class,'updateRole']);
        Route::delete('/Role/{id}',[RoleController::class,'deleteRole']);
        Route::get('/Role/{id}',[RoleController::class,'getRolebyid']);
    }
);


