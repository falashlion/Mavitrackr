<?php

namespace App\interfaces;


interface DepartmentRepositoryInterface {
    public function getDepartmentById($id);
    public function getDepartments();
    public function createDepartment(array $data);
    public function updateDepartment($id, array $data);
    public function deleteDepartment($id);
    public function getMembers($id);

}
