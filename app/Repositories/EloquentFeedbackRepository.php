<?php

namespace App\Repositories;

use App\Models\Feedback;

class EloquentFeedbackRepository implements FeedbackRepository
{
    protected $model;

    public function __construct(Feedback $feedback)
    {
        $this->model = $feedback;
    }

    public function all()
    {
        return $this->model->paginate(10);
    }

    public function getByKpiId($id)
    {
        $feedback = $this->model->where('kpis_id', $id)->get();
        if ($feedback->isEmpty()) {
            return null;
        }
        return $feedback;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $feedback = $this->model->find($id);
        if (!$feedback) {
            return null;
        }
        $feedback->update($data);
        return $feedback;
    }

    public function delete($id)
    {
        $feedback = $this->model->find($id);
        if (!$feedback) {
            return null;
        }
        $feedback->delete();
        return true;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }
}
