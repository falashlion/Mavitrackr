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
public function getAllFeedbacks()
{
    $feedback = $this->feedbackRepository->allFeedbacks();
    return ResponseBuilder::success($feedback,200);
}
public function getFeedbackByKpiId($id)
{
    if (!$id)
    {
        return ResponseBuilder::error(404);
    }
    $feedback = $this->feedbackRepository->getByKpiId($id);
    return ResponseBuilder::success($feedback,200);
}
public function createFeedback(FeedbackRequest $request)
{
    $feedback = $this->feedbackRepository->create($request->all());
    return ResponseBuilder::success($feedback,201);
}
public function updateFeedbacks(FeedbackRequest $request, $id)
{
    $feedback = $this->feedbackRepository->updateFeedback($id, $request->all());
    if (!$id)
    {
        return ResponseBuilder::error(404);
    }
    return ResponseBuilder::success($feedback,200);
}
public function deleteFeedback($id)
{
    if (!$id)
    {
        return ResponseBuilder::error(404);
    }
    $feedback = $this->feedbackRepository->delete($id);

    return ResponseBuilder::success($feedback,204);
}

}
