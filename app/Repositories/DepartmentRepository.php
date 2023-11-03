<?php

namespace App\Repositories;

use App\Interfaces\DepartmentRepositoryInterface;
use App\Models\Department;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    /**
     * getDepartmentById
     *
     * @param  string $id
     * @return object $department
     */
    public function getDepartmentById($id) {
        $department = Department::findOrFail($id);

        return $department;
    }

    /**
     * getDepartments
     *
     * @return object Returns the array of department objects
     *
     */
    public function getDepartments() {
        $departments = Department::all('*');

        return $departments;
    }

    /**
     * createDepartment
     *
     * @param  array $data array of properties to create a department
     * @return object Returns the object of the created departmnet
     */
    public function createDepartment(array $data) {
        $department = Department::create($data);

        return $department;
    }

    /**
     * updateDepartment
     *
     * @param  string $id ID of the Department
     * @param  array $data data to update a department with
     * @return object Returns the object of the updated department.
     */
    public function updateDepartment($id, array $data) {
        $department = Department::findOrFail($id);
        $department->update($data);

        return $department;
    }

    /**
     * deleteDepartment
     *
     * @param  string $id ID of the departmnet
     * @return boolean Returns a boolean true if the the department is successfully deleted and false otherwise.
     */
    public function deleteDepartment($id) {
            $department = Department::findOrFail($id);
            $department->delete();

            return true;
    }
    /**
     * getMembers
     *
     * @param  string $id ID of the Department
     * @return object Returns the array of users in this department
     */
    public function getMembers($id){
            $department = Department::findOrFail($id);
            $members = $department->users;

            return $members;

    }
}
