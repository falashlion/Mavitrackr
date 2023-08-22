<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\KpiRepository;
use App\Http\Requests\KpiRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class KpiController extends Controller
{
    protected $KpiRepository;
    public function __construct(KpiRepository $KpiRepository)
    {
        $this->KpiRepository = $KpiRepository;
    }
    public function getKpi(Request $request)
    {
        $kpis = $this->KpiRepository->getAllKpi($request->paginate ? $request->paginate : 'all');
        foreach ($kpis as $kpi) {
           'key_performance_area'== $kpi->kpa->title;
           $strategicDomans=$kpi->kpa->strategicDomain->title;
        }
        $data = [
            'key_performance_indicators' => $kpis,
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ],JsonResponse::HTTP_OK);
    }

    public function getKpibyid(Request $request, $id)
    {
        $kpi = $this->KpiRepository->getKpiById($id);
        $kpa= $kpi->kpa->title;
        $strategicDomans=$kpi->kpa->strategicDomain->title;
        $data = [
            'key_performance_indicators' => $kpi,
            // 'key_performance_area' => $kpa,
            // 'strategic_domains' => $strategicDomans,
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ],JsonResponse::HTTP_OK);
    }

    public function createKpi(KpiRequest $request)
    {
        $kpi = $this->KpiRepository->createKpi($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $kpi,
            'message' => 'key performance indicator created successfully.',
        ],JsonResponse::HTTP_CREATED );
    }

    public function updateKpi(KpiRequest $request, $id)
    {
        $kpi = $this->KpiRepository->updateKpi($id, $request->all());

        return response()->json([
            'status' => 'updated',
            'message' => 'key performance indicator updated',
            'Kpi' => $kpi,
        ]);
    }

    public function deleteKpi(Request $request, $id)
    {
        $this->KpiRepository->deleteKpi($id);

        return response()->json([
            'status' => 'success',
            'message' => 'key performance indicator successfully deleted',
        ]);
    }
}
