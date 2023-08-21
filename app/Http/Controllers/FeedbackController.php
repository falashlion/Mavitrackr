<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Kpa;
use App\Models\Kpi;
use App\Repositories\EloquentFeedbackRepository;
use App\Repositories\FeedbackRepository;
use App\Http\Requests\FeedbackRequest;
use App\Http\Controllers\Controller;


class FeedbackController extends Controller
{
    protected $feedbackRepository;

public function __construct(FeedbackRepository $feedbackRepository)
{
    $this->feedbackRepository = $feedbackRepository;
}
public function getfeedback()
{
    $feedback = $this->feedbackRepository->all();

    return response()->json([
        'status' => 'success',
        'users' => $feedback,
    ]);
}
public function getfeedbackbyKpiid(FeedbackRequest $request, $id)
{
    $feedback = $this->feedbackRepository->getByKpiId($id);
    if (!$feedback) {
        return response()->json([
            'status'=> 'error',
            'message' =>'feedback for this key performance indicator could not be found',
        ], 404);
    }

    return response()->json([
        "status" => "success",
        "data"=> $feedback,
    ]);
}
public function createfeedback(FeedbackRequest $request, $id)
{
    $Kpi = Kpi::Find($id);
    $feedback = $this->feedbackRepository->create([
        "comment"   =>  $request['comment'],
        "kpis_id" => $id,
    ]);
    return response ()-> json ( [
        "status"    =>"success",
        "data"      => $feedback,
        "Message"   =>"feedback created successfully."
    ]);
}
public function updatefeedback(FeedbackRequest $request, $id)
{
    $feedback = $this->feedbackRepository->update([
        'comment'   =>  $request['comment'],
    ], $id);
    if (!$feedback) {
        return response()->json([
            'status'=> 'error',
            'message' =>'feedback could not found',
        ], 404);
    }

    return response() -> json ([
        "status"=>"updated",
        "message"=> "feedback updated",
    ]);
}
public function deletefeedback(Request $request, $id)
{
    $result = $this->feedbackRepository->delete($id);
    if (!$result) {
        return response()->json([
            "status"=> "not found",
            "message"=> "feedback was not round"
        ], 404);
    }

    return response()->json([
        "status" => "success",
        "message" => "feedback successfully deleted ",
    ]);
}

}
