<?php

namespace App\Repositories;

use App\interfaces\RoleRepositoryInterface;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class EloquentRoleRepository implements RoleRepositoryInterface{
    /**
     * gets All Roles in database
     *
     * @return Collection
     */
    public function getAllRoles():Collection
    {
        $role = Role::all();

        return $role;
    }
    /**
     * getRoleById
     *
     * @param  string $id
     * @return Role
     */
    public function getRoleById(string $id):Role
    {
        return Role::findOrFail($id);
    }

    /**
     * createRole
     *
     * @param  array $data
     * @return Role
     */
    public function createRole(array $data):Role
    {
        return Role::create($data);
    }

    /**
     * updates an existing Role using it's id
     * @param  string $id
     * @param  array $data
     * @return Role
     */
    public function updateRole(string $id, array $data):Role
    {
        $role = Role::findOrFail($id);
        $role->update($data);

        return $role;
    }

    /**
     * deletes a  Role in the database using its id
     *
     * @param  string $id
     * @return bool
     */
    public function deleteRole(string $id):bool
    {
        $role = Role::find($id);
        $role->delete();

        return true;
    }
}
