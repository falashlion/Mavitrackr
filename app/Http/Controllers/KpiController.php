<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\KpiRepository;
use App\Http\Requests\KpiRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;


class KpiController extends Controller
{
    protected $KpiRepository;
    public function __construct(KpiRepository $KpiRepository)
    {
        $this->KpiRepository = $KpiRepository;
        // $this->middleware('auth:api');
    }

    public function getKpisOfUser(Request $request)
    {
    $user = Auth::user();
    $kpis = $this->KpiRepository->getAllKpi($request);
    $filtered_kpis = [];
    foreach ($kpis as $kpi){
        if ($kpi->users_id === Auth::id() || $kpi->user->lineManager->id === Auth::id()) {
            $user->profile_image = config('app.url') . "/storage/" . $user->profile_image;
            $filtered_kpis[] = $kpi;
        }
    }
    return ResponseBuilder::success($filtered_kpis, 200);
    }

    public function getKpibyid(Request $request, $id)
    {
        $kpi = $this->KpiRepository->getKpiById($id);
        if ($kpi->users_id !== auth()->user()->id)
        {
            return ResponseBuilder::error(400);
        }
        $kpa= $kpi->kpa->title;
        $strategicDomans=$kpi->kpa->strategicDomain->title;
        $data =
        [
            'key_performance_indicators' => $kpi,
            'key_performance_area' => $kpa,
            'strategicDomains'=>  $strategicDomans
        ];
        return ResponseBuilder::success($data,200);
    }

    public function createKpi(KpiRequest $request)
    {
        $data = $request->validated();
        $data['users_id'] = auth()->user()->id;
        $kpi = $this->KpiRepository->create($data);
        return ResponseBuilder::success($kpi,200);
    }

    public function updateKpiDetails(KpiRequest $request, $id)
    {
        $kpi = $this->KpiRepository->updateKpi($id, $request->all());
        if ($kpi->users_id !== auth()->user()->id)
        {
            return ResponseBuilder::error(400);
        }
        return ResponseBuilder::success($kpi,200);
    }

    public function deleteKpiDetails(Request $request, $id)
    {
        $kpi = $this->KpiRepository->deleteKpi($id);
        return ResponseBuilder::success(200);
    }
}
