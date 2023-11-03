<?php

namespace App\Interfaces;


interface UserRepositoryInterface {

    public function createUser(array $data);
    public function getUserById(string $id);
    public function updateUser(string $id, array $data);
    public function deleteUser(string $id);
    public function getUsers($request);
    public function getAllDirectReports();
    public function getAllDirectReportsById($id);
    public function getDepartmentMembers();
}

