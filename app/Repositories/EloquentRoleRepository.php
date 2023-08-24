<?php

namespace App\Repositories;

use App\Models\Role;

class EloquentRoleRepository implements RoleRepository{
    public function getAllRoles()
    {

        $role = Role::all();
        return $role;

    }



    public function getRoleById($id)
    {
        return Role::findOrFail($id);
    }

    public function createRole($data)
    {
        return Role::create($data);
    }

    public function updateRole($id, $data)
    {
        $role = Role::findOrFail($id);
        $role->update($data);
        return $role;
    }

    public function deleteRole($id)
    {
        $role = Role::find($id);
        $role->delete();
        return true;
    }
}
