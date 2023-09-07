<?php

namespace App\Repositories;

interface KpiRepository
{
    public function getAll($id);
    public function getById($id);
    public function create($data);
    public function update($id, $data);
    public function delete($id);
    public function createWeight($id, $data);
    public function createScore($id, $data);
    public function getByUserId($id);
}
