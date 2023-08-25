<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\KpiRepository;
use App\Http\Requests\KpiRequest;
use App\Http\Controllers\Controller;
use App\Models\Kpi;
use Illuminate\Http\Resources\Json\JsonResource;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;


class KpiController extends Controller
{
    protected $KpiRepository;
    public function __construct(KpiRepository $KpiRepository)
    {
        $this->KpiRepository = $KpiRepository;
        // $this->middleware('auth:api');
    }
    public function getKpi(Request $request)
    {
        $kpis = $this->KpiRepository->getAllKpi($request);
         return ResponseBuilder::success($kpis);
    }

    public function getKpibyid(Request $request, $id)
    {
        $kpi = $this->KpiRepository->getKpiById($id);
        $kpa= $kpi->kpa->title;
        $strategicDomans=$kpi->kpa->strategicDomain->title;
        $data =
        [
            'key_performance_indicators' => $kpi,
            'key_performance_area' => $kpa,
            'strategicDomains'=>  $strategicDomans
        ];

        return ResponseBuilder::success($data);
    }

    public function createKpi(KpiRequest $request)
    {
        $kpi = $this->KpiRepository->createKpi($request->all());

        return ResponseBuilder::success($kpi);
    }

    public function updateKpi(KpiRequest $request, $id)
    {
        $kpi = $this->KpiRepository->updateKpi($id, $request->all());

        return ResponseBuilder::success($kpi);
    }

    public function deleteKpi(Request $request, $id)
    {
        $kpi = $this->KpiRepository->deleteKpi($id);
        return ResponseBuilder::success($kpi);
    }
}
