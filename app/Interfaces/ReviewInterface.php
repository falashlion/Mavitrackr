<?php

namespace App\Interfaces;

use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;

interface ReviewInterface
{
    public function createReview(array $data):Review;
    public function find(string $id): Review;
    public function update(string $id, array $data):Review;
    public function delete(string $id):bool;
    public function getAll():Collection;
}
