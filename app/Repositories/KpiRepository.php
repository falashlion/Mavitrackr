<?php

namespace App\Repositories;

use App\Models\Kpi;
use App\Models\User;
use App\Interfaces\KpiRepositoryInterface;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

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
    public function getById($id)
    {
        $kpi = Kpi::findOrFail($id);
        $kpi->keyPerformanceArea->title;
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
        $kpi = Kpi::findOrFail($id)->first();
        if ($kpi->user_id !== auth()->user()->id)
        {
            return ResponseBuilder::error(400);
        }
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
}
