<?php
namespace App\Repositories;

use App\Interfaces\ReviewInterface;
use App\Models\Review;

class ReviewRepository implements ReviewInterface
{
    public function createReview($data)
    {
        $review = Review::updateOrCreate(
            ['user_id' => $data['user_id']],
            $data
        );
        return $review;
    }
    public function find($id)
    {
        $review = Review::with(['user_id' => function ($query) {
            $query->select('first_name', 'last_name', 'profile_image');
        }])->findOrFail($id);

        return $review;
    }

    public function update($id, $data)
    {
        $review = Review::findOrFail($id);
        $review->update($data);
        return $review;
    }

    public function delete($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
    }
    public function getAll($directReports)
    {
        $review = Review:: where('user_id', $directReports)->get();
        return $review;
    }
}
