<?php

namespace App\Repositories;

use App\Models\Department;
use App\Models\User;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;



class UserRepository implements UserRepositoryInterface
{
    /**
     * Creates a new user
     *
     * @param  array $data An array of data to create the user with
     * @return User Returns an object containing the newly created user data
     */
    public function createUser($data):User
    {
        $user = User::create($data);

        return $user;
    }
    /**
     * Retrieves a user by thier user id
     *
     * @param  string $id The ID of the user to retrieve
     * @return User Returns an object containing the user data
     */
    public function getUserById($id):User
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
     * Updates an existing user
     *
     * @param  string $id The ID of the user to update
     * @param  array $data An array of data to update the user with
     * @return User Returns an object containing the updated user data
     */
    public function updateUser($id, array $data):User
    {
        $user = User::findOrFail($id);
        $user->update($data);

        return $user;
    }
    /**
     * deleteUser
     *
     * Deletes a user by ID
     *
     * @param  string $id The ID of the user to delete
     * @return boolean Returns true if the user was successfully deleted, false otherwise
     */
    public function deleteUser(string $id):bool
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
     * Retrieves all users
     * @param Request $request
     * @return ?Paginator
     *  Returns an object containing all users in the application
     */
    public function getUsers($request):?Paginator
    {
        $page = $request->input('paginate', 8);
        $users = User::with('position', 'department', 'lineManager', 'roles')->paginate($page);

        return $users;
    }

    /**
     * getDepartmentMembers
     *
     * Retrieves all users in a department which the the authenticated user belongs to.
     *
     * @return array Returns an object containing all users in the department
     */
    public function getDepartmentMembers(): array
     {
        $department = auth()->user()->departments_id;
        $users = User::where('departments_id',$department)->with('user', 'user.position','user.lineManager', 'user.roles')->get();

        return $users;
     }
    /**
     * getAllDirectReports
     *
     * Retrieves all users that directly report to the authenticated user
     *
     * @return array Returns an object containing all direct reports of the authenticated user
     */
    public function getAllDirectReports():array
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
     * Retrieves all direct reports of a user by thier user Id
     * @param  string $id The ID of the user to retrieve direct reports for
     * @return array Returns an object containing all direct reports of the user with the given ID
     */
    public function getAllDirectReportsById(string $id):array
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
