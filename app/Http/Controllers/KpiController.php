<?php

namespace App\Http\Controllers;

use App\Http\Requests\kpiScoreRequest;
use App\Models\Kpi;
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
        $this->middleware('permission:kpis edit')->only('updateKpi');
        $this->middleware('permission:kpisweight edit')->only('createKpiWeight');
        $this->middleware('permission:kpisScore edit')->only('createKpiScore');
        $this->middleware('permission:kpis list')->only('getKpiByUserId',);
        $this->middleware('permission:kpis delete')->only(['deleteKpiDetails']);
    }

    public function getAllKpis()
    {
    Auth::user();
    $id = auth()->id();
    $kpis = $this->KpiRepository->getAll($id);
    return ResponseBuilder::success($kpis, 200);
    }
    public function getKpiById($id , Exception $e)
    {
        $kpi = $this->KpiRepository->getById($id, $e);
        return ResponseBuilder::success($kpi, 200);
    }
    public function createKpi(KpiRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $kpi = $this->KpiRepository->create($data);
        $this->weightedAverageScore();
        return ResponseBuilder::success($kpi,200);
    }
    public function updateKpi(KpiRequest $request, $id, Exception $e)
    {
        $kpi = $this->KpiRepository->update($id, $request->all(),$e);
        return ResponseBuilder::success($kpi,200);
    }
    public function deleteKpiDetails($id, Exception $e)
    {
        $this->KpiRepository->delete($id, $e);
        $this->weightedAverageScore();
        return ResponseBuilder::success(null,204);
    }
    public function createKpiWeight(kpiStoreRequest $request, $id, Exception $e){
        $kpi = $this->KpiRepository->createWeight($id,  $request->all(), $e);
        $this->weightedAverageScore();
        return ResponseBuilder::success($kpi,200);
    }
    public function createKpiScore(kpiScoreRequest $request, $id, Exception $e){
        $kpi = $this->KpiRepository->createScore($id, $request->all(), $e);
        $this->weightedAverageScore();
        return ResponseBuilder::success($kpi,200);
    }
    public function getKpiByUserId($id, Exception $e)
    {
        $kpi = $this->KpiRepository->getByUserId($id, $e);
        return ResponseBuilder::success($kpi,200);
    }
    public function weightedAverageScore () {
        // Calculate weighted average score per user_id
        $kpis = Kpi::select('user_id')->distinct()->get();
        foreach ($kpis as $kpi_user)
        {
            $user_id = $kpi_user->user_id;
            $kpi_scores = Kpi::where('user_id', $user_id)->get();
            $total_weight = 0;
            $weighted_sum = 0;
            foreach ($kpi_scores as $score) {
                $total_weight += $score->weight;
                $weighted_sum += $score->score * $score->weight;
            }
            if ($total_weight > 0) {
                $weighted_average = $weighted_sum / $total_weight;
            } else {
                $weighted_average = null;
            }
            Kpi::where('user_id', $user_id)->update(['weighted_average_score' => $weighted_average]);
        }
    }
}
