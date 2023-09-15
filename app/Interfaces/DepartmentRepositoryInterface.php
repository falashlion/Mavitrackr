<?php

namespace App\interfaces;

use App\Models\Department;

interface DepartmentRepositoryInterface {
    public function getDepartmentById($uuid);
    public function getDepartments();
    public function createDepartment(array $data);
    public function updateDepartment($id, array $data);
    public function deleteDepartment($id);
    public function getMembers($id);

}
