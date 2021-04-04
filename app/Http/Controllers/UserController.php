<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;



class UserController extends Controller
{
    public function __construct(Role $role, Permission $permission)
    {
        $this->middleware('auth');
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
        $users = $this->getAllUserProperties();
        return view("user.index", ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $roles = $this->role::all();
        // $permissions = $this->permission::all();

        return view("user.create", ['roles' => $this->role::all(), 'permissions' => $this->permission::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $this->validate(
            $request,
            [
                'name' => 'required|string',
                'phone' => 'required|numeric||digits:11',
                'password' => 'required|alpha_num|min:6',
                'role' => 'required',
                'email' => 'required|email|unique:users',
                'permissions' => 'nullable'
            ]
        );

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->assignRole($request->role);
        if ($request->has('permissions')) $user->givePermissionTo($request->permissions);

        $user->save();

        return redirect()->route('user.index')->with('success', 'User Successfully Created');
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
        $user =  User::findOrFail($id);
        $user->role =  $user->getRoleNames()->first();

        for ($i = 0; $i < count($user->permissions); $i++) {
            $user->permissions[$i] = $user->permissions[$i]->name;
        }
        return view("user.edit", ['user' => $user, 'roles' => $this->role::all(), 'permissions' => $this->permission::all()]);
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
                'phone' => 'required|numeric||digits:11',
                'password' => 'nullable|alpha_num|min:6',
                'role' => 'required',
                'email' => 'required|email|unique:users,email,' . $id
            ]
        );

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;

        if ($request->filled('password')) //içindeki değer null ise has true döndürüyor, filled ise null olup olmadığını kontrol ediyor.
            $user->password = bcrypt($request->password);

        if ($request->has('role')) {
            $userRole = $user->getRoleNames();
            foreach ($userRole as $role) {
                $user->removeRole($role);
            }
            $user->assignRole($request->role);
        }

        $userPermissions = $user->getPermissionNames();
        foreach ($userPermissions as $permssion) {
            $user->revokePermissionTo($permssion);
        }
        if ($request->has('permissions')) {

            $user->givePermissionTo($request->permissions);
        }

        $user->save(); //Update fonksiyonu yerine save kullanmasının sebebi yukarıdaki ifleri dizide kontrol etmekten daha kolay olması olabilir.

        return redirect()->route('user.index')->with('success', 'User Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'User has been deleted successfully');
    }

    ///////////////////////////// User defined method

    public function profile()
    {
        return view('profile.index');
    }
    public function postProfile(Request $request)
    {
        $user = auth()->user();
        $this->validate(
            $request,
            [
                'name' => 'required',
                'phone' => 'required',
                'email' => 'required|email|unique:users,email,' . $user->id
            ]
        );
        $user->update($request->all());
        return redirect()->back()->with('success', 'Profile Successfully Updated'); //Session sucsess created
    }
    public function getAllUserProperties()
    {
        $users = User::orderBy('id', 'asc')
            ->get();
        $users->transform(function ($user) {
            $user->role = $user->getRoleNames()->first();
            $user->role = ($user->role == null) ? "No Role" : $user->role;
            return $user;
        });
        return $users;
    }
    public function getUserModalData(Request $request)
    {
        $user =  User::findOrFail($request->id);
        return response()->json([
            'user' => $user
        ], 200);
    }
    public function changePassword(Request $request)
    {
        return view('profile.password');
    }
    public function PostPassword(Request $request)
    {
        $this->validate(
            $request,
            [
                'newpassword' => 'required|alpha_num|min:6|max:30|confirmed'
            ]
        );
        $user = auth()->user();
        $user->update([
            'password' => bcrypt($request->newpassword)
        ]);

        return redirect()->back()->with('success', 'Password has been Changed Successfully');
    }
   
}
