<?php

namespace App\Http\Controllers;

use App\interfaces\FeedbackRepositoryInterface;
use App\Http\Requests\FeedbackRequest;
use App\Http\Controllers\Controller;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;


class FeedbackController extends Controller
{
private $feedbackRepository;

public function __construct(FeedbackRepositoryInterface $feedbackRepository)
{
    $this->feedbackRepository = $feedbackRepository;
    $this->middleware('jwt.auth');
}
/**
 * getAllFeedbacks
 *
 * @return object
 */
public function getAllFeedbacks()
{
    $feedback = $this->feedbackRepository->allFeedbacks();
    return ResponseBuilder::success($feedback,200);
}
/**
 * getFeedbackByKpiId
 *
 * @param  string $id
 * @return object
 */
public function getFeedbackByKpiId($id)
{
    if (!$id)
    {
        return ResponseBuilder::error(404);
    }
    $feedback = $this->feedbackRepository->getByKpiId($id);

    return ResponseBuilder::success($feedback,200);
}
/**
 * createFeedback
 *
 * @param  object $request
 * @return object
 */
public function createFeedback(FeedbackRequest $request)
{
    $feedback = $this->feedbackRepository->create($request->all());

    return ResponseBuilder::success($feedback,201,null,201,);
}
/**
 * updateFeedbacks
 *
 * @param  object $request
 * @param  array $id
 * @return object
 */
public function updateFeedbacks(FeedbackRequest $request, array $id)
{
    $feedback = $this->feedbackRepository->updateFeedback($id, $request->all());
    if (!$id)
    {
        return ResponseBuilder::error(404);
    }
    return ResponseBuilder::success($feedback,200);
}
/**
 * deleteFeedback
 *
 * @param  string $id
 * @return object
 */
public function deleteFeedback($id)
{
    if (!$id)
    {
        return ResponseBuilder::error(404);
    }
    $feedback = $this->feedbackRepository->delete($id);

    return ResponseBuilder::success($feedback,204,null,204);
}

}
