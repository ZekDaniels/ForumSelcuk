<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct(Role $role, Permission $permission)
    {
        $this->role = $role;
        $this->permission = $permission;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $roles = $this->role::all();
        return view("role.index", ['roles' => $this->role::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $permissions = $this->permission::all();
        return view("role.create", ['permissions' =>  $this->permission::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string|unique:roles',
                'permissions' => 'nullable'
            ]
        );

        $role = $this->role->create([
            'name' => $request->name
        ]);
        if ($request->has("permissions")) {
            $role->givePermissionTo($request->permissions);
        }
        return redirect()->route('role.index')->with('success', 'Permission Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role =  Role::findOrFail($id);
        $permissions =  $this->permission::all();

        for ($i = 0; $i < count($role->permissions); $i++) {
            $role->permissions[$i] = $role->permissions[$i]->name;
        }
        for ($i = 0; $i < count($permissions); $i++) {
            $permissions[$i] = $permissions[$i]->name;
        }

        //  dd($role->permissions);
        return view("role.edit", ['role' => $role, 'permissions' => $permissions]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string',
            ]
        );
        $role = Role::findOrFail($id);

        $role->name = $request->name;
        $rolePermissions = $role->getPermissionNames();
        foreach ($rolePermissions as $permssion) {
            $role->revokePermissionTo($permssion);
        }
        if ($request->has('permissions')) {

            $role->givePermissionTo($request->permissions);
        }

        $role->save(); //Update fonksiyonu yerine save kullanmasının sebebi yukarıdaki ifleri dizide kontrol etmekten daha kolay olması olabilir.

        return redirect()->route('role.index')->with('success', 'Role Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->back()->with('success', 'Role has been deleted successfully');
    }
    public function getAllRoles()
    {
        $roles = $this->role::all();
        return response()->json([
            'roles' => $roles
        ], 200);
    }
}
