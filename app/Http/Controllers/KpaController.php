<?php

namespace App\Http\Controllers;

use App\interfaces\KpaRepositoryInterface;
use App\Http\Requests\KpaRequest;
use App\Http\Controllers\Controller;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class KpaController extends Controller
{
    protected $KpaRepository;
    public function __construct(KpaRepositoryInterface $KpaRepository)
    {
        $this->KpaRepository = $KpaRepository;
        $this->middleware('jwt.auth');
        $this->middleware('permission:kpas edit')->only('updateKpa');
        $this->middleware('permission:kpas list')->only('getAllKpa');
        $this->middleware('permission:kpas delete')->only('deleteKpa');
        $this->middleware('permission:kpas create')->only('createKpa');
    }
    /**
     * getAllKpa
     *
     * @return object
     */
    public function getAllKpa()
    {
        $kpas = $this->KpaRepository->getAll();
        return ResponseBuilder::success($kpas,200);
    }

    /**
     * getKpaById
     *
     * @param  string $id
     * @return object
     */
    public function getKpaById($id)
    {
        $kpa = $this->KpaRepository->getById($id);
        return ResponseBuilder::success($kpa,200);
    }

    /**
     * createKpa
     *
     * @param  object $request
     * @return object
     */
    public function createKpa(KpaRequest $request)
    {
        $kpa = $this->KpaRepository->create($request->all());
        return ResponseBuilder::success($kpa,201,null,201);
    }

    /**
     * updateKpa
     *
     * @param  object $request
     * @param  string $id
     * @return object
     */
    public function updateKpa(KpaRequest $request, $id)
    {
        $kpa = $this->KpaRepository->update($id,$request->all());
        return ResponseBuilder::success($kpa,200);
    }

    /**
     * deleteKpa
     *
     * @param  string $id
     * @return object
     */
    public function deleteKpa($id)
    {
        $kpa = $this->KpaRepository->delete($id);
        return ResponseBuilder::success($kpa,204,null,204);
    }
}
