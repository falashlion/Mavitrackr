<?php
namespace App\Repositories;

use App\Interfaces\ReviewInterface;
use App\Models\Review;
use PHPOpenSourceSaver\JWTAuth\Contracts\Providers\auth;

class ReviewRepository implements ReviewInterface
{
    public function create($data)
    {
        $review = Review::create($data);
        $review->user;
        return $review;
    }

    public function find($id)
    {
        $review = Review::with(['user' => function ($query) {
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
    public function getAll($userIds)
    {
        $review = Review::whereIn('user_id', $userIds)->select('first_name', 'last_name', 'profile_image')->get();
        $review->user->employees;
        return $review;
    }
}
