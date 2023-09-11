<?php

namespace App\Http\Controllers;

use App\interfaces\KpaRepositoryInterface;
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
    public function __construct(KpaRepositoryInterface $KpaRepository)
    {
        $this->KpaRepository = $KpaRepository;
    }
    public function getAllKpa()
    {
        $kpas = $this->KpaRepository->getAll();
        return ResponseBuilder::success($kpas,200);
    }

    public function getKpaById(Request $request, $id)
    {
        $kpa = $this->KpaRepository->getById($id);
        return ResponseBuilder::success($kpa,200);
    }

    public function createKpa(KpaRequest $request)
    {
        $kpa = $this->KpaRepository->create($request->all());
        return ResponseBuilder::success($kpa,200);
    }

    public function updateKpa(KpaRequest $request, $id)
    {
        $kpa = $this->KpaRepository->update($id, $request->all());
        return ResponseBuilder::success($kpa,200);
    }

    public function deleteKpa(Request $request, $id)
    {
       $kpa = $this->KpaRepository->delete($id);
       return ResponseBuilder::success($kpa,204);
    }
}
