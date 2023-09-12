<?php

namespace App\Repositories;

use App\Models\Feedback;
use App\Interfaces\FeedbackRepositoryInterface;
use App\Models\Kpi;

class FeedbackRepository implements FeedbackRepositoryInterface
{
    public function allFeedbacks()
    {
        return Feedback::all();
    }
    public function getByKpiId($id)
    {
        return Feedback::find($id);
    }
    public function create($data)
    {
        return Feedback::create($data);
    }
    public function updateFeedback($id, $data)
    {
        $feedback = Feedback::find($id);
        $feedback->update($data);
        return $feedback;
    }
    public function delete($id)
    {
        $feedback = Feedback::find($id);
        $feedback->delete();
        return true;
    }
    public function find($id)
    {

    }
}
