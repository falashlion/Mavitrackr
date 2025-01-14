<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolesRequest;
use App\Http\Requests\RolesUpdateRequest;
use Illuminate\Http\Request;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Spatie\Permission\Models\Role;

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
     * @return object
     */
    public function index()
    {
        $roles = Role::all();
        return ResponseBuilder::success($roles, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * create
     *
     * @param  object $request
     * @return object
     */
    public function create(RolesRequest $request)
    {
    $role = Role::create([
       'name'=> $request->input('name'),
    ]);
    $role->syncPermissions($request->input('permissions'));
    return ResponseBuilder::success($role,201,null,201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the roles resource.
     */
    /**
     * show
     *
     * @param  string $id
     * @return object
     */
    public function show(string $id)
    {
        $role = Role::findOrFail($id);
        $role->permissions;
        return ResponseBuilder::success($role,200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * update
     *
     * @param  object $request
     * @param  string $id
     * @return object
     */
    public function update(RolesUpdateRequest $request, string $id)
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
     * @param  string $id
     * @return object
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return ResponseBuilder::success( [],204,null,204);
    }
}
