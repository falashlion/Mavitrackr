<?php

namespace App\Interfaces;

use App\Models\Kpa;
use Illuminate\Database\Eloquent\Collection;

interface KpaRepositoryInterface
{
    public function getAll():Collection;
    public function getById(string $id):Kpa;
    public function create(array $data):Kpa;
    public function update(string $id,array $data):Kpa;
    public function delete(string $id):bool;
}
