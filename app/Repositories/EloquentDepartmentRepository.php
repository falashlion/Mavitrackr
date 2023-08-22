<?php

namespace App\Repositories;

use App\Models\Department;

class EloquentDepartmentRepository implements DepartmentRepository {
    public function getDepartmentById($id) {
        $department = Department::find($id);
        return $department;
    }

    public function getAllDepartments($paginate) {
        if($paginate == 'all'){
            $departments = Department::all();
        }
        else{

            $departments = Department::paginate($paginate);
        }
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
}
