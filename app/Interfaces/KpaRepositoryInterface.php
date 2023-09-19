<?php

namespace App\Interfaces;

interface KpaRepositoryInterface
{
    public function getAll();

    public function getById($id, $e);

    public function create($data);

    public function update($id, $e, $data);

    public function delete($id, $e);
}
