<?php

namespace App\Repositories;

use App\Http\Requests\UserStoreRequest;
use App\Models\Role;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EloquentUserRepository implements UserRepository
{

    public function createUser(array $data)
    {

        $user = User::create($data);
        return $user;
    }

    public function getUserById($id)
    {
        $user = User::find($id);
        return $user;
    }


    public function updateUser($id, array $data)
    {
        $user = User::find($id);
        $user->update($data);
        return $user;
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
    }

    public function getAllUsers($data)
    {
        $page = $data->query('paginate') ?? '10';
         $users = User::paginate($page);
        foreach ($users as $user){
         $user->role;
         $user->positions_id;
         $user->department->title;
        // $managerData = $user->department->manager->only('first_name', 'last_name', 'profile_image');
        $user->profile_image = config('app.url') . "/storage/" . $user->profile_image;
        }
        return $users;
    }

    public function getDepartmentMembers($id)
     {
        $users = User::all()->where('departments_id', $id);
        return $users;
     }

}
