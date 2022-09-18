<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreRefereeRequest;
use App\Http\Requests\UpdateRefereeRequest;

class RefereeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $referees = Client::whereNotNull('referee_id')->get();

        // dd($operation_staffs->toArray());
        return view('referee.index', compact('referees'));
    }


    public function refereerequests()
    {
        $referees = Client::whereNotNull('referee_id')->get();

        // dd($operation_staffs->toArray());
        return view('referee.refereerequests', compact('referees'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('referee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRefereeRequest $request)
    {
        dd($request->parent_id);
        if ($request->hasFile('profile_img')) {
            $profile_img_file = $request->file('profile_img');
            $profile_img_name = time() . '-' . uniqid() . '-' . $profile_img_file->getClientOriginalName();
            $profile_img_file->storeAs('/public/image/',$profile_img_name);
            // Storage::disk('public')->put(
            //     'image/' . $profile_img_name,
            //     file_get_contents($profile_img_file)
            // );
        }
        $referee = new Client();
        $referee->name = $request->name;
        $referee->phone = $request->phone;
        $referee->parent_id  = $request->parent_id;

        $referee->image = $profile_img_name;

        if($request->has('password')) {
            if($request->password == $request->confirmpasword){
                $referee->password = $request->password;
            }else{
                return redirect()->route('operation-staff.index')->with('success', 'Password and Confirm Password do not match!');
            }
        }

        $referee->save();

        return redirect()->route('referee.index')->with('success', 'New Referee is created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $referee = Client::findOrFail($id);
        return view('referee.show', compact('referee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $referee = Client::findOrFail($id);
        $referees = Client::whereNotNull('referee_id')->get();
        return view('referee.edit', compact('referee','referees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRefereeRequest $request, $id)
    {
        $agent = Client::findOrFail($id);

        $profile_img_name = $agent->image;

        if ($request->hasFile('profile_img')) {
            $profile_img_file = $request->file('profile_img');
            $profile_img_name = time() . '-' . uniqid() . '-' . $profile_img_file->getClientOriginalName();

            Storage::disk('public')->put(
                'referee/' . $profile_img_name,
                file_get_contents($profile_img_file)
            );
        }

        $agent->name = $request->name;
        $agent->phone = $request->phone;
        $agent->operationstaff_id = $request->operationstaff_id;
        $agent->password = $agent->passowrd ?? $request->password;

        $agent->image = $profile_img_name;

        $agent->update();

        return redirect()->route('referee.index')->with('success', 'New Operation Staff is updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $referee = Referee::findOrFail($id);

        $referee->delete();
        return redirect ()->back()->with('success', 'Referee is deleted successfully!');

    }
}
