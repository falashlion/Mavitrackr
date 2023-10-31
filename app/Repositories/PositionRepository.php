<?php

namespace App\Repositories;

use App\Interfaces\PositionRepositoryInterface;
use App\Models\Position;

class PositionRepository implements PositionRepositoryInterface
{
    /**
     * getAllPositions
     *
     * @return object
     */
    public function getAllPositions()
    {
        return Position::all();
    }
    /**
     * createPosition
     *
     * @param  array $data
     * @return object
     */
    public function createPosition($data)
    {
        return Position::create($data);
    }
    /**
     * updatePosition
     *
     * @param  array $data
     * @param  string $id
     * @return object
     */
    public function updatePosition($data, $id)
    {
        $position = Position::find($id);
        $position->update($data);
        return $position;
    }
    /**
     * deletePosition
     *
     * @param  string $id
     * @return boolean
     */
    public function deletePosition($id)
    {
        $position = Position::find($id);
        $position->delete();
        return true;
    }
    /**
     * getPositionById
     *
     * @param  string $id
     * @return object
     * @
     */
    public function getPositionById($id)
    {
        return Position::find($id);
    }
}
