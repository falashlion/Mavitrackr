<?php

namespace App\Repositories;

use App\Interfaces\PositionRepositoryInterface;
use App\Models\Position;

class PositionRepository implements PositionRepositoryInterface
{
    /**
     * getAllPositions
     *
     * @return object Returns the array of objects for all the positions
     */
    public function getAllPositions()
    {
        return Position::all();
    }
    /**
     * createPosition
     *
     * @param  array $data Contains data to create a position
     * @return object Returns the object of the created position
     */
    public function createPosition($data)
    {
        return Position::create($data);
    }
    /**
     * updatePosition
     *
     * @param  array $data Contains data for the update of a position
     * @param  string $id ID of the position
     * @return object Returns the object of the updated position
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
