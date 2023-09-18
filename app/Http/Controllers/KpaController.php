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
    }
    public function getAllKpa()
    {
        $kpas = $this->KpaRepository->getAll();
        return ResponseBuilder::success($kpas,200);
    }

    public function getKpaById(Request $request, $id, Exception $e)
    {
        try {
            $kpa = $this->KpaRepository->getById($id, $e);
            return ResponseBuilder::success($kpa,200);
        } catch (\Throwable $th) {
            return ResponseBuilder::error(400);
        }
    }

    public function createKpa(KpaRequest $request)
    {
        $kpa = $this->KpaRepository->create($request->all());
        return ResponseBuilder::success($kpa,200);
    }

    public function updateKpa(KpaRequest $request, $id, Exception $e)
    {
        try {
            $kpa = $this->KpaRepository->update($id, $request->all(), $e);
            return ResponseBuilder::success($kpa,200);
        } catch (\Throwable $th) {
            return ResponseBuilder::error(400);
        }
    }

    public function deleteKpa(Request $request, $id, Exception $e)
    {
        try {
            $kpa = $this->KpaRepository->delete($id, $e);
            return ResponseBuilder::success($kpa,204);
        } catch (\Throwable $th) {
            return ResponseBuilder::error(400);
        }

    }
}
