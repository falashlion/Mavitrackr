<?php
namespace App\Repositories;

use App\Interfaces\ReviewInterface;
use App\Models\Kpi;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;


class ReviewRepository implements ReviewInterface
{
    /**
     * creates a new Review in the database
     *
     * @param  array $data
     * @return Review
     */
    public function createReview(array $data):Review
    {
        $review = Review::updateOrCreate(
            ['user_id' => $data['user_id']],
            $data
        );

        return $review;
    }
    /**
     * finds a review in the databse by its id
     *
     * @param  string $id
     * @return Review
     */
    public function find(string $id): Review
    {
        $review = Review::findOrFail($id);

        return $review;
    }

    /**
     * updates a review in the database
     *
     * @param  string $id
     * @param  array $data
     * @return Review
     */
    public function update(string $id, array $data):Review
    {
        $review = Review::findOrFail($id);
        $review->update($data);

        return $review;
    }

    /**
     * deletes a  review from the database
     *
     * @param  string $id
     * @return bool
     */
    public function delete($id):bool
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return true;
    }
    /**
     * gets All reviews the particular user has access to
     *
     * @return Collection
     */
    public function getAll():Collection
    {
        $user_id = auth()->id();
        $users_id = array($user_id);
        if (Kpi::whereIn('user_id', $users_id)->exists()) {
            $query1 = Review::with(['user', 'user.lineManager'])->where('user_id', $users_id)->get();
        } else {
            $query1 = collect([]);
        }
        $users = User::where('line_manager', $user_id)->pluck('id');
        $user_ids = $users->toArray();
        $user_ids_with_kpis = Kpi::whereIn('user_id', $user_ids )->pluck('user_id')->toArray();
        $query2 = Review::with(['user', 'user.lineManager'])
            ->whereIn('user_id', $user_ids_with_kpis)
            ->orderByDesc('created_at')
            ->get();
        $query = $query1->merge($query2);

        return $query;
    }
}
