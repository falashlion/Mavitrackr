<?php

namespace App\Repositories;

interface KpaRepository
{
    public function getAll($data);

    public function getById($id);

    public function create($data);

    public function update($id, $data);

    public function delete($id);
}
