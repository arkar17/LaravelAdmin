<?php

namespace App\Http\Controllers;

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
        if (!auth()->user()->can('view_permission')) {
            abort(403, 'Unauthorized Action');
        }
        $permissions = Permission::all();
        return view('permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->can('create_permission')) {
            abort(403, 'Unauthorized Action');
        }
        return view('permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissionRequest $request)
    {
        if (!auth()->user()->can('create_permission')) {
            abort(403, 'Unauthorized Action');
        }
        $request->validate([
            'name'=>'required',
            'status'=>'required',
        ]);
        $permission = new Permission();
        $permission->name = $request->name;
        if($request->status == "2D"){
            $permission->status = '1';
        }elseif($request->status == "3D"){
            $permission->status = '2';
        }
        elseif($request->status == "Create"){
            $permission->status = '3';
        }
        elseif($request->status == "View"){
            $permission->status = '4';
        }
        elseif($request->status == "Edit"){
            $permission->status = '5';
        }elseif($request->status == "Delete"){
            $permission->status = '6';
        }else{
            $permission->status='7';
        }

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
        if (!auth()->user()->can('edit_permission')) {
            abort(403, 'Unauthorized Action');
        }
       $permission = Permission::findOrFail($id);

       return view('permission.edit', compact('permission'));
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
        if (!auth()->user()->can('edit_permission')) {
            abort(403, 'Unauthorized Action');
        }
        $permission = Permission::findOrFail($id);
        $permission->name = $request->name;
        if($request->status == "2D"){
            $permission->status = '1';
        }elseif($request->status == "3D"){
            $permission->status = '2';
        }
        elseif($request->status == "Create"){
            $permission->status = '3';
        }
        elseif($request->status == "View"){
            $permission->status = '4';
        }
        elseif($request->status == "Edit"){
            $permission->status = '5';
        }elseif($request->status == "Delete"){
            $permission->status = '6';
        }else{
            $permission->status='7';
        }

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
        if (!auth()->user()->can('delete_permission')) {
            abort(403, 'Unauthorized Action');
        }

        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect ()->back()->with('success', 'Permission is deleted successfully!');
    }
}
