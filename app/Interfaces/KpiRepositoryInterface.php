<?php

namespace App\Interfaces;

use App\Models\Kpi;
use Illuminate\Database\Eloquent\Collection;

interface KpiRepositoryInterface
{
    public function getAll(string $id):Collection;
    public function getById(string $id):Kpi;
    public function create(array $data):Kpi;
    public function update(string $id, array $data):Kpi;
    public function delete(string $id):bool;
    public function createWeight(string $id, array $data):Kpi;
    public function createScore(string $id, array $data):Kpi;
    public function getByUserId(string $id):Kpi;
    public function getAverageScore():Kpi;
    public function getAverageScoreByUserId(string $id):Kpi;
    public function getDirectReportKpis():Collection;
}
