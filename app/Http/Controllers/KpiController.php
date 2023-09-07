<?php

namespace App\Http\Controllers;

use App\Http\Requests\kpiScoreRequest;
use Illuminate\Http\Request;
use App\Repositories\KpiRepository;
use App\Http\Requests\KpiRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\kpiStoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;


class KpiController extends Controller
{
    protected $KpiRepository;
    public function __construct(KpiRepository $KpiRepository)
    {
        $this->KpiRepository = $KpiRepository;
        $this->middleware('jwt.auth');
    }

    public function getAllKpis(Request $request)
    {
    Auth::user();
    $id = auth()->id();
    $kpis = $this->KpiRepository->getAll($id);
    return ResponseBuilder::success($kpis, 200);
    }
    public function getKpiById(Request $request, $id)
    {
        $kpi = $this->KpiRepository->getById($id);
        if (!$id)
        {
            return ResponseBuilder::error(400);
        }
        return ResponseBuilder::success($kpi,200);
    }

    public function createKpi(KpiRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $kpi = $this->KpiRepository->create($data);
        return ResponseBuilder::success($kpi,200);
    }
    public function updateKpi(KpiRequest $request, $id)
    {
        $kpi = $this->KpiRepository->update($id, $request->all());
        if (!$id)
        {
            return ResponseBuilder::error(404);
        }
        return ResponseBuilder::success($kpi,200);
    }

    public function deleteKpiDetails(Request $request, $id)
    {
        $this->KpiRepository->delete($id);
        return ResponseBuilder::success(200);
    }
    public function createKpiWeight(kpiStoreRequest $request, $id){
        $kpi = $this->KpiRepository->createWeight($id,$request->all());
        return ResponseBuilder::success($kpi,200);
    }
    public function createKpiScore(kpiScoreRequest $request, $id){
        $kpi = $this->KpiRepository->createScore($id,$request->all());
        return ResponseBuilder::success($kpi,200);
    }
    public function getKpiByUserId($id)
    {
        $kpi = $this->KpiRepository->getByUserId($id);
        if (!$id)
        {
            return ResponseBuilder::error(400);
        }
        return ResponseBuilder::success($kpi,200);
    }

}
