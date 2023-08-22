<?php

namespace App\Http\Controllers;

use App\Models\Department;
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

    public function getdepartmentsbyid(Request $request, $id) {
        $department = $this->departmentRepository->getDepartmentById($id);
        if (!$department) {
            return response()->json([
                'status' => 'error',
                'message' => 'department could not found',
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'data' => $department,
        ]);
    }

    public function getdepartments(Request $request) {
        $departments = $this->departmentRepository->getAllDepartments($request->paginate ? $request->paginate : 'all');
        // dd($request->paginate);
        return response()->json([
            'status' => 'success',
            'data' => $departments,
        ]);
    }

    public function createdepartments(DepartmentRequest $request) {
        $validatedData = $request->validated();
        $department = $this->departmentRepository->createDepartment($validatedData);
        return response()->json([
            'status' => 'success',
            'data' => $department,
            'message' => 'Department created successfully.',
        ]);
    }

    public function updatedepartments(DepartmentRequest $request, $id) {
        $validatedData = $request->validated();
        $department = $this->departmentRepository->updateDepartment($id, $validatedData);
        return response()->json([
            'status' => 'success',
            'message' => 'Department updated successfully.',
        ]);
    }

    public function deletedepartments(Request $request, $id) {
        $this->departmentRepository->deleteDepartment($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Department deleted successfully.',
        ]);
    }

    // endpoints for manager data

    public function getmanager($id) {
        // Implementation code
    }

    public function getdirectreports(Request $request, $id) {
        // Implementation code
    }
}

