<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Kpi;
use App\Models\User;
use App\Repositories\ReviewRepository;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class ReviewController extends Controller
{
    protected $repository;

    public function __construct(ReviewRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('jwt.auth');
    }
    public function store(CreateReviewRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $review = $this->repository->createReview($data);
        return ResponseBuilder::success($review, 201);
    }
    public function show($id)
    {
        $review = $this->repository->find($id);
        return ResponseBuilder::success($review, 200);
    }
    public function update(UpdateReviewRequest $request, $id)
    {
        $review = $this->repository->update($id, $request->all());
        return ResponseBuilder::success($review, 200);
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return ResponseBuilder::success(null, 204);
    }
    public function index()
    {
        $user = auth()->user()->id;
        $users = User::where('line_manager', $user)->get('id');
        $has_kpi = Kpi::where('user_id', $user)->exists();
        if (!$has_kpi) {
            return ResponseBuilder::success([], 200);
        }
        $review = $this->repository->getAll($users);
        return ResponseBuilder::success($review, 200);
    }
}
