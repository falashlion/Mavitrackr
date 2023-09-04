<?php

namespace App\Http\Controllers;

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
    }

    public function getAllKpis(Request $request)
    {
    Auth::user();
    $kpis = $this->KpiRepository->getAll($request);
    foreach ($kpis as $kpi){
        if ($kpi->user_id === Auth::id()) {
        }
    }
    return ResponseBuilder::success($kpi, 200);
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
    public function getKpisForAllDirectReports(Request $request)
    {
    $user = Auth::user()->id;
    $userDirectReports = User::select('line_manager')->get('line_manager' == $user);
    $kpis = $this->KpiRepository->getAllDirectReportsKpis($request);
    foreach ($kpis as $kpi){
        if ($kpi->user_id === $userDirectReports) {
        }
    }
    return ResponseBuilder::success($kpi, 200);
    }
    public function createKpiWeight(kpiStoreRequest $request){
        $kpi = $this->KpiRepository->create($request);
        return ResponseBuilder::success($kpi,200);
    }
}
