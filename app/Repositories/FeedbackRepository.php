<?php

namespace App\Repositories;

use App\Models\Feedback;
use App\Interfaces\FeedbackRepositoryInterface;

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
        return Feedback::create($data) ;
    }
    public function update($data, $id)
    {
        $feedback = Feedback::find($id);
        $feedback->update($data);
        return $feedback;
    }
    public function delete($id)
    {
        return true;
    }
    public function find($id)
    {

    }
}
