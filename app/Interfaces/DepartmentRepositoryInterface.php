<?php

namespace App\interfaces;

use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;

interface DepartmentRepositoryInterface {
    public function getDepartmentById(string $id):Department;
    public function getDepartments():Collection;
    public function createDepartment(array $data):Department;
    public function updateDepartment(string $id, array $data):Department;
    public function deleteDepartment(string $id):bool;
    public function getMembers(string $id):Collection;

}
