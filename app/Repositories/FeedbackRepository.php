<?php

namespace App\Repositories;

use App\Models\Feedback;
use App\Interfaces\FeedbackRepositoryInterface;


class FeedbackRepository implements FeedbackRepositoryInterface
{
    /**
     * allFeedbacks
     *
     * @return object Returns the array of objects for all the feedbacks
     */
    public function allFeedbacks()
    {
        return Feedback::all();
    }
    /**
     * getByKpiId
     *
     * @param  string $id ID of the feedback
     * @return object Returns the object of the feedback with the ID
     */
    public function getByKpiId($id)
    {
        return Feedback::find($id);
    }
    /**
     * create
     *
     * @param  array $data Contains data to create a feedback
     * @return object Returns the object of the feedback.
     */
    public function create($data)
    {
        return Feedback::create($data);
    }
    /**
     * updateFeedback
     *
     * @param  string $id ID of the Feedback
     * @param  array $data Contains data to update the feedback
     * @return object Returns the object of the updated feedback.
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
     * @param  string $id ID of the Feedback
     * @return boolean Returns a true for successsfully deleted feedback and false otherwise.
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
