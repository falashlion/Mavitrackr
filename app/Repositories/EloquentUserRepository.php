<?php

namespace App\Repositories;

use App\Http\Requests\UserStoreRequest;
use App\Models\Role;
use App\Models\User;
use App\Repositories\UserRepository as UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EloquentUserRepository implements UserRepositoryInterface
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
        $user->lineManager;
        $user->kpis;
        }
        return $users;
    }

    public function getDepartmentMembers()
     {
        if ('departments_id' === auth()->user()->departments_id){
        $users = User::all();
        return $users;
        }

     }

}
