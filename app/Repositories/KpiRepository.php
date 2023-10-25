<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Models\Kpi;
use App\Models\User;
use App\Interfaces\KpiRepositoryInterface;

class KpiRepository implements KpiRepositoryInterface
{
    public function getAll($id): array
    {
        $kpis = Kpi::where('user_id', $id)->get();
        foreach ($kpis as $user)
        {
            $user->keyPerformanceArea->title;
            $user->keyPerformanceArea->strategicDomain;
            $user->feedback;
        }

        return $kpis;
    }
    public function getById($id)
    {
            $kpi = Kpi::findOrFail($id);
            $kpi->keyPerformanceArea;
            $kpi->keyPerformanceArea->strategicDomain;
            $kpi->feedback;

            return $kpi;
    }
    public function create($data)
    {
        return Kpi::create($data);
    }
    public function update($id, $data)
    {
        $kpi = Kpi::findOrFail($id);
        $kpi->update($data);
        return $kpi;
    }

    public function delete($id)
    {
        $kpi = Kpi::where('weight', null && 0)->findOrFail($id);
        $kpi->delete();
        return true;
    }
    public function createWeight($id, $data)
    {
            $kpi = Kpi::findOrFail($id);
            $kpi -> update($data);
            return $kpi;
    }
    public function createScore($id, $data)
    {
        $kpi = Kpi::findOrFail($id);
        $kpi -> update($data);
        return $kpi;
    }
    public function getAverageScore(){
        $user_id = auth()->user()->id;
        $averages=Kpi::where('user_id', $user_id)->select('weighted_average_score')->first();
        return $averages;

    }
    public function getAverageScoreByUserId($id){
        $averages=Kpi::where('user_id', $id)->select('weighted_average_score')->first();
        return $averages;
    }
    public function getByUserId($id)
    {
        $user = User::findOrFail($id);
        $kpis = Kpi::where('user_id',$id)->get();
        foreach($kpis as $kpi){
        $kpi->keyPerformanceArea;
        $kpi->keyPerformanceArea->strategicDomain;
        $kpi->feedback;
        }
        return $kpis;
    }

    public function getDirectReportKpis(){
        $directReports = auth()->user()->employees->pluck('id')->toArray();
        $kpis = Kpi::with('user')->whereIn('user_id', $directReports)->orderBy('created_at','DESC')->get();
        return $kpis;
    }
}
