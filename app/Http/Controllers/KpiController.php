<?php

namespace App\Http\Controllers;

use App\Http\Requests\kpiScoreRequest;
use Illuminate\Http\Request;
use App\interfaces\KpiRepositoryInterface;
use App\Http\Requests\KpiRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\kpiStoreRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;


class KpiController extends Controller
{
    private $KpiRepository;
    public function __construct(KpiRepositoryInterface $KpiRepository)
    {
        $this->KpiRepository = $KpiRepository;
        $this->middleware('jwt.auth');
        $this->middleware('role:Manager')->only('updateKpi','createKpiWeight','createKpiScore','getKpiByUserId');
    }

    public function getAllKpis(Request $request)
    {
    Auth::user();
    $id = auth()->id();
    $kpis = $this->KpiRepository->getAll($id);
    return ResponseBuilder::success($kpis, 200);
    }
    public function getKpiById($id , Exception $e)
    {
        // try {
            $kpi = $this->KpiRepository->getById($id, $e);
            return ResponseBuilder::success($kpi, 200);
        // } catch (\Throwable $th) {
        //     return ResponseBuilder::error(404);
        // }
    }
    public function createKpi(KpiRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $kpi = $this->KpiRepository->create($data);
        return ResponseBuilder::success($kpi,200);
    }
    public function updateKpi(KpiRequest $request, $id, Exception $e)
    {
        try {
        $kpi = $this->KpiRepository->update($id, $request->all(),$e);
        return ResponseBuilder::success($kpi,200);
        } catch (\Throwable $th) {
        return ResponseBuilder::error(404);
        }
    }
    public function deleteKpiDetails(Request $request, $id, Exception $e)
    {
        try {
        $this->KpiRepository->delete($id, $e);
        return ResponseBuilder::success(204);
        } catch (\Throwable $th) {
        return ResponseBuilder::error(400);
        }
    }
    public function createKpiWeight(kpiStoreRequest $request, $id, Exception $e){
        $kpi = $this->KpiRepository->createWeight($id,  $request->all(), $e);
        return ResponseBuilder::success($kpi,200);
    }
    public function createKpiScore(kpiScoreRequest $request, $id, $e){
        $kpi = $this->KpiRepository->createScore($id, $request->all(), $e);
        return ResponseBuilder::success($kpi,200);
    }
    public function getKpiByUserId($id, Exception $e)
    {
        $kpi = $this->KpiRepository->getByUserId($id, $e);
        return ResponseBuilder::success($kpi,200);
    }

}
