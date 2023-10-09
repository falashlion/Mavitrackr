<?php

namespace App\Repositories;

use App\Models\Kpi;
use App\Models\User;
use App\Interfaces\KpiRepositoryInterface;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use PHPOpenSourceSaver\JWTAuth\Contracts\Providers\Auth;

class KpiRepository implements KpiRepositoryInterface
{
    public function getAll($id)
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
    public function getById($id, $e)
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
    public function update($id, $data, $e)
    {
        $kpi = Kpi::findOrFail($id);
        $kpi->update($data);
        return $kpi;
    }

    public function delete($id, $e)
    {
        $kpi = Kpi::findOrFail($id);
        $kpi->delete();
        return true;
    }
    public function createWeight($id, $data, $e)
    {
            $kpi = Kpi::findOrFail($id);
            $kpi -> update($data);
            return $kpi;
    }
    public function createScore($id, $data, $e)
    {
        $kpi = Kpi::findOrFail($id);
        $kpi -> update($data);
        return $kpi;
    }
    public function getAverageScore(){
        $user_id = auth()->user()->id;
        $averages=Kpi::where('user_id', $user_id)->select('weighted_average_score')->get();
        return $averages;

    }
    public function getByUserId($id, $e)
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
}
