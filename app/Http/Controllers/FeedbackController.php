<?php

namespace App\Http\Controllers;

use App\interfaces\FeedbackRepositoryInterface;
use App\Http\Requests\FeedbackRequest;
use App\Http\Controllers\Controller;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Symfony\Component\HttpFoundation\Response;


class FeedbackController extends Controller
{
    private $feedbackRepository;

    public function __construct(FeedbackRepositoryInterface $feedbackRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
        $this->middleware('jwt.auth');
    }
    /**
     * getAllFeedbacks
     *
     * @return Response Returns an object of all the feedbacks in the system
     */
    public function getAllFeedbacks():Response
    {
        $feedback = $this->feedbackRepository->allFeedbacks();
        return ResponseBuilder::success($feedback,200);
    }
    /**
     * getFeedbackByKpiId
     *
     * @param  string $id The Id of the  feedback
     * @return Response Returns an object of the contents of this feedback
     */
    public function getFeedbackByKpiId(string $id):Response
    {
        if (!$id)
        {
            return ResponseBuilder::error(404);
        }
        $feedback = $this->feedbackRepository->getByKpiId($id);

        return ResponseBuilder::success($feedback,200);
    }
    /**
     * createFeedback
     *
     * @param  FeedbackRequest $request Object of the data required to create a feedback
     * @return Response Returns the object of the created feedback
     */
    public function createFeedback(FeedbackRequest $request):Response
    {
        $feedback = $this->feedbackRepository->create($request->all());

        return ResponseBuilder::success($feedback,201,null,201,);
    }
    /**
     * updateFeedbacks
     *
     * @param  FeedbackRequest $request Object of the data required to update a feedback
     * @param  string $id The ID of the feedback to be updated
     * @return Response Returns object of the updated feedback
     */
    public function updateFeedbacks(FeedbackRequest $request, string $id):Response
    {
        $feedback = $this->feedbackRepository->updateFeedback($request->all(), $id);
        if (!$id)
        {
            return ResponseBuilder::error(404);
        }
        return ResponseBuilder::success($feedback,200);
    }
    /**
     * deleteFeedback
     *
     * @param  string $id Feedback Id
     * @return Response Returns the object of the error if the feedback id is not found or a void response when succefully deleted.
     */
    public function deleteFeedback($id):Response
    {
        if (!$id)
        {
            return ResponseBuilder::error(404);
        }
        $feedback = $this->feedbackRepository->delete($id);

        return ResponseBuilder::success($feedback,204,null,204);
    }

}
