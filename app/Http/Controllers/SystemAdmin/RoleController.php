<?php

namespace App\Http\Controllers\SystemAdmin;

use Illuminate\Routing\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Support\Facades\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if (!auth()->user()->can('view_role')) {
        //     abort(403, 'Unauthorized Action');
        // }
        $roles = Role::all();
        return view('system_admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (!auth()->user()->can('create_role')) {
        //     abort(403, 'Unauthorized Action');
        // }
        // $permissions2ds=Permission::all()->where('status','=',1);
        // $permissions3ds=Permission::all()->where('status','=',2);
        // $permissionscreates=Permission::all()->where('status','=',3);
        // $permissionsviews=Permission::all()->where('status','=',4);
        // $permissionsedits=Permission::all()->where('status','=',5);
        // $permissionsdeletes=Permission::all()->where('status','=',6);
        // $permissionsothers=Permission::all()->where('status','=',7);
        $permissions = Permission::all();
        return view('system_admin.role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        // if (!auth()->user()->can('create_role')) {
        //     abort(403, 'Unauthorized Action');
        // }
        $role = new Role();
        $role->name = $request->name;
        $role->save();

        $role->givePermissionTo($request->permissions);
        return redirect()->route('role.index')->with('success', 'New Role Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // if (!auth()->user()->can('view_role')) {
        //     abort(403, 'Unauthorized Action');
        // }
        $role = Role::findOrFail($id);
        $permissions= $role->permissions->pluck('name')->toArray();
        //dd($permissions);
        return view('system_admin.role.viewdetail', compact('role','permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // if (!auth()->user()->can('edit_role')) {
        //     abort(403, 'Unauthorized Action');
        // }
        $role = Role::findOrFail($id);
        $permissions=Permission::all();
        $old_permissions = $role->permissions->pluck('id')->toArray();
        return view('system_admin.role.edit', compact('role', 'old_permissions','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, $id)
    {
        // if (!auth()->user()->can('edit_role')) {
        //     abort(403, 'Unauthorized Action');
        // }
        $role = Role::findOrFail($id);
        $role->name = $request->name;


        $role->update();

        $old_permissions = $role->permissions->pluck('name')->toArray();
        $role->revokePermissionTo($old_permissions);
        $role->givePermissionTo($request->permissions);
        return redirect()->route('role.index')->with('success', 'Role is updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if (!auth()->user()->can('delete_role')) {
        //     abort(403, 'Unauthorized Action');
        // }
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect ()->back()->with('success', 'Role is deleted successfully!');
    }
}
