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
use App\Repositories\DepartmentRepository as DepartmentRepositoryInterface;


class departmentController extends Controller {
    protected $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository) {
        $this->departmentRepository = $departmentRepository;
    }

    public function getdepartmentsbyid(Request $request, $id) {
        $department = $this->departmentRepository->getDepartmentById($id);
        if (!$department) {
            return ResponseBuilder::error(404);
        }
        return ResponseBuilder::success($department,200);
    }

    public function getdepartments(Request $request) {

        $departments = $this->departmentRepository->getAllDepartments($request->paginate ? $request->paginate : 'all');
        return ResponseBuilder::success($departments,200);

    }

    public function createdepartments(DepartmentRequest $request) {
        $validatedData = $request->validated();
        $department = $this->departmentRepository->createDepartment($validatedData);
        return ResponseBuilder::success($department,200);

    }

    public function updatedepartments(DepartmentRequest $request, $id) {
        $validatedData = $request->validated();
        $department = $this->departmentRepository->updateDepartment($id, $validatedData);
        return ResponseBuilder::success($department,200);

    }

    public function deletedepartments(Request $request, $id)
    {
       $department = $this->departmentRepository->deleteDepartment($id);
        return ResponseBuilder::success($department,200);

    }




}

