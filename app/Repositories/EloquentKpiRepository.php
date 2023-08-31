<?php

namespace App\Repositories;

use App\Models\Kpi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Tymon\JWTAuth\Facades\JWTAuth;

class EloquentKpiRepository implements KpiRepository
{
    public function getAllKpi($data)
    {
        $page = $data->query('paginate') ?? '10';
         $kpis = Kpi::paginate($page);

        foreach ($kpis as $kpi)
        {
            $kpi->user;
            $kpi->kpa->title;
            $kpi->kpa->strategicDomain->title;
        }
        return $kpis;
    }

    public function getKpiById($id)
    {
        return Kpi::findOrFail($id);
    }

    public function create($data)
    {
        return Kpi::create($data);
    }

    public function updateKpi($id, $data)
    {
        $kpi = Kpi::findOrFail($id);
        $kpi->update($data);
        return $kpi;
    }

    public function deleteKpi($id)
    {
        $kpi = Kpi::findOrFail($id)->first();
        if ($kpi->users_id !== auth()->user()->id)
        {
            return ResponseBuilder::error(400);
        }
        $kpi->delete();
        return true;
    }
}
