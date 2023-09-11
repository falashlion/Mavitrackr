<?php

namespace App\interfaces;

interface KpiScoringRepository
{
    public function getAllKpi($paginate);

    public function getKpiById($id);

    public function createKpi($data);

    public function updateKpi($id, $data);

    public function deleteKpi($id);
}
