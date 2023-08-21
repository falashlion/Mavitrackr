<?php

namespace App\Repositories;

use App\Models\Department;

interface DepartmentRepository {
    public function getDepartmentById($id);
    public function getAllDepartments();
    public function createDepartment(array $data);
    public function updateDepartment($id, array $data);
    public function deleteDepartment($id);
}
