<?php

namespace App\Repositories;

use App\Interfaces\DepartmentRepositoryInterface;
use App\Models\Department;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function getDepartmentById($id) {
        $department = Department::find($id);
        return $department;
    }

    public function getDepartments() {
        $departments = Department::all('*');
        return $departments;
    }

    public function createDepartment(array $data) {
        $department = Department::create($data);
        return $department;
    }

    public function updateDepartment($id, array $data) {
        $department = Department::find($id);
        $department->update($data);
        return $department;
    }

    public function deleteDepartment($id) {
        $department = Department::find($id);
        $department->delete();
    }

    public function getMembers($id){
        $department = Department::find($id);
        $members = $department->users;
        return $members;
    }
}
