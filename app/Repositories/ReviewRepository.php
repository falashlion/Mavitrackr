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
    // public function getAll()
    // {
    //     $user_id = auth()->user()->id;
    //     $users = User::where('line_manager', $user_id)->get('id');
    //     $query = Review::with(['user', 'user.lineManager']);
    //     if ($users->isEmpty()) {
    //         $has_kpi = Kpi::where('user_id', $user_id)->exists();
    //         if (!$has_kpi) {
    //             return [];
    //         }
    //         $query->where('user_id', $user_id);
    //     }

    //     if (!empty($users)) {
    //         $user_ids = $users->pluck('id')->toArray();
    //         $kpis = Kpi::whereIn('user_id', $user_ids)->pluck('user_id')->toArray();
    //         $user_ids_with_kpis = array_intersect($user_ids, $kpis);
    //         if (!empty($user_ids_with_kpis)) {
    //             if (Kpi::where('user_id', $user_id)->exists()) {
    //                 $query = Review::with(['user', 'user.lineManager']);
    //                 $query->orWhere('user_id', $user_id);
    //             }
    //             $query = Review::with(['user', 'user.lineManager']);
    //             $query->orWhereIn('user_id', $user_ids_with_kpis);
    //             $reviews = $query->get();
    //         }
    //         else {
    //             return[];
    //         }
    //     }
    //     return $reviews;
    // }
    public function getAll()
    {
        $user_id = auth()->id();
        if (Kpi::whereIn('user_id', $user_id)->pluck('user_id')->toArray()->exists()) {
            $que= Review::with(['user', 'user.lineManager'])
            ->where('user_id', $user_id)
            ->get();
        }
        $users = User::where('line_manager', $user_id)->pluck('id');
        $user_ids = $users->toArray();
        $user_ids_with_kpis = Kpi::whereIn('user_id', $user_ids)->pluck('user_id')->toArray();
        // $user_ids_with_kpis[] = $user_id;
        $query = Review::with(['user', 'user.lineManager'])
            ->whereIn('user_id', $user_ids_with_kpis)
            ->orderByDesc('created_at')
            ->get();
        if (empty($query)) {
            return [];
        }
        return $query;
    }


}
