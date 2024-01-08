<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;

interface UserRepositoryInterface {

    public function createUser(array $data):User;
    public function getUserById(string $id):User;
    public function updateUser(string $id, array $data):User;
    public function deleteUser(string $id):bool;
    public function getUsers($request):?Paginator;
    public function getAllDirectReports():array;
    public function getAllDirectReportsById(string $id):array;
    public function getDepartmentMembers():array;
}

