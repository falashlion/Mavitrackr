<?php

namespace App\Interfaces;

interface KpiRepositoryInterface
{
    public function getAll($id);
    public function getById($id, $e);
    public function create($data);
    public function update($id, $data, $e);
    public function delete($id, $e);
    public function createWeight($id, $data, $e);
    public function createScore($id, $data, $e);
    public function getByUserId($id, $e);
}
