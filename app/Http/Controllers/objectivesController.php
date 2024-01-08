<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StrategicDomainsRequest;
use App\Repositories\StrategicDomainRepository;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Symfony\Component\HttpFoundation\Response;

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
     * @return Response Returns the object of all the strategic domains
     */
    public function getStrategicDomains():Response
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
     * @param  string $id ID of Strategic Domain
     * @return Response Returns the object of the Strategic domain with the ID
     */
    public function getStrategicDomainById(string $id):Response
    {
        $strategicDomain = $this->strategicDomainRepository->getById($id);

        return ResponseBuilder::success($strategicDomain,200);
    }
    /**
     * createStrategicDomain
     *
     * @param  StrategicDomainsRequest $request contains the data to create a new strategic domain
     * @return Response Returns the object of the created strategic domain
     */
    public function createStrategicDomain(StrategicDomainsRequest $request):Response
    {
        $strategicDomain = $this->strategicDomainRepository->create($request->all());

        return ResponseBuilder::success($strategicDomain, 201,null,201);
    }

    /**
     * updateStrategicDomain
     *
     * @param  StrategicDomainsRequest $request contains the data for a strategic to be updated with
     * @param  string $id ID of Strategic Domain
     * @return Response Returns the object of the updated strategic domain
     */
    public function updateStrategicDomain(StrategicDomainsRequest $request, string $id):Response
    {
        $strategicDomain = $this->strategicDomainRepository->update($id, $request->all());

        return ResponseBuilder::success($strategicDomain, 200 );
    }

    /**
     * deleteStrategicDomain
     *
     * @param  string $id ID of Strategic Domain
     * @return Response Returns no content of the resource not found exception.
     */
    public function deleteStrategicDomain(string $id):Response
    {
       $strategicDomain = $this->strategicDomainRepository->delete($id);

       return ResponseBuilder::success($strategicDomain, 204, null,204);
    }

}
