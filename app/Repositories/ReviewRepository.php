<?php
namespace App\Repositories;

use App\Interfaces\ReviewInterface;
use App\Models\Kpi;
use App\Models\Review;
use App\Models\User;

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
        $review = Review::findOrFail($id);

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
    public function getAll($users)
    {
        $user_id = auth()->user()->id;
        $query = Review::where('user_id', $user_id);
        if (!empty($users)) {
            $query->orWhereIn('user_id', $users);
        }
        $reviews = $query->get();
        foreach ($reviews as $review) {
            $review->user;
            $review->user->lineManager;
        }
        return $reviews;
    }
}
