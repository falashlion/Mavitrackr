<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Kpi;
use App\Repositories\ReviewRepository;
use Symfony\Component\HttpFoundation\Response;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class ReviewController extends Controller
{
    protected $repository;

    public function __construct(ReviewRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('jwt.auth');
    }
    /**
     * store
     *
     * @param  CreateReviewRequest $request Contains the data to create a new review with
     * @return Response Returns the object of the created review.
     */
    public function store(CreateReviewRequest $request):Response
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $review = $this->repository->createReview($data);

        return ResponseBuilder::success($review, 201,null,201);
    }
    /**
     * show
     * @param  string $id ID of the Review
     * @return Response Returns the object of the review with this ID
     */
    public function show($id):Response
    {
        $review = $this->repository->find($id);

        return ResponseBuilder::success($review, 200);
    }

    /**
     * update
     * @param  CreateReviewRequest $request Contains the data for the review to be updated with
     * @param  string $id ID of the review
     * @return Response Returns the object of the updated review
     */
    public function update(UpdateReviewRequest $request, string $id):Response
    {
        $review = $this->repository->update($id, $request->all());
        $userId = $review->user_id;

        $kpis = Kpi::where('user_id', $userId)->get();

        foreach ($kpis as $kpi) {
            if (empty($kpi->weight) || empty($kpi->score)) {
                return ResponseBuilder::error(400,null,null,400);
            }
        }
        $review->status = 'completed';
        $review->save();

        return ResponseBuilder::success($review, 200);
    }

    /**
     * destroy
     * @param  string $id ID of the review
     * @return Response Returns no content or the exception for recourse not found.
     */
    public function destroy($id):Response
    {
        $this->repository->delete($id);

        return ResponseBuilder::success(null, 204,null,204);
    }
    /**
     * index
     * Get all reviews
     * @return Response Returns all the reviews in the database
     */
    public function index():Response
    {
        $reviews = $this->repository->getAll();

        return ResponseBuilder::success($reviews,200,null,200);
    }
}
