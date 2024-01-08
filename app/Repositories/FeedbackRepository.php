<?php

namespace App\Repositories;

use App\Models\Feedback;
use App\Interfaces\FeedbackRepositoryInterface;
use App\Models\Kpi;
use Illuminate\Database\Eloquent\Collection;

class FeedbackRepository implements FeedbackRepositoryInterface
{
    /**
     * allFeedbacks
     *
     * @return Collection Returns the array of objects for all the feedbacks
     */
    public function allFeedbacks():Collection
    {
        return Feedback::all();
    }
    /**
     * getByKpiId
     *
     * @param  string $id ID of the feedback
     * @return Feedback Returns the object of the feedback with the kpi ID
     */
    public function getByKpiId($id):Feedback
    {
        Kpi::find($id);

        return Feedback::where('kpis_id', $id)->get();
    }
    /**
     * creates a new Feedback in the database
     *
     * @param  array $data Contains data to create a feedback
     * @return Feedback Returns the object of the feedback.
     */
    public function create($data):Feedback
    {
        return Feedback::create($data);
    }
    /**
     * updates a Feedback in the database from its id
     *
     * @param  string $id ID of the Feedback
     * @param  array $data Contains data to update the feedback
     * @return Feedback Returns the object of the updated feedback.
     */
    public function updateFeedback($id, $data):Feedback
    {
        $feedback = Feedback::find($id);
        $feedback->update($data);
        return $feedback;
    }
    /**
     * deletes a Feedback from the database
     *
     * @param  string $id ID of the Feedback
     * @return bool Returns a true for successsfully deleted feedback and false otherwise.
     */
    public function delete($id):bool
    {
        $feedback = Feedback::find($id);
        $feedback->delete();
        return true;
    }
}
