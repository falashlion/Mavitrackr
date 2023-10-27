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
     * @return object
     */
    public function getDepartmentById($id) {
        $department = Department::findOrFail($id);

        return $department;
    }

    /**
     * getDepartments
     *
     * @return object
     *
     */
    public function getDepartments() {
        $departments = Department::all('*');

        return $departments;
    }

    /**
     * createDepartment
     *
     * @param  array $data
     * @return object
     */
    public function createDepartment(array $data) {
        $department = Department::create($data);

        return $department;
    }

    /**
     * updateDepartment
     *
     * @param  string $id
     * @param  array $data
     * @return object
     */
    public function updateDepartment($id, array $data) {
        $department = Department::findOrFail($id);
        $department->update($data);

        return $department;
    }

    /**
     * deleteDepartment
     *
     * @param  string $id
     * @return boolean
     */
    public function deleteDepartment($id) {
            $department = Department::findOrFail($id);
            $department->delete();

            return true;
    }
    /**
     * getMembers
     *
     * @param  string $id
     * @return object
     */
    public function getMembers($id){
            $department = Department::findOrFail($id);
            $members = $department->users;

            return $members;

    }
}
