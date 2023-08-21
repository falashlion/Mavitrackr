<?php

namespace App\Repositories;

use App\Models\Kpi;

class EloquentKpiScoringRepository implements KpiScoringRepository{
    public function getAllKpi()
    {
        return Kpi::paginate(10);
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
