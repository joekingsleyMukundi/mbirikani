<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RolesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->can('roles:list')) {
            abort(403);
        }

        $title = "Settings";
        $secondarytitle = "Roles";
        $roles  = Role::all();
        return view('roles.index', compact('title', 'roles', 'secondarytitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('roles:create')) {
            abort(403);
        }

        $title = "Settings";
        $secondarytitle = "Roles";
        $permissions = Permission::all();
        return view('roles.create',compact('title', 'permissions', 'secondarytitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('roles:create')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'name' =>  'required|min:1',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $title = "Role";

        $role = Role::create(
            [
                "name" => $request->name,
                "guard_name" => 'web'
            ]
        );

        foreach ($request->permissions as $permission){
            $role->givePermissionTo(Permission::findById($permission)->name);
        }


        if($role){
            return redirect()->back()->with('success', $title . ' created successfully');
        }

        return redirect()->back()->with('error', 'Failed to create ' . $title);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if (!Auth::user()->can('roles:update')) {
            abort(403);
        }

        $title = "Settings";
        $secondarytitle = "Roles";
        $permissions = Permission::all();

        return view('roles.edit', compact('title','role', 'permissions', 'secondarytitle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Spatie\Permission\Models\Role  $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Role $role)
    {
        if (!Auth::user()->can('roles:update')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'name' =>  'required|min:1',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $title = "Role";

        $role->name = $request->name;
        $role->guard_name = "web";

        foreach ($role->permissions as $permission){
            $role->revokePermissionTo($permission);
        }

        foreach ($request->permissions as $permission){
            $role->givePermissionTo(Permission::findById($permission)->name);
        }

        if($role->save()){
            return redirect()->back()->with('success', $title . ' updated successfully');
        }

        return redirect()->back()->with('error', 'Failed to update ' . $title);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!Auth::user()->can('roles:delete')) {
            abort(403);
        }

        $validator  =   Validator::make($request->all(), [
            'id'     =>  'required|min:1',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput($request->all());
        }

        $title = "Role";

        $role = Role::find($request->id);
        if($role->delete()){
            foreach ($role->permissions as $permission){
                $role->revokePermissionTo($permission);
            }
            return redirect()->back()->with('success', $title . ' deleted successfully');
        }

        return redirect()->back()->with('error', 'Failed to delete ' . $title);
    }
}
