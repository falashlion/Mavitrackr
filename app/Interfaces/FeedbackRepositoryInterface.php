<?php

namespace App\Interfaces;

use App\Models\Feedback;
use Illuminate\Database\Eloquent\Collection;

interface FeedbackRepositoryInterface
{
    public function allFeedbacks():Collection;
    public function getByKpiId(string $id):Feedback;
    public function create(array $data):Feedback;
    public function updateFeedback(array $data, string $id):Feedback;
    public function delete(string $id):bool;
}
