<?php

namespace App\Http\Controllers\SystemAdmin;

use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreAgentRequest;
use App\Http\Requests\UpdateAgentRequest;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $agents = User::all();
        return view('system_admin.agent.index', compact('agents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('system_admin.agent.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAgentRequest $request)
    {
        if ($request->hasFile('profile_img')) {
            $profile_img_file = $request->file('profile_img');
            $profile_img_name = time() . '-' . uniqid() . '-' . $profile_img_file->getClientOriginalName();

            Storage::disk('public')->put(
                'agent/' . $profile_img_name,
                file_get_contents($profile_img_file)
            );
        }

        $agent = new User();
        $agent->name = $request->name;
        $agent->phone = $request->phone;
        $agent->coin_amount = $request->coin_amount;
        $agent->commision = $request->commision;
        $agent->referee_id = $request->referee_id ?? null;
        $agent->operationstaff_id = $request->operationstaff_id ?? null;
        $agent->password = $request->password;

        $agent->image = $profile_img_name;

        $agent->save();

        return redirect()->route('agent.index')->with('success', 'New Agent is created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $agent = User::findOrFail($id);
        return view('system_admin.agent.show', compact('agent'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $agent = User::findOrFail($id);

        return view('system_admin.agent.edit', compact('agent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAgentRequest $request, $id)
    {
        $agent = User::findOrFail($id);

        $profile_img_name = $agent->image;

        if ($request->hasFile('profile_img')) {
            $profile_img_file = $request->file('profile_img');
            $profile_img_name = time() . '-' . uniqid() . '-' . $profile_img_file->getClientOriginalName();

            Storage::disk('public')->put(
                'agent/' . $profile_img_name,
                file_get_contents($profile_img_file)
            );
        }

        $agent->name = $request->name;
        $agent->phone = $request->phone;
        $agent->coin_amount = $request->coin_amount ?? $agent->coin_amount;
        $agent->commision = $request->commision;
        $agent->referee_id = $request->referee_id ?? null;
        $agent->operationstaff_id = $request->operationstaff_id ?? null;
        $agent->password = $agent->passowrd ?? $request->password;

        $agent->image = $profile_img_name;

        $agent->update();

        return redirect()->route('agent.index')->with('success', 'New Agent is created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $agent = User::findOrFail($id);
        $agent->delete();

        return 'success';
    }
}
