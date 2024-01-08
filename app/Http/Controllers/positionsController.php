<?php

namespace App\Http\Controllers;

use App\interfaces\PositionRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
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
     * @return Response Returns the object of all the positions in the database
     */
    public function getPositions():Response
    {
        $positions = $this->positionRepository->getAllPositions();

        return ResponseBuilder::success($positions, 200);
    }
    /**
     * createPositions
     *
     * @param  PositionRequest $request contains the data required to create a position
     * @return Response Returns the object of the created position
     */
    public function createPositions(PositionRequest $request):Response
    {
        $position = $this->positionRepository->createPosition($request->all());

        return ResponseBuilder::success($position,201,null,201);
    }
    /**
     * updatePositions
     *
     * @param  PositionRequest $request Contains the data required to update the position
     * @param  string $id ID of the Position
     * @return Response Return the object of the updated position.
     */
    public function updatePositions(array $request, string $id)
    {
        $position = $this->positionRepository->updatePosition( $id, $request->all());
        if (!$position) {
            return ResponseBuilder::error(404);
        }

        return ResponseBuilder::success($position, 200);
    }
    /**
     * deletePositions
     * @param  string $id ID of the Position
     * @return Response Returns no content or the resoiurce not found exception.
     */
    public function deletePositions($id):Response
    {
        $result = $this->positionRepository->deletePosition($id);
        if (!$result) {
            return ResponseBuilder::error(404);
        }

        return ResponseBuilder::success([],204,null,204);
    }
    /**
     * getPositionsbyid
     * @param  string $id ID of the position
     * @return Response Returns the object of the position with this ID
     */
    public function getPositionsbyid(string $id):Response
    {
        $position = $this->positionRepository->getPositionById($id);
        if (!$position) {
            return ResponseBuilder::error(404);
        }

        return ResponseBuilder::success($position, 200);
    }
}
