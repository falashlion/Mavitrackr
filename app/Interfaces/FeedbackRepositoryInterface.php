<?php

namespace App\Interfaces;

interface FeedbackRepositoryInterface
{
    public function allFeedbacks();

    public function getByKpiId($id);

    public function create($data);

    public function updateFeedback(array $data, $id);

    public function delete($id);

    public function find($id);
}
