<?php

namespace App\Interfaces;

use App\Models\StrategicDomain;
use Illuminate\Database\Eloquent\Collection;

interface StrategicDomainRepositoryInterface
{
    public function getAll():Collection;
    public function getById(string $id): StrategicDomain;
    public function create(array $data): StrategicDomain;
    public function update(string $id, array $data): StrategicDomain;
    public function delete(string $id): bool;
}
