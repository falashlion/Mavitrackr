<?php

namespace App\Repositories;

use App\Interfaces\PositionRepositoryInterface;
use App\Models\Position;

class PositionRepository implements PositionRepositoryInterface
{
    public function getAllPositions()
    {
        return Position::all();
    }
    public function createPosition($data)
    {
        return Position::create($data);
    }
    public function updatePosition($data, $id)
    {
        $position = Position::find($id);
        $position->update($data);
        return $position;
    }
    public function deletePosition($id)
    {
        $position = Position::find($id);
        $position->delete();
        return true;
    }
    public function getPositionById($id)
    {
        return Position::find($id);
    }
}
