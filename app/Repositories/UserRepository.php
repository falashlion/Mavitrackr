<?php

namespace App\Repositories;
use App\Models\User;

interface UserRepository {
    public function createUser(array $data);
    public function getUserById($id);
    public function updateUser($id, array $data);
    public function deleteUser($id);
    public function getAllUsers();
}
// class EloquentUserRepository implements UserRepository {
//     public function createUser(array $data) {
//         $user = User::create($data);
//         return $user;
//     }

//     public function getUserById($id) {
//         $user = User::find($id);
//         return $user;
//     }

//     public function updateUser($id, array $data) {
//         $user = User::find($id);
//         $user->update($data);
//         return $user;
//     }

//     public function deleteUser($id) {
//         $user = User::find($id);
//         $user->delete();
//     }
// }
