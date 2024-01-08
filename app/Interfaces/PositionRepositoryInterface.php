<?php

namespace App\Interfaces;

use App\Models\Position;
use Illuminate\Database\Eloquent\Collection;

interface PositionRepositoryInterface
{
    public function getAllPositions(): Collection;
    public function createPosition(array $data): Position;
    public function updatePosition(string $id, array $data):Position;
    public function deletePosition(string $id):bool;
    public function getPositionById(string $id):Position;
}
