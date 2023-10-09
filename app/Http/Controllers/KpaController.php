<?php

namespace App\Http\Controllers;

use App\interfaces\KpaRepositoryInterface;
use App\Models\Kpa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\KpaRepository;
use App\Http\Requests\KpaRequest;
use App\Http\Controllers\Controller;
use Exception;
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
    public function getAllKpa()
    {
        $kpas = $this->KpaRepository->getAll();
        return ResponseBuilder::success($kpas,200);
    }

    public function getKpaById($id, Exception $e)
    {
        $kpa = $this->KpaRepository->getById($id, $e);
        return ResponseBuilder::success($kpa,200);
    }

    public function createKpa(KpaRequest $request)
    {
        $kpa = $this->KpaRepository->create($request->all());
        return ResponseBuilder::success($kpa,201,null,201);
    }

    public function updateKpa(KpaRequest $request, $id, Exception $e)
    {
        $kpa = $this->KpaRepository->update($id, $e, $request->all());
        return ResponseBuilder::success($kpa,200);
    }

    public function deleteKpa($id, Exception $e)
    {
        $kpa = $this->KpaRepository->delete($id, $e);
        return ResponseBuilder::success($kpa,204,null,204);
    }
}
