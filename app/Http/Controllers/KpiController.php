<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\KpiRepository;
use App\Http\Requests\KpiRequest;
use App\Http\Controllers\Controller;

class KpiController extends Controller
{
    protected $KpiRepository;
    public function __construct(KpiRepository $KpiRepository)
    {
        $this->KpiRepository = $KpiRepository;
    }
    public function getKpi()
    {
        $kpis = $this->KpiRepository->getAllKpi();
        $data = [
            'key_performance_indicators' => $kpis,
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function getKpibyid(Request $request, $id)
    {
        $kpi = $this->KpiRepository->getKpiById($id);
        $data = [
            'key_performance_indicators' => $kpi,
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function createKpi(KpiRequest $request)
    {
        $kpi = $this->KpiRepository->createKpi($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $kpi,
            'message' => 'key performance indicator created successfully.',
        ], 200);
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
