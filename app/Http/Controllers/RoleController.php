<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\RoleRepository;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class RoleController extends Controller
{
    protected $RoleRepository;
    public function __construct(RoleRepository $RoleRepository)
    {
        $this->RoleRepository = $RoleRepository;
    }
    public function getRoles(Request $request)
    {
        $roles = $this->RoleRepository->getAllRoles();
        return ResponseBuilder::success($roles, 200 );
    }

    public function getRolebyid(Request $request, $id)
    {
        $role = $this->RoleRepository->getRoleById($id);
        return ResponseBuilder::success($role, 200 );
    }

    public function createRole(RoleRequest $request)
    {
        $role = $this->RoleRepository->createRole($request->all());
        return ResponseBuilder::success($role,201);
    }

    public function updateRole(RoleRequest $request, $id)
    {
        $role= $this->RoleRepository->updateRole($id, $request->all());
        return ResponseBuilder::success($role, 200 );
    }

    public function deleteRole(Request $request, $id)
    {
       $role = $this->RoleRepository->deleteRole($id);
        return ResponseBuilder::success($role, 200 );
    }
}
