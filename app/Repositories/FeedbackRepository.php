<?php

namespace App\Repositories;

use App\Models\Feedback;
use App\Interfaces\FeedbackRepositoryInterface;
use App\Models\Kpi;

class FeedbackRepository implements FeedbackRepositoryInterface
{
    /**
     * allFeedbacks
     *
     * @return object
     */
    public function allFeedbacks()
    {
        return Feedback::all();
    }
    /**
     * getByKpiId
     *
     * @param  string $id
     * @return object
     */
    public function getByKpiId($id)
    {
        return Feedback::find($id);
    }
    /**
     * create
     *
     * @param  mixed $data
     * @return object
     */
    public function create($data)
    {
        return Feedback::create($data);
    }
    /**
     * updateFeedback
     *
     * @param  string $id
     * @param  mixed $data
     * @return object
     */
    public function updateFeedback($id, $data)
    {
        $feedback = Feedback::find($id);
        $feedback->update($data);
        return $feedback;
    }
    /**
     * delete
     *
     * @param  string $id
     * @return object
     */
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
