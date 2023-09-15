<?php

namespace App\Interfaces;


interface UserRepositoryInterface {
    public function createUser(array $data);
    public function getUserById($id);
    public function updateUser($id, array $data);
    public function deleteUser($id);
    public function getUsers($request);
    public function getAllDirectReports();
    public function getDepartmentMembers();
}
