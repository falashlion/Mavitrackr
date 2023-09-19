<?php

namespace App\Repositories;

use App\Interfaces\DepartmentRepositoryInterface;
use App\Models\Department;
use PhpParser\Node\Stmt\Catch_;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function getDepartmentById($id ,$e) {
        $department = Department::findOrFail($id);
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

    public function updateDepartment($id, array $data, $e) {
        $department = Department::findOrFail($id);
        $department->update($data);
        return $department;
    }

    public function deleteDepartment($id, $e) {
            $department = Department::findOrFail($id);
            $department->delete();
            return true;
    }
    public function getMembers($id, $e){
            $department = Department::findOrFail($id);
            $members = $department->users;
            return $members;

    }
}
