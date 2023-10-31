<?php

namespace App\Interfaces;

interface KpiRepositoryInterface
{
    public function getAll(string $id);
    public function getById(string $id);
    public function create(array $data);
    public function update(string $id, array $data );
    public function delete(string $id);
    public function createWeight(string $id, array $data);
    public function createScore(string $id, array $data);
    public function getByUserId(string $id);
    public function getAverageScore();
    public function getAverageScoreByUserId(string $id);
    public function getDirectReportKpis();
}
