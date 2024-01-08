<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolesRequest;
use App\Http\Requests\RolesUpdateRequest;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }
    /**
     * Display a listing of the resource.
     */
    /**
     * index
     *
     * @return Response Returns the object of all the roles
     */
    public function index():Response
    {
        $roles = Role::all();
        return ResponseBuilder::success($roles, 200);
    }
    /**
     * create
     *
     * @param  RolesRequest $request Contains the data to create the new role
     * @return Response Returns the object of the new role.
     */
    public function create(RolesRequest $request):Response
    {
    $role = Role::create([
       'name'=> $request->input('name'),
    ]);
    $role->syncPermissions($request->input('permissions'));
    return ResponseBuilder::success($role,201,null,201);
    }

    /**
     * show
     *
     * @param  string $id ID of the role
     * @return Response Returns the object of the role with this.
     */
    public function show(string $id):Response
    {
        $role = Role::findOrFail($id);
        $role->permissions;
        return ResponseBuilder::success($role,200);
    }

    /**
     * update
     *
     * @param  RolesUpdateRequest $request Contains the data to update the role with
     * @param  string $id ID of the Role
     * @return Response Returns the object of the updated role.
     */
    public function update(RolesUpdateRequest $request, string $id):Response
    {
        $role = Role::findOrFail($id);

        $role->name = $request->input('name');
        $role->syncPermissions($request->input('permissions'));
        $role->save();
        return ResponseBuilder::success($role, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * destroy
     *
     * @param  string $id Id of the Role
     * @return Response Returns no content or the rourse not found exception
     */
    public function destroy(string $id):Response
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return ResponseBuilder::success( [],204,null,204);
    }
}
