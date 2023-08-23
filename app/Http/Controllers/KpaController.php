<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\KpaRepository;
use App\Http\Requests\KpaRequest;
use App\Http\Controllers\Controller;

class KpaController extends Controller
{
    protected $KpaRepository;
    public function __construct(KpaRepository $KpaRepository)
    {
        $this->KpaRepository = $KpaRepository;
    }
    public function getKpa(Request $request)
    {
        $kpas = $this->KpaRepository->getAllKpa($request-> paginate ? $request -> paginate : 'all');
        $data=[
            'key_performance_areas'=>$kpas
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], JsonResponse::HTTP_OK);
    }

    public function getKpabyid(Request $request, $id)
    {
        $kpa = $this->KpaRepository->getKpaById($id);
        $data=[
            'key_performance_areas'=>$kpa
        ];
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], JsonResponse::HTTP_OK);
    }

    public function createKpa(KpaRequest $request)
    {
        $kpa = $this->KpaRepository->createKpa($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $kpa,
            'message' => 'key performance area created successfully.',
        ], JsonResponse::HTTP_OK);
    }

    public function updateKpa(KpaRequest $request, $id)
    {
        $kpa = $this->KpaRepository->updateKpa($id, $request->all());

        return response()->json([
            'status' => 'updated',
            'message' => 'key performance area updated',
            'Kpa' => $kpa,
        ], JsonResponse::HTTP_OK);
    }

    public function deleteKpa(Request $request, $id)
    {
        $this->KpaRepository->deleteKpa($id);

        return response()->json([
            'status' => 'success',
            'message' => 'key performance area successfully deleted',
        ], JsonResponse::HTTP_OK);
    }
}
