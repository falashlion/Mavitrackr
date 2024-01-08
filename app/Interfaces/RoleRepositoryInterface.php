<?php

namespace App\interfaces;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

interface RoleRepositoryInterface
{
    public function getAllRoles():Collection;
    public function getRoleById(string $id):Role;
    public function createRole(array $data):Role ;
    public function updateRole(string $id, array $data):Role;
    public function deleteRole(string $id):bool;
}
