<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\KpiScoringRepository;
use App\Http\Requests\KpiScoringRequest;
use App\Http\Controllers\Controller;

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
        $kpis = $this->KpiScoringRepository->getAllKpi($request -> paginate ? $request -> paginate : 'all');
        $data = [
            'key_performance_indicator_score' => $kpis,
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], JsonResponse::HTTP_OK);
    }

    public function getKpiScoringbyid(Request $request, $id)
    {
        $kpi = $this->KpiScoringRepository->getKpiById($id);

        return response()->json([
            'status' => 'success',
            'data' => $kpi,
        ], JsonResponse::HTTP_OK);
    }

    public function createKpiScoring(KpiScoringRequest $request)
    {
        $kpi = $this->KpiScoringRepository->createKpi($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $kpi,
            'message' => 'key performance indicator score created successfully.',
        ], JsonResponse::HTTP_CREATED);
    }

    public function updateKpiScoring(KpiScoringRequest $request, $id)
    {
        $kpi = $this->KpiScoringRepository->updateKpi($id, $request->all());

        return response()->json([
            'status' => 'updated',
            'message' => 'key performance indicator score updated',
            'Kpi' => $kpi,
        ], JsonResponse::HTTP_OK);
    }

    public function deleteKpiScoring(Request $request, $id)
    {
        $this->KpiScoringRepository->deleteKpi($id);

        return response()->json([
            'status' => 'success',
            'message' => 'key performance indicator score successfully deleted',
        ], JsonResponse::HTTP_OK);
    }
}
