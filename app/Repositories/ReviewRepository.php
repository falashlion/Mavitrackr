<?php
namespace App\Repositories;

use App\Interfaces\ReviewInterface;
use App\Models\Kpi;
use App\Models\Review;
use App\Models\User;
use Illuminate\Validation\Rules\Exists;

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
        $user_id = auth()->id();
        $users_id = array($user_id);
        if (Kpi::whereIn('user_id', $users_id)->exists()) {
            $query1= Review::with(['user', 'user.lineManager'])
            ->where('user_id', $users_id)
            ->get();
            $query1 = array($query1);
            if (empty($query1)) {
                return [];
            }
        }
        $users = User::where('line_manager', $user_id)->pluck('id');
        $user_ids = $users->toArray();
        $user_ids_with_kpis = Kpi::whereIn('user_id', $user_ids)->pluck('user_id')->toArray();
        $query = Review::with(['user', 'user.lineManager'])
            ->whereIn('user_id', $user_ids_with_kpis)
            ->orderByDesc('created_at')
            ->get();
        $query = array($query);
        if (empty($query)) {
            return [];
        }
        $review = array_merge($query1 ?? [], $query ?? []);
        return response()->json([ 'success' => true, 'code' => 200, 'locale' => 'en', 'message' => 'OK', 'data'=> ['items' => $review,]]);
    }
}
