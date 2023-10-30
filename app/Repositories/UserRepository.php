<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\User;
use App\Interfaces\UserRepositoryInterface;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;


class UserRepository implements UserRepositoryInterface
{
    /**
     * createUser
     *
     * @param  array $data
     * @return object
     */
    public function createUser($data)
    {
        $user = User::create($data);
        return $user;
    }
    /**
     * getUserById
     *
     * @param  string $id
     * @return object
     */
    public function getUserById($id)
    {
            $user = User::findorFail($id);
            $user->position;
            $user->department;
            $user->lineManager;
            $user->roles;
            return $user;
    }
    /**
     * updateUser
     *
     * @param  string $id
     * @param  array $data
     * @return object
     */
    public function updateUser($id, array $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }
    /**
     * deleteUser
     *
     * @param  string $id
     * @return boolean
     */
    public function deleteUser($id)
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
    /**
     * getUsers
     *
     *
     * @return object this returns the object of all the users in the application.
     */
    public function getUsers()
    {
            $users = User::paginate();
            foreach ($users as $user){
            $user->position;
            $user->department;
            $user->lineManager;
            $user->roles;
            }
            return $users;
    }
    /**
     * getDepartmentMembers
     *
     * @return mixed returns the object of the users
     */
    public function getDepartmentMembers()
     {
        $department = 'departments_id' === auth()->user()->departments_id;
        if ($department){
        $users = User::where('departments_id',$department)->with('user', 'user.position','user.lineManager', 'user.roles')->get();
        return $users;
        }
     }
    /**
     * getAllDirectReports
     *
     * @return object
     */
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

    /**
     * getAllDirectReportsById
     *
     * @param  string $id
     * @return object
     */
    public function getAllDirectReportsById($id)
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
