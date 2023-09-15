<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\KpiScoringRepository;
use App\Http\Requests\KpiScoringRequest;
use App\Http\Controllers\Controller;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class KpiScoringController extends Controller
{
    protected $KpiScoringRepository;
    public function __construct(KpiScoringRepository $KpiScoringRepository)
    {
        $this->KpiScoringRepository = $KpiScoringRepository;
    }
    public function getKpiScoring(Request $request)
    {
        $user= auth()->user();
        $kpis = $this->KpiScoringRepository->getAllKpi($request->all());
        $data = [
            'key_performance_indicator_score' => $kpis,
        ];

        return ResponseBuilder::success($data,200);
    }

    public function getKpiScoringbyid(Request $request, $id)
    {
        $kpi = $this->KpiScoringRepository->getKpiById($id);

        return ResponseBuilder::success($kpi,200);
    }

    public function createKpiScoring(KpiScoringRequest $request)
    {
        $kpi = $this->KpiScoringRepository->createKpi($request->all());
        if ($kpi->users_id->lineManager!== auth()->user()->id)
        {
            return ResponseBuilder::error(400);
        }
        return ResponseBuilder::success($kpi,200);
    }

    public function updateKpiScoring(KpiScoringRequest $request, $id)
    {
        $kpi = $this->KpiScoringRepository->updateKpi($id, $request->all());
        if ($kpi->users_id->lineManager!== auth()->user()->id)
        {
            return ResponseBuilder::error(400);
        }
        return ResponseBuilder::success($kpi,200);
    }

    public function deleteKpiScoring(Request $request, $id)
    {
       $kpi = $this->KpiScoringRepository->deleteKpi($id);

        return ResponseBuilder::success($kpi,200);
    }
}
