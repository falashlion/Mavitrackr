<?php

namespace App\Repositories;

use App\Interfaces\DepartmentRepositoryInterface;
use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    /**
     * getDepartmentById
     *
     * @param  string $id
     * @return Department $department
     */
    public function getDepartmentById(string $id):Department
    {
        $department = Department::findOrFail($id);

        return $department;
    }

    /**
     * getDepartments
     *
     * @return Collection Returns the array of department objects
     *
     */
    public function getDepartments():Collection
    {
        $departments = Department::all('*');

        return $departments;
    }

    /**
     * createDepartment
     *
     * @param  array $data array of properties to create a department
     * @return Department  Returns the object of the created departmnet
     */
    public function createDepartment(array $data):Department
    {
        $department = Department::create($data);

        return $department;
    }

    /**
     * @param  string $id ID of the Department
     * @param  array $data data to update a department with
     * @return Department Returns the object of the updated department.
     */
    public function updateDepartment(string $id, array $data):Department
    {
        $department = Department::findOrFail($id);
        $department->update($data);

        return $department;
    }

    /**
     * deletes a Department by it's id
     * @param  string $id ID of the departmnet
     * @return bool Returns a boolean true if the the department is successfully deleted and false otherwise.
     */
    public function deleteDepartment($id):bool
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return true;
    }
    /**
     * gets Members of a department by the department's id
     * @param  string $id ID of the Department
     * @return Collection Returns the array of users in this department
     */
    public function getMembers(string $id): Collection
    {
        $department = Department::findOrFail($id);
        $members = $department->users;

        return $members;

    }
}
