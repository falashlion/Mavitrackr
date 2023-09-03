<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\PositionRepository;
use App\Http\Requests\PositionRequest;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class positionsController extends Controller
{
    private $positionRepository;

    public function __construct(PositionRepository $positionRepository)
    {
        $this->positionRepository = $positionRepository;
    }

    public function getPositions()
    {
        $positions = $this->positionRepository->getAllPositions();

        return ResponseBuilder::success($positions, 200);
    }
    public function createPositions(PositionRequest $request)
    {
        $position = $this->positionRepository->createPosition($request);
        return ResponseBuilder::success($position, 201);
    }
    public function updatePositions(PositionRequest $request, $id)
    {
        $position = $this->positionRepository->updatePosition($request, $id);
        if (!$position) {
            return ResponseBuilder::error(404);
        }
        return ResponseBuilder::success($position, 200);
    }
    public function deletePositions(Request $request, $id)
    {
        $result = $this->positionRepository->deletePosition($id);
        if (!$result) {
            return ResponseBuilder::error(404);
        }
        return ResponseBuilder::success([], 200);
    }
    public function getPositionsbyid(Request $request, $id)
    {
        $position = $this->positionRepository->getPositionById($id);
        if (!$position) {
            return ResponseBuilder::error(404);
        }
        return ResponseBuilder::success($position, 200);
    }
}
