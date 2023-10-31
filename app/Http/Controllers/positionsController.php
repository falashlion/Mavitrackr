<?php

namespace App\Http\Controllers;

use App\interfaces\PositionRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Requests\PositionRequest;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class positionsController extends Controller
{
    private $positionRepository;

    public function __construct(PositionRepositoryInterface $positionRepository)
    {
        $this->positionRepository = $positionRepository;
        $this->middleware('jwt.auth');
    }

    /**
     * getPositions
     *
     * @return object
     */
    public function getPositions()
    {
        $positions = $this->positionRepository->getAllPositions();

        return ResponseBuilder::success($positions, 200);
    }
    /**
     * createPositions
     *
     * @param  object $request
     * @return object
     */
    public function createPositions(PositionRequest $request)
    {
        $position = $this->positionRepository->createPosition($request->all());

        return ResponseBuilder::success($position,201,null,201);
    }
    /**
     * updatePositions
     *
     * @param  object $request
     * @param  string $id
     * @return object
     */
    public function updatePositions(PositionRequest $request, $id)
    {
        $position = $this->positionRepository->updatePosition($request, $id);
        if (!$position) {
            return ResponseBuilder::error(404);
        }

        return ResponseBuilder::success($position, 200);
    }
    /**
     * deletePositions
     *
     * @param  object $request
     * @param  string $id
     * @return object
     */
    public function deletePositions(Request $request, $id)
    {
        $result = $this->positionRepository->deletePosition($id);
        if (!$result) {
            return ResponseBuilder::error(404);
        }

        return ResponseBuilder::success([],204,null,204);
    }
    /**
     * getPositionsbyid
     *
     * @param  object $request
     * @param  string $id
     * @return object
     */
    public function getPositionsbyid(Request $request, $id)
    {
        $position = $this->positionRepository->getPositionById($id);
        if (!$position) {
            return ResponseBuilder::error(404);
        }

        return ResponseBuilder::success($position, 200);
    }
}
