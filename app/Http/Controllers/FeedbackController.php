<?php

namespace App\Http\Controllers;

use App\interfaces\FeedbackRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Kpa;
use App\Models\Kpi;
use App\Repositories\EloquentFeedbackRepository;
use App\Repositories\FeedbackRepository;
use App\Http\Requests\FeedbackRequest;
use App\Http\Controllers\Controller;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;


class FeedbackController extends Controller
{
    private $feedbackRepository;

public function __construct(FeedbackRepositoryInterface $feedbackRepository)
{
    $this->feedbackRepository = $feedbackRepository;
}
public function getAllFeedbacks()
{
    $feedback = $this->feedbackRepository->allFeedbacks();
    return ResponseBuilder::success($feedback,200);
}
public function getFeedbackByKpiId($id)
{
    $feedback = $this->feedbackRepository->getByKpiId($id);
    return ResponseBuilder::success($feedback,200);
}
public function createFeedback(FeedbackRequest $request)
{
    $feedback = $this->feedbackRepository->create($request->all());
    return ResponseBuilder::success($feedback,201);
}
public function updateFeedback(FeedbackRequest $request, $id)
{
    $feedback = $this->feedbackRepository->update($id,$request->all());
    return ResponseBuilder::success($feedback,200);
}
public function deleteFeedback(Request $request, $id)
{
    $result = $this->feedbackRepository->delete($id);
    if (!$result) {
        return response()->json([
            "status"=> "not found",
            "message"=> "feedback was not round"
        ], JsonResponse::HTTP_NOT_FOUND);
    }

    return response()->json([
        "status" => "success",
        "message" => "feedback successfully deleted ",
    ], JsonResponse::HTTP_OK);
}

}
