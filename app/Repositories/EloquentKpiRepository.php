<?php

namespace App\Repositories;

use App\Models\Kpi;
use App\Models\User;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class EloquentKpiRepository implements KpiRepository
{
    public function getAll($id)
    {
        $kpis = Kpi::where('user_id', $id)->get();
        foreach ($kpis as $user)
        {
            $user->user;
            $user->kpa->title;
            $user->kpa->strategicDomain;
        }
        return $kpis;
    }
    public function getById($id)
    {
        $kpi = Kpi::findOrFail($id);
        $kpi->user;
        $kpi->kpa->title;
        $kpi->kpa->strategicDomain;
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
        return $kpis;
    }
}
