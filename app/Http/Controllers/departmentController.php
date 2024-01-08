<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentUpdateRequest;
use App\interfaces\DepartmentRepositoryInterface;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use App\Http\Requests\DepartmentRequest;


class departmentController extends Controller {
    private $departmentRepository;
    public function __construct(DepartmentRepositoryInterface $departmentRepository) {
        $this->departmentRepository = $departmentRepository;
        $this->middleware('jwt.auth');
        // $this->middleware('permission:departments edit')->only('updateDepartmentDetails');
        // $this->middleware('permission:departments list')->only('getAllDepartments');
        // $this->middleware('permission:departments delete')->only('deleteDepartmentDetails');
        // $this->middleware('permission:departments create')->only('createNewDepartment');
    }

    /**
     * getdepartmentsbyid
     *
     * @param  string $id The department id for the department whose information is to be gotten.
     * @return Response ResponseBuilder  The department object is returned
     * @expectedException
     */
    public function getdepartmentsbyid(string $id):Response
    {
        $department = $this->departmentRepository->getDepartmentById($id);

        return ResponseBuilder::success($department,200);
    }
    /**
     * getAllDepartments
     *
     * @return Response returns an object containing the array of all departments
     */
    public function getAllDepartments():Response
    {
        $departments = $this->departmentRepository->getDepartments();

        return ResponseBuilder::success($departments,200);
    }
    /**
     * createNewDepartment
     *
     * @param  DepartmentRequest $request The parameters required to create a department
     * @return Response This returns the object of the created department
     */
    public function createNewDepartment(DepartmentRequest $request):Response
    {
        $validatedData = $request->validated();
        $department = $this->departmentRepository->createDepartment($validatedData);

        return ResponseBuilder::success($department,201,null,201);
    }
    /**
     * updateDepartmentDetails
     *
     * @param  DepartmentUpdateRequest $request The parameters required to update a department
     * @param  string $id Department's ID
     * @return Response This returns the object of the updated department
     */
    public function updateDepartmentDetails(DepartmentUpdateRequest $request, string $id):Response
    {
        $validatedData = $request->validated();
        $department = $this->departmentRepository->updateDepartment($id, $validatedData);

        return ResponseBuilder::success($department,200);
    }
    /**
     * deleteDepartmentDetails
     *
     * @param  string $id Department's ID
     * @return Response
     * This deletes the department from the database
     */
    public function deleteDepartmentDetails($id):Response
    {
        $department = $this->departmentRepository->deleteDepartment($id);

        return ResponseBuilder::success($department,204,null,204);
    }
    /**
     * getDepartmentMembers
     *
     * @param  string $id Department's ID
     * @return Response This returns the object of the users in the Department
     */
    public function getDepartmentMembers($id):Response
    {
        $department = $this->departmentRepository->getMembers($id);

        return ResponseBuilder::success($department,200);
    }
}

