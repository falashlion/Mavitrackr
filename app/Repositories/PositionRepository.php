<?php

namespace App\Repositories;

use App\Interfaces\PositionRepositoryInterface;
use App\Models\Position;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;

class PositionRepository implements PositionRepositoryInterface
{
    /**
     * gets All Positions
     *
     * @return Collection Returns the array of objects for all the positions
     */
    public function getAllPositions():Collection
    {
        return Position::all();
    }
    /**
     * creates a new Position in the database
     *
     * @param  array $data Contains data to create a position
     * @return Position Returns the object of the created position
     */
    public function createPosition($data):Position
    {
        return Position::create($data);
    }
    /**
     * updates a Position in the database
     *
     * @param  array $data Contains data for the update of a position
     * @param  string $id ID of the position
     * @return Position Returns the object of the updated position
     */
    public function updatePosition($data, $id):Position
    {
        $position = Position::find($id);
        $position->update($data);

        return $position;
    }
    /**
     * deletes a Position in the database
     *
     * @param  string $id
     * @return bool
     */
    public function deletePosition(string $id):bool
    {
        $position = Position::find($id);
        $position->delete();
        return true;
    }
    /**
     * gets a Position from the database by its Id
     *
     * @param  string $id
     * @return Position
     */
    public function getPositionById($id):Position
    {
        return Position::find($id);
    }
}
