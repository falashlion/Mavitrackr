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
    public function getAll()
    {
        $user_id = auth()->user()->id;
        $users = User::where('line_manager', $user_id)->get('id');
        if ($users->isEmpty()) {
            $has_kpi = Kpi::where('user_id', $user_id)->exists() || Kpi::where('user_id', $user_id)->exists();;

            if (!$has_kpi) {
                return [];
            }}
        $query = Review::with(['user', 'user.lineManager'])->where('user_id', $user_id);
        if (!empty($users)) {
            foreach ($users as $user){
                $has_kpi = Kpi::where('user_id', $user)->exists();
                $query->orWhereIn('user_id', $user);
            }

        }
        $reviews = $query->get();
        return $reviews;
    }
}
