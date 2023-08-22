<?php

namespace App\Repositories;
use App\Models\User;

interface UserRepository {
    public function createUser(array $data);
    public function getUserById($id);
    public function updateUser($id, array $data);
    public function deleteUser($id);
    public function getAllUsers($paginate);
}

