<?php

namespace App\Repositories;

use App\Models\Kpi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class EloquentKpiRepository implements KpiRepository{
    // public function getAllKpi($paginate)
    // {
    //     if($paginate == 'all'){
    //     $kpi = Kpi::all();
    //     }
    //     else{
    //         $kpi = Kpi::orderBy('created_at', 'desc')->paginate($paginate);
    //     }
    //     return $kpi;
    // }

    public function getAllKpi($data)
    {
        $page = $data->query('paginate') ?? '10';
         $kpis = Kpi::paginate($page);

        foreach ($kpis as $kpi)
        {
            $user = $kpi->user;
            $key_performance_area = $kpi->kpa->title;
           $strategic_domains = $kpi->kpa->strategicDomain->title;
        }
        return $kpis;
    }

    public function getKpiById($id)
    {
        return Kpi::findOrFail($id);
    }

    public function createKpi($data)
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
        $kpi = Kpi::findOrFail($id);
        $kpi->delete();
        return true;
    }
}
