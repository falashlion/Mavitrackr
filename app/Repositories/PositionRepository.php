<?php

namespace App\Repositories;

use App\Models\Position;
use App\Http\Requests\PositionRequest;

class PositionRepository
{
    public function getAllPositions()
    {
        return Position::all();
    }

    public function createPosition(PositionRequest $request)
    {
        $validatedData = $request->validated();
        return Position::create([
            'title' => $validatedData['title'],
        ]);
    }

    public function updatePosition(PositionRequest $request, $id)
    {
        $position = Position::find($id);

        if (!$position) {
            return false;
        }

        $validatedData = $request->validated();

        $position->title = $validatedData['title'];
        $position->save();

        return $position;
    }

    public function deletePosition($id)
    {
        $position = Position::find($id);

        if (!$position) {
            return false;
        }

        $position->delete();

        return true;
    }

    public function getPositionById($id)
    {
        return Position::find($id);
    }
}
