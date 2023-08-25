<?php

namespace App\Http\Controllers;

use App\Models\Kpa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\KpaRepository;
use App\Http\Requests\KpaRequest;
use App\Http\Controllers\Controller;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class KpaController extends Controller
{
    protected $KpaRepository;
    public function __construct(KpaRepository $KpaRepository)
    {
        $this->KpaRepository = $KpaRepository;
    }
    public function getKpa(Request $request)
    {
        $page = $request->query('paginate') ?? '10';
         $kpas = Kpa::paginate($page);
        // $kpas = $this->KpaRepository->getAllKpa($request);
        return ResponseBuilder::success($kpas);
    }

    public function getKpabyid(Request $request, $id)
    {
        $kpa = $this->KpaRepository->getKpaById($id);
        return ResponseBuilder::success($kpa);
    }

    public function createKpa(KpaRequest $request)
    {
        $kpa = $this->KpaRepository->createKpa($request->all());

        return ResponseBuilder::success($kpa);
    }

    public function updateKpa(KpaRequest $request, $id)
    {
        $kpa = $this->KpaRepository->updateKpa($id, $request->all());

        return ResponseBuilder::success($kpa);
    }

    public function deleteKpa(Request $request, $id)
    {
       $kpa = $this->KpaRepository->deleteKpa($id);

       return ResponseBuilder::success($kpa);
    }
}
