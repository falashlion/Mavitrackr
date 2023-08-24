<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\DepartmentRequest;
use App\Repositories\DepartmentRepository;


class departmentController extends Controller {
    protected $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository) {
        $this->departmentRepository = $departmentRepository;
    }

    public function getdepartmentsbyid(Request $request, $uuid) {
        $department = $this->departmentRepository->getDepartmentById($uuid);
        if (!$department) {
            return response()->json([
                'status' => 'error',
                'message' => 'department could not found',
            ],JsonResponse::HTTP_NOT_FOUND);
        }
        return response()->json([
            'status' => 'success',
            'data' => $department,
        ], JsonResponse::HTTP_OK);
    }

    public function getdepartments(Request $request) {
        $user = auth()->user();
       dd($user);
        $departments = $this->departmentRepository->getAllDepartments($request->paginate ? $request->paginate : 'all');
        // dd($request->paginate);
        return response()->json([
            'status' => 'success',
            'data' => $departments,
        ],JsonResponse::HTTP_OK);
    }

    public function createdepartments(DepartmentRequest $request) {
        $validatedData = $request->validated();
        $department = $this->departmentRepository->createDepartment($validatedData);
        return response()->json([
            'status' => 'success',
            'data' => $department,
            'message' => 'Department created successfully.',
        ], JsonResponse::HTTP_CREATED);
    }

    public function updatedepartments(DepartmentRequest $request, $id) {
        $validatedData = $request->validated();
        $department = $this->departmentRepository->updateDepartment($id, $validatedData);
        return response()->json([
            'status' => 'success',
            'message' => 'Department updated successfully.',
        ], JsonResponse::HTTP_OK);
    }

    public function deletedepartments(Request $request, $id)
    {
        $this->departmentRepository->deleteDepartment($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Department deleted successfully.',
        ],JsonResponse::HTTP_OK);
    }




}

