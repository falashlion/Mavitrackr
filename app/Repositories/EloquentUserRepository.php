<?php

namespace App\Repositories;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EloquentUserRepository implements UserRepository {

    public function createUser()
    {
        $user = User::create();
        return $user;
    }

    public function getUserById($id) {
        $user = User::find($id);
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

    public function getAllUsers($data) {
        $page = $data->query('paginate') ?? '10';
         $users = User::paginate($page);
        foreach ($users as $user){
        $role = $user->roles;
        $position = $user->position->title;
        $departmentManagerID = $user->department->title;
        // $managerData = $user->department->manager->only('first_name', 'last_name', 'profile_image');
        }
        return $users;
    }

    public function getDepartmentMembers($id)
     {
        $users = User::all()->where('departments_id', $id);
        return $users;
     }

}
