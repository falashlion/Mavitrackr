<?php

namespace App\Interfaces;


interface UserRepositoryInterface {
    public function createUser($data);
    public function getUserById($id);
    public function updateUser($id, array $data);
    public function deleteUser($id);
    public function getUsers($request);
    public function getAllDirectReports();
    public function getAllDirectReportsById($id);
    public function getDepartmentMembers();
}

