<?php

namespace App\Interfaces;


interface UserRepositoryInterface {
    public function createUser(array $data);
    public function getUserById($id, $e);
    public function updateUser($id, array $data, $e);
    public function deleteUser($id, $e);
    public function getUsers($request);
    public function getAllDirectReports();
    public function getAllDirectReportsById($id, $e);
    public function getDepartmentMembers();
}

