<?php

namespace App\Repositories;

use App\Interfaces\DepartmentRepositoryInterface;
use App\Models\Department;
use PhpParser\Node\Stmt\Catch_;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function getDepartmentById($id ,$e) {
        try {
            $department = Department::find($id);
            return $department;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Record not found'], 404);
        }
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

        $department = Department::find($id);
        $department->update($data);
        return $department;
    }

    public function deleteDepartment($id, $e) {
            $department = Department::find($id);
            $department->delete();
            return true;
    }
    public function getMembers($id, $e){
            $department = Department::find($id);
            $members = $department->users;
            return $members;

    }
}
