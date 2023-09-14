<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StrategicDomain;
use App\Models\Kpi;
use App\Http\Requests\FeedbackRequest;
use App\Http\Requests\StrategicDomainsRequest;
use App\Repositories\StrategicDomainRepository;
use App\Repositories\FeedbackRepository;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;





class objectivesController extends Controller
{
    //endpoints for StrategicDomain
    private $strategicDomainRepository;

    public function __construct(StrategicDomainRepository $strategicDomainRepository, )
    {
        $this->strategicDomainRepository = $strategicDomainRepository;
        $this->middleware('jwt.auth');
    }
    protected $feedbackRepository;
    public function getStrategicDomains()
    {
        $strategicDomains = $this->strategicDomainRepository->getAll();
        $data=
        [
            'strategic_domains' =>  $strategicDomains,
        ];
        return ResponseBuilder::success($data,200);
    }
    public function getStrategicDomainById(Request $request, $id)
    {
        $strategicDomain = $this->strategicDomainRepository->getById($id);
        if (!$strategicDomain) {
            return ResponseBuilder::error(404);
        }
        return ResponseBuilder::success($strategicDomain,200);
    }
    public function createStrategicDomain(StrategicDomainsRequest $request)
    {
        $validatedData = $request->validated();
        $strategicDomain = $this->strategicDomainRepository->create($validatedData);
        return ResponseBuilder::success($strategicDomain, 201);
    }

    public function updateStrategicDomain(StrategicDomainsRequest $request, $id)
    {
        $validatedData = $request->validated();
        $strategicDomain = $this->strategicDomainRepository->update($id, $validatedData);
        return ResponseBuilder::success($strategicDomain, 200 );
    }

    public function deleteStrategicDomain(Request $request, $id)
    {
       $strategicDomain = $this->strategicDomainRepository->delete($id);
        return ResponseBuilder::success($strategicDomain, 204);
    }
    // enpoints for feeedback
    public function getfeedback()
    {
        $feedback = $this->feedbackRepository->all();
        return ResponseBuilder::success( $feedback,200);
    }
    public function getfeedbackbyKpiid(FeedbackRequest $request, $id)
    {
        $feedback = $this->feedbackRepository->getByKpiId($id);
        if (!$feedback) {
            return ResponseBuilder::error(404);
        }
        return ResponseBuilder::success( $feedback,200);
    }
    public function createfeedback(FeedbackRequest $request, $id)
    {
        $Kpi = Kpi::Find($id);
        $feedback = $this->feedbackRepository->create([
            "comment"   =>  $request['comment'],
            "kpis_id" => $id,
        ]);
        return ResponseBuilder::success( $feedback,200);
    }
    public function updatefeedback(FeedbackRequest $request, $id)
    {
        $feedback = $this->feedbackRepository->update([
            'comment'   =>  $request['comment'],
        ], $id);
        if (!$feedback) {
            return ResponseBuilder::error(404);
        }
        return ResponseBuilder::success( $feedback,200);
    }
    public function deletefeedback(Request $request, $id)
    {
        $result = $this->feedbackRepository->delete($id);
        if (!$result) {
            return ResponseBuilder::success(404);
        }
        return ResponseBuilder::success(200);
    }
}
