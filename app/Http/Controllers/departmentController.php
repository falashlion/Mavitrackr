<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentUpdateRequest;
use App\interfaces\DepartmentRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use App\Http\Requests\DepartmentRequest;
use Exception;

class departmentController extends Controller {
    private $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository) {
        $this->departmentRepository = $departmentRepository;
        $this->middleware('jwt.auth');
    }

    public function getdepartmentsbyid(Request $request, $id, Exception $e) {
       try {
        $department = $this->departmentRepository->getDepartmentById($id, $e);
        return ResponseBuilder::success($department,200);
       } catch (\Throwable $th) {
        return ResponseBuilder::error(400);
       }
    }
    public function getAllDepartments() {
        $departments = $this->departmentRepository->getDepartments();
        return ResponseBuilder::success($departments,200);
    }
    public function createNewDepartment(DepartmentRequest $request) {
        $validatedData = $request->validated();
        $department = $this->departmentRepository->createDepartment($validatedData);
        return ResponseBuilder::success($department,200);
    }
    public function updateDepartmentDetails(DepartmentUpdateRequest $request, $id, Exception $e) {
        try {
            $validatedData = $request->validated();
            $department = $this->departmentRepository->updateDepartment($id, $validatedData, $e);
        return ResponseBuilder::success($department,200);
        } catch (\Throwable $th) {
            return ResponseBuilder::error(400);
        }
    }
    public function deleteDepartmentDetails($id, Exception $e)
    {
        try {
            $department = $this->departmentRepository->deleteDepartment($id, $e);
            return ResponseBuilder::success($department,204);
        } catch (\Throwable $th) {
            return ResponseBuilder::error(400);
        }
    }

    public function getDepartmentMembers($id, Exception $e)
    {
        try {
            $department = $this->departmentRepository->getMembers($id, $e);
            return ResponseBuilder::success($department,200);
        } catch (\Throwable $th) {
            return ResponseBuilder::error(400);
        }
    }
}

