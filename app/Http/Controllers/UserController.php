<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateUserRequest;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('view_assign_user_role')) {
            abort(403, 'Unauthorized Action');
        }
        $users = User::all();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (!auth()->user()->can('create_assign_user_role')) {
        //     abort(403, 'Unauthorized Action');
        // }
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        // if (!auth()->user()->can('create_assign_user_role')) {
        //     abort(403, 'Unauthorized Action');
        // }
        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->operationstaff_code=strtoupper($request->operationstaff_code);
        $user->referee_code=strtoupper($request->referee_code);
        $user->password = Hash::make($request->password);

        if($request->request_type == 'guest'){
            $user->request_type=null;
            $user->status = 0;
        }else{
            $user->request_type=$request->request_type;
            $user->status = 1;
        }
        //$user->syncRoles($request->roles);

        $user->save();

        return redirect()->back()->with('success','New User is Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->can('view_assign_user_role')) {
            abort(403, 'Unauthorized Action');
        }
        $user = User::findOrFail($id);

        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('edit_assign_user_role')) {
            abort(403, 'Unauthorized Action');
        }
        $user = User::findOrFail($id);

        $roles = Role::all();
        $old_roles = $user->roles->pluck('id')->toArray();

        return view('user.edit', compact('user', 'roles', 'old_roles'));
    }

    public function create_user()
    {
        $users=User::where('status','=','0')->get();
                return view('system_admin.user.create',compact('users'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        if (!auth()->user()->can('edit_assign_user_role')) {
            abort(403, 'Unauthorized Action');
        }

        $user = User::findOrFail($id);

        $profile_img_name = $user->profile_img;

        if ($request->hasFile('profile_img')) {
            $profile_img_file = $request->file('profile_img');
            $profile_img_name = time() . '-' . uniqid() . '-' . $profile_img_file->getClientOriginalName();

            Storage::disk('public')->put(
                'user/' . $profile_img_name,
                file_get_contents($profile_img_file)
            );
        }

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->password = $request->password ? Hash::make($request->password) : $user->password;
        $user->image = $profile_img_name;

        $user->update();

        $user->syncRoles($request->roles);

        return redirect()->route('user.index')->with('success', 'User is updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('delete_assign_user_role')) {
            abort(403, 'Unauthorized Action');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return 'success';
    }
}
