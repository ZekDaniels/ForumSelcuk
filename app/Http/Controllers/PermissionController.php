<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;


class PermissionController extends Controller
{
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
        $this->middleware(['auth', 'permission:Admin|create-role|create-permission']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $permissionsSubs = $this->permission::where('name', 'like', '%.%')->get();
        foreach ($permissionsSubs as $sub) {
            $wildCardParent[] = explode(".", $sub->name)[0];
            $wildCardSub[] = explode(".", $sub->name)[1];
        }
        $standartPermissions = $this->permission::where('name', 'not like', '%.%')->whereNotIn('name', $wildCardParent)->get();
        $wildCardParentPermission = $this->permission::where('name', 'not like', '%.%')->whereIn('name', $wildCardParent)->get();
        $wildCardParentPermission->subs =  $this->permission::where('name', 'like', '%.%')->whereIn('name', $wildCardSub)->get();



        // dd($permissionsSubs);
        return view("permission.index", ['standartPermissions' => $standartPermissions, 'wildCardParent' => $wildCardParentPermission]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("permission.create");
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
                'name' => 'required',
            ]
        );

        $this->permission->create([
            'name' => $request->name
        ]);

        return redirect()->route('permission.index')->with('success', 'Permission Successfully Created');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect()->back()->with('success', 'Permission has been deleted successfully');
    }
    public function getAllPermissions()
    {
        $permissions = $this->permission::all();
        return response()->json([
            'permissions' => $permissions
        ], 200);
    }
}
