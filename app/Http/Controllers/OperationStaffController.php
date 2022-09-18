<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreOperationStaffRequest;

class OperationStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $operation_staffs = Client::whereNotNull('operationstaff_id')->get();

        // dd($operation_staffs->toArray());
        return view('operationstaff.index', compact('operation_staffs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('operationstaff.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOperationStaffRequest $request)
    {
        if ($request->hasFile('profile_img')) {
            $profile_img_file = $request->file('profile_img');
            $profile_img_name = time() . '-' . uniqid() . '-' . $profile_img_file->getClientOriginalName();

            $profile_img_file->storeAs('/public/image/',$profile_img_name);
            // Storage::disk('public')->put(
            //     'image/' . $profile_img_name,
            //     file_get_contents($profile_img_file)
            // );
        }

        $operation_staff = new Client();
        $operation_staff->name = $request->name;
        $operation_staff->phone = $request->phone;

        if($request->has('password')) {
            if($request->password == $request->confirmpassword){
                $operation_staff->password = $request->password;
            }else{

                return redirect()->route('operation-staff.index')->with('success', 'Password and Confirm Password do not match!');
            }
        }


        //$operation_staff->image = $profile_img_name;

        $operation_staff->save();

        return redirect()->route('operation-staff.index')->with('success', 'New Operation Staff is created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $operation_staff =Client::findOrFail($id);
        return view('operationstaff.show', compact('operation_staff'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $operation_staff = Client::findOrFail($id);
        return view('operationstaff.edit', compact('operation_staff'));
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
        $agent = Client::findOrFail($id);

        $profile_img_name = $agent->image;

        if ($request->hasFile('profile_img')) {
            $profile_img_file = $request->file('profile_img');
            $profile_img_name = time() . '-' . uniqid() . '-' . $profile_img_file->getClientOriginalName();

            Storage::disk('public')->put(
                'image/' . $profile_img_name,
                file_get_contents($profile_img_file)
            );
        }

        $agent->name = $request->name;
        $agent->phone = $request->phone;

        $agent->password = $agent->passowrd ?? $request->password;

        $agent->image = $profile_img_name;

        $agent->update();

        return redirect()->route('operation-staff.index')->with('success', 'New Operation Staff is Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $operation_staff = Client::findOrFail($id);
        $operation_staff->delete();

        return redirect ()->back()->with('success', 'Referee is deleted successfully!');
    }
}
