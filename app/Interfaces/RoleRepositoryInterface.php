<?php

namespace App\interfaces;

interface RoleRepository
{
    public function getAllRoles();

    public function getRoleById($id);

    public function createRole($data);

    public function updateRole($id, $data);

    public function deleteRole($id);
}
