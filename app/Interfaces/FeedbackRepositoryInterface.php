<?php

namespace App\Interfaces;

interface FeedbackRepositoryInterface
{
    public function allFeedbacks();

    public function getByKpiId($id);

    public function create(array $data);

    public function updateFeedback(array $data, string $id);

    public function delete(string $id);

    public function find(string $id);
}
