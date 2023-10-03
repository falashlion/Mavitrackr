<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\User;
use App\Interfaces\UserRepositoryInterface;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;


class UserRepository implements UserRepositoryInterface
{
    public function createUser($data)
    {
        $user = User::create($data);
        return $user;
    }
    public function getUserById($id, $e)
    {
            $user = User::findorFail($id);
            $user->position;
            $user->department;
            $user->lineManager;
            $user->roles;
            return $user;
    }
    public function updateUser($id, array $data, $e)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }
    public function deleteUser($id ,$e)
    {
        $user = User::findOrFail($id);
        $department = Department::where('manager_id', $id)->first();
        if ($department) {
            $department->manager_id = null;
            $department->save();
        }
        User::where('line_manager', $id)->update(['line_manager' => null]);
        $user->delete();
        return true;
    }
    public function getUsers($data)
    {
            $page = $data->query('paginate') ?? '8';
            $users = User::select()->paginate($page);
            foreach ($users as $user){
            $user->position;
            $user->department;
            $user->lineManager;
            $user->roles;
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
    public function getAllDirectReports()
    {
        $userDetails = auth()->user();
        $userDirectReports = $userDetails->employees;
        foreach($userDirectReports as $userDirectReport){
        $userDirectReport->position;
        $userDirectReport->department;
        $userDirectReport->lineManager;
        $userDirectReport->roles;
        }
        return $userDirectReports;
    }

    public function getAllDirectReportsById($id, $e)
    {
        $user = User::findOrFail($id);
        $userDirectReports = $user->employees;
        foreach($userDirectReports as $userDirectReport){
        $userDirectReport->position;
        $userDirectReport->department;
        $userDirectReport->lineManager;
        $userDirectReport->roles;
        }
        return $userDirectReports;
    }
}
