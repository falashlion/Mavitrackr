<?php

namespace App\Repositories;

interface KpiRepository
{
    public function getAllKpi($data);

    public function getKpiById($id);

    public function createKpi($data);

    public function updateKpi($id, $data);

    public function deleteKpi($id);
}
