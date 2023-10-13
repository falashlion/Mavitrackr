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
        return ResponseBuilder::success($review, 201,null,201);
    }
    public function show($id)
    {
        $review = $this->repository->find($id);
        return ResponseBuilder::success($review, 200);
    }
    // public function update(UpdateReviewRequest $request, $id)
    // {

    //     $review = $this->repository->update($id, $request->all());
    //     return ResponseBuilder::success($review, 200);
    // }

    public function update(UpdateReviewRequest $request, $id)
{
    $review = $this->repository->update($id, $request->all());
    $userId = $review->user_id;

    $kpis = Kpi::where('user_id', $userId)->get();

    foreach ($kpis as $kpi) {
        if (empty($kpi->weight) || empty($kpi->score)) {
            return ResponseBuilder::error(400,null,'Not all KPIs have a weight and a score',400);
        }
    }
    $review->status = 'completed';
    $review->save();
    return ResponseBuilder::success($review, 200);
}

    public function destroy($id)
    {
        $this->repository->delete($id);
        return ResponseBuilder::success(null, 204,null,204);
    }
    public function index()
    {
        $reviews = $this->repository->getAll();
        return ResponseBuilder::success($reviews,200,null,200);
    }
}
