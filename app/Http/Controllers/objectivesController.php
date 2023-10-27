<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kpi;
use App\Http\Requests\FeedbackRequest;
use App\Http\Requests\StrategicDomainsRequest;
use App\Repositories\StrategicDomainRepository;
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
    /**
     * getStrategicDomains
     *
     * @return object
     */
    public function getStrategicDomains()
    {
        $strategicDomains = $this->strategicDomainRepository->getAll();
        $data=
        [
            'strategic_domains' =>  $strategicDomains,
        ];

        return ResponseBuilder::success($data,200);
    }
    /**
     * getStrategicDomainById
     *
     * @param  string $id
     * @return object
     */
    public function getStrategicDomainById($id)
    {
        $strategicDomain = $this->strategicDomainRepository->getById($id);

        return ResponseBuilder::success($strategicDomain,200);
    }
    /**
     * createStrategicDomain
     *
     * @param  mixed $request
     * @return object
     */
    public function createStrategicDomain(StrategicDomainsRequest $request)
    {
        $strategicDomain = $this->strategicDomainRepository->create($request->all());

        return ResponseBuilder::success($strategicDomain, 201,null,201);
    }

    /**
     * updateStrategicDomain
     *
     * @param  mixed $request
     * @param  string $id
     * @return object
     */
    public function updateStrategicDomain(StrategicDomainsRequest $request, $id)
    {
        $strategicDomain = $this->strategicDomainRepository->update($id, $request->all());

        return ResponseBuilder::success($strategicDomain, 200 );
    }

    /**
     * deleteStrategicDomain
     *
     * @param  string $id
     * @return object
     */
    public function deleteStrategicDomain($id)
    {
       $strategicDomain = $this->strategicDomainRepository->delete($id);

       return ResponseBuilder::success($strategicDomain, 204, null,204);
    }
    // enpoints for feeedback
    /**
     * getfeedback
     *
     * @return object
     */
    public function getfeedback()
    {
        $feedback = $this->feedbackRepository->all();

        return ResponseBuilder::success( $feedback,200);
    }
    /**
     * getfeedbackbyKpiid
     *
     * @param  mixed $request
     * @param  string $id
     * @return object
     */
    public function getfeedbackbyKpiid(FeedbackRequest $request, $id)
    {
        $feedback = $this->feedbackRepository->getByKpiId($id);
        if (!$feedback) {
            return ResponseBuilder::error(404);
        }
        return ResponseBuilder::success( $feedback,200);
    }
    /**
     * createfeedback
     *
     * @param  mixed $request
     * @param  string $id
     * @return object
     */
    public function createfeedback(FeedbackRequest $request, $id)
    {
        $Kpi = Kpi::Find($id);
        $feedback = $this->feedbackRepository->create([
            "comment"   =>  $request['comment'],
            "kpis_id" => $id,
        ]);

        return ResponseBuilder::success( $feedback,201,null,201);
    }
    /**
     * updatefeedback
     *
     * @param  mixed $request
     * @param  string $id
     * @return object
     */
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
    /**
     * deletefeedback
     *
     * @param  mixed $request
     * @param  string $id
     * @return object
     */
    public function deletefeedback(Request $request, $id)
    {
        $result = $this->feedbackRepository->delete($id);
        if (!$result) {

            return ResponseBuilder::success(404);
        }

        return ResponseBuilder::success($result,204,null,204);
    }
}
