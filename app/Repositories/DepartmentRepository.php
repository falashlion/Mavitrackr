<?php

namespace App\Repositories;

use App\Models\Department;

interface DepartmentRepository {
    public function getDepartmentById($uuid);
    public function getAllDepartments($paginate);
    public function createDepartment(array $data);
    public function updateDepartment($id, array $data);
    public function deleteDepartment($id);
}
