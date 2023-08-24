<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\RoleRepository;
use App\Http\Requests\RoleRequest;
use App\Http\Controllers\Controller;

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
        $data=[
            'roles'=>$roles
        ];

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], JsonResponse::HTTP_OK);
    }

    public function getRolebyid(Request $request, $id)
    {
        $role = $this->RoleRepository->getRoleById($id);
        $data=[
            'role'=>$role
        ];
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], JsonResponse::HTTP_OK);
    }

    public function createRole(RoleRequest $request)
    {
        $role = $this->RoleRepository->createRole($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $role,
        ], JsonResponse::HTTP_CREATED);
    }

    public function updateRole(RoleRequest $request, $id)
    {
        $role= $this->RoleRepository->updateRole($id, $request->all());

        return response()->json([
            'status' => 'updated',
            'Kpa' => $role,
        ], JsonResponse::HTTP_OK);
    }

    public function deleteRole(Request $request, $id)
    {
        $this->RoleRepository->deleteRole($id);

        return response()->json([
            'status' => 'success',
        ], JsonResponse::HTTP_OK);
    }
}
