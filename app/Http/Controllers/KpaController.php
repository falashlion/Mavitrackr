<?php

namespace App\Http\Controllers;

use App\interfaces\KpaRepositoryInterface;
use App\Http\Requests\KpaRequest;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class KpaController extends Controller
{
    protected $KpaRepository;
    public function __construct(KpaRepositoryInterface $KpaRepository)
    {
        $this->KpaRepository = $KpaRepository;
        $this->middleware('jwt.auth');
        // $this->middleware('permission:kpas edit')->only('updateKpa');
        // $this->middleware('permission:kpas list')->only('getAllKpa');
        // $this->middleware('permission:kpaobjects delete')->only('deleteKpa');
        // $this->middleware('permission:kpas create')->only('createKpa');
    }
    /**
     * getAllKpa
     *
     * @return Response Returns array of all the kpas in the database
     */
    public function getAllKpa()
    {
        $kpas = $this->KpaRepository->getAll();
        return ResponseBuilder::success($kpas,200);
    }

    /**
     * getKpaById
     *
     * @param  string $id ID of the KeyperformanceArea
     * @return Response Returns the object of the kpa with having the ID
     */
    public function getKpaById($id)
    {
        $kpa = $this->KpaRepository->getById($id);
        return ResponseBuilder::success($kpa,200);
    }

    /**
     * createKpa
     *
     * @param  KpaRequest $request Contains the data required to create a new kpa
     * @return Response Returns the object of the created kpa
     */
    public function createKpa(KpaRequest $request)
    {
        $kpa = $this->KpaRepository->create($request->all());
        return ResponseBuilder::success($kpa,201,null,201);
    }

    /**
     * updateKpa
     *
     * @param  KpaRequest $request Contains the data to update the kpa
     * @param  string $id ID of the KeyperformanceArea
     * @return Response Returns object of the updated kpa
     */
    public function updateKpa(KpaRequest $request, $id)
    {
        $kpa = $this->KpaRepository->update($id,$request->all());
        return ResponseBuilder::success($kpa,200);
    }

    /**
     * deleteKpa
     *
     * @param  string $id ID of the KeyperformanceArea
     * @return Response Returns no content or the objecct for the content not found exception.
     */
    public function deleteKpa($id)
    {
        $kpa = $this->KpaRepository->delete($id);
        return ResponseBuilder::success($kpa,204,null,204);
    }
}
