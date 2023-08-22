<?php

namespace App\Repositories;

use App\Models\Kpi;

class EloquentKpiRepository implements KpiRepository{
    public function getAllKpi($paginate)
    {
        if($paginate == 'all'){
        $kpi = Kpi::all();
        }
        else{
            $kpi = Kpi::orderBy('created_at', 'desc')->paginate($paginate);
        }
        return $kpi;
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
