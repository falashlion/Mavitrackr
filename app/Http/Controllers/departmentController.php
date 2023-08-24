<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
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
            // return response()->json([
            //     'status' => 'error',
            //     'message' => 'department could not found',
            // ],JsonResponse::HTTP_NOT_FOUND);
            return ResponseBuilder::error(404);
        }
        // return response()->json([
        //     'status' => 'success',
        //     'data' => $department,
        // ], JsonResponse::HTTP_OK);
        return ResponseBuilder::success($department);
    }

    public function getdepartments(Request $request) {

        $departments = $this->departmentRepository->getAllDepartments($request->paginate ? $request->paginate : 'all');
        return ResponseBuilder::success($departments);

    }

    public function createdepartments(DepartmentRequest $request) {
        $validatedData = $request->validated();
        $department = $this->departmentRepository->createDepartment($validatedData);
        // return response()->json([
        //     'status' => 'success',
        //     'data' => $department,
        //     'message' => 'Department created successfully.',
        // ], JsonResponse::HTTP_CREATED);
        return ResponseBuilder::success($department);

    }

    public function updatedepartments(DepartmentRequest $request, $id) {
        $validatedData = $request->validated();
        $department = $this->departmentRepository->updateDepartment($id, $validatedData);
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Department updated successfully.',
        // ], JsonResponse::HTTP_OK);
        return ResponseBuilder::success($department);

    }

    public function deletedepartments(Request $request, $id)
    {
       $department = $this->departmentRepository->deleteDepartment($id);
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Department deleted successfully.',
        // ],JsonResponse::HTTP_OK);
        return ResponseBuilder::success($department);

    }




}

