<?php

namespace App\Repositories;

use App\Models\User;

class EloquentUserRepository implements UserRepository {
    public function createUser(array $data) {
        $user = User::create($data);
        return $user;
    }

    public function getUserById($id) {
        $user = User::find($id);
        // APP_URL
        return $user;
    }

    public function updateUser($id, array $data) {
        $user = User::find($id);
        $user->update($data);
        return $user;
    }

    public function deleteUser($id) {
        $user = User::find($id);
        $user->delete();
    }

    public function getAllUsers() {

        $users = User::all();
        return $users;
    }

    public function getDepartmentMembers($id)
     {
        $users = User::all()->where('departments_id', $id);
        return $users;
     }

}
