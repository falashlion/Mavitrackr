<?php

namespace App\Repositories;

interface KpiRepositoryInterface
{
    public function getAllKpi();

    public function getKpiById($id);

    public function createKpi($data);

    public function updateKpi($id, $data);

    public function deleteKpi($id);
}
