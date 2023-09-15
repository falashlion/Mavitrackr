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
use App\Http\Controllers\RolesController;
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
        Route::get('/users/{id}', [AuthController::class, 'getUserById']);
        Route::post('/users/{id}', [AuthController::class, 'updateUserDetails']);
        Route::delete('/users/{id}', [AuthController::class, 'deleteUser']);
        Route::get('/reports/users',[AuthController::class,'getAllDirectReportsForUser']);
    }
);
Route::
group([],
function()
    {

        //departments endpoints
        Route::get('/departments', [departmentController::class, 'getAllDepartments']);
        Route::post('/departments', [departmentController::class, 'createNewDepartment']);
        Route::put('/departments/{id}', [departmentController::class, 'updateDepartmentDetails']);
        Route::delete('/departments/{id}',[departmentController::class,'deleteDepartmentDetails'] );
        Route::get('/departments/{id}',[departmentController::class,'getdepartmentsbyid'] );
        Route::get('departments/members/{id}',[departmentController::class,'getDepartmentMembers']);
        // jobtitle endpoints
        Route::get('/job-titles', [positionsController::class, 'getPositions']);
        Route::post('/job-titles', [positionsController::class, 'createPositions']);
        Route::put('/job-titles/{id}', [positionsController::class, 'updatePositions']);
        Route::delete('/job-titles/{id}',[positionsController::class,'deletePositions'] );
        Route::get('/job-titles/{id}',[positionsController::class,'getPositionsbyid'] );
        // stratergic domains endpoints
        Route::get('/strategic-domains', [objectivesController::class, 'getStrategicDomains']);
        Route::post('/strategic-domains', [objectivesController::class, 'createStrategicDomain']);
        Route::put('/strategic-domains/{id}', [objectivesController::class,'updateStrategicDomain']);
        Route::delete('/strategic-domains/{id}',[objectivesController::class,'deleteStrategicDomain']);
        Route::get('/strategic-domains/{id}',[objectivesController::class,'getStrategicDomainById']);
        // key performance areas endpoints
        Route::get('/kpas', [KpaController::class, 'getAllKpa']);
        Route::post('/kpas', [KpaController::class, 'createKpa']);
        Route::put('/kpas/{id}', [KpaController::class,'updateKpa']);
        Route::delete('/kpas/{id}',[KpaController::class,'deleteKpa']);
        Route::get('/kpas/{id}',[KpaController::class,'getKpaById']);
        // key performance indicators endpoints
        Route::get('/kpis', [KpiController::class, 'getAllKpis']);
        Route::post('/kpis', [KpiController::class, 'createKpi']);
        Route::put('/kpis/{id}', [KpiController::class,'updateKpi']);
        Route::delete('/kpis/{id}',[KpiController::class,'deleteKpi']);
        Route::get('/kpis/{id}',[KpiController::class,'getKpiById']);
        Route::get('/kpis/reports',[KpiController::class,'getKpisForAllDirectReports']);
        Route::post('kpis/weights/{id}',[KpiController::class,'createKpiWeight']);
        Route::post('kpis/scores/{id}',[KpiController::class,'createKpiScore']);
        Route::get('/users/kpis/{id}',[KpiController::class,'getKpiByUserId']);
        // key performance indicators scoring
        Route::get('/kpis/scorings', [KpiScoringController::class,'getKpiScoring']);
        Route::post('/kpis/{id}/scorings', [KpiScoringController::class,'updateKpiScoring']);
        Route::put('/kpis/{id}/scorings', [KpiScoringController::class,'updateKpisScoring']);
        Route::delete('/kpis/{id}/scorings',[KpiScoringController::class,'deleteKpiScoring']);
        Route::get('/kpis/{id}/scorings',[KpiScoringController::class,'getKpiScoringbyid']);
        // feedbacks endpoints
        Route::get('/feedbacks/kpis', [FeedbackController::class, 'getAllFeedbacks']);
        Route::post('/feedbacks/kpis', [FeedbackController::class, 'createFeedback']);
        Route::put('/feedbacks/kpis/{id} ', [FeedbackController::class,'updateFeedbacks']);
        Route::delete('/feedbacks/kpis/{id}',[FeedbackController::class,'deleteFeedback']);
        Route::get('/feedbacks/kpis/{id}', [FeedbackController::class, 'getFeedbackByKpiId']);
        //password reset endpoints
        Route::post('/forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
        Route::post('/reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
        // Roles endpoint
        Route::get('/roles', [RolesController::class, 'index']);
        Route::post('/roles', [RolesController::class, 'create']);
        Route::put('/roles/{id}', [RolesController::class,'update']);
        Route::delete('/roles/{id}',[RolesController::class,'destroy']);
        Route::get('/roles/{id}',[RolesController::class,'show']);
    }
);


