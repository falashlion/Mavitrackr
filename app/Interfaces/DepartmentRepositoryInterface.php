<?php

namespace App\interfaces;

use App\Models\Department;

interface DepartmentRepositoryInterface {
    public function getDepartmentById($id, $e);
    public function getDepartments();
    public function createDepartment(array $data);
    public function updateDepartment($id, array $data, $e);
    public function deleteDepartment($id, $e);
    public function getMembers($id, $e);

}
