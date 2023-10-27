<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentUpdateRequest;
use App\interfaces\DepartmentRepositoryInterface;
use App\Http\Controllers\Controller;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use App\Http\Requests\DepartmentRequest;


class departmentController extends Controller {
    private $departmentRepository;
    public function __construct(DepartmentRepositoryInterface $departmentRepository) {
        $this->departmentRepository = $departmentRepository;
        $this->middleware('jwt.auth');
        $this->middleware('permission:departments edit')->only('updateDepartmentDetails');
        $this->middleware('permission:departments list')->only('getAllDepartments');
        $this->middleware('permission:departments delete')->only('deleteDepartmentDetails');
        $this->middleware('permission:departments create')->only('createNewDepartment');
    }

    /**
     * getdepartmentsbyid
     *
     * @param  string $id
     * @return object
     * @expectedException
     */
    public function getdepartmentsbyid($id) {
        $department = $this->departmentRepository->getDepartmentById($id);

        return ResponseBuilder::success($department,200);
    }
    /**
     * getAllDepartments
     *
     * @return object
     */
    public function getAllDepartments() {
        $departments = $this->departmentRepository->getDepartments();

        return ResponseBuilder::success($departments,200);
    }
    /**
     * createNewDepartment
     *
     * @param  object $request
     * @return object
     */
    public function createNewDepartment(DepartmentRequest $request) {
        $validatedData = $request->validated();
        $department = $this->departmentRepository->createDepartment($validatedData);

        return ResponseBuilder::success($department,201,null,201);
    }
    /**
     * updateDepartmentDetails
     *
     * @param  object $request
     * @param  string $id
     * @return object
     */
    public function updateDepartmentDetails(DepartmentUpdateRequest $request, $id) {
        $validatedData = $request->validated();
        $department = $this->departmentRepository->updateDepartment($id, $validatedData);

        return ResponseBuilder::success($department,200);
    }
    /**
     * deleteDepartmentDetails
     *
     * @param  string $id
     * @return object
     */
    public function deleteDepartmentDetails($id)
    {
        $department = $this->departmentRepository->deleteDepartment($id);

        return ResponseBuilder::success($department,204,null,204);
    }
    /**
     * getDepartmentMembers
     *
     * @param  string $id
     * @return object
     */
    public function getDepartmentMembers($id)
    {
        $department = $this->departmentRepository->getMembers($id);

        return ResponseBuilder::success($department,200);
    }
}

