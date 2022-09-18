<?php

namespace App\Http\Controllers\SystemAdmin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if (!auth()->user()->can('view_permission')) {
        //     abort(403, 'Unauthorized Action');
        // }
        $permissions = Permission::all();
        return view('system_admin.permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (!auth()->user()->can('create_permission')) {
        //     abort(403, 'Unauthorized Action');
        // }
        return view('system_admin.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        // if (!auth()->user()->can('create_permission')) {
        //     abort(403, 'Unauthorized Action');
        // }
        $request->validate([
            'name'=>'required'
        ]);
        $permission = new Permission();
        $permission->name = $request->name;

        $permission->save();

        return redirect()->route('permission.index')->with('success', 'New Permission is Created Successfully!');
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
        // if (!auth()->user()->can('edit_permission')) {
        //     abort(403, 'Unauthorized Action');
        // }

       $permission = Permission::findOrFail($id);

       return view('system_admin.permission.edit', compact('permission'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, $id)
    {
        // if (!auth()->user()->can('edit_permission')) {
        //     abort(403, 'Unauthorized Action');
        // }
        $permission = Permission::findOrFail($id);
        $permission->name = $request->name;

        $permission->update();

        return redirect()->route('permission.index')->with('success', 'Permission is updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if (!auth()->user()->can('delete_permission')) {
        //     abort(403, 'Unauthorized Action');
        // }

        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect ()->back()->with('success', 'Permission is deleted successfully!');
    }
}
