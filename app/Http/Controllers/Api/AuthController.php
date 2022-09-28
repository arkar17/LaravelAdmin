<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;

use App\Models\User;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Lonepyinesalelist;
use App\Models\Referee;
use App\Models\Threedsalelist;
use App\Models\Twodsalelist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT;
use Tymon\JWTAuth\JWTAuth as JWTAuthJWTAuth;

class AuthController extends Controller
{

    //checkPhone
    public function checkPhone(Request $request)
    {
        $user = User::where('phone', $request->phone)->get();
        if (!$user) {
            return response()->json([
                'status' => 200,
                'message' => 'success'
            ]);
        }

        return response()->json([
            'status' => 403,
            'message' => 'This phone number is already registered'
        ]);
    }

    public function hasPhone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|min:9|max:11'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validation Error!',
                'data' => $validator->errors()
            ]);
        }

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'Your phone is not correct'
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'data' => $user
            ]);
        }
    }

    public function passwordChange(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|max:9',
            'password_confirmation' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validation Error!',
                'data' => $validator->errors()
            ]);
        }

        $user = User::where('phone', $request->phone)->first();

        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'status' => 200,
                'message' => "You have changed password successfully",
                'data' => $user
            ]);
        } else {
            return response()->json([
                'status' => 403,
                'message' => 'Your phone is not in our database'
            ]);
        }
    }

    // User Register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:users,phone|min:9|max:11',
            'password' => 'required|min:6|max:9',
            'password_confirmation' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validation Error!',
                'data' => $validator->errors()
            ]);
        }

        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'status' => 200,
            'message' => 'Registration success, Plesae Login',
            'data' => $user
        ]);
    }


    // User Login
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required|min:6|max:9'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'data' => $validator->errors()
            ]);
        }

        $check_password = User::where('phone', $request->phone)->first();
        if(!$check_password) {
            return response()->json([
                'message' => 'Unauthenticated Phone number!'
            ]);
        }
        $checked =  Hash::check($request->password, $check_password->password);
        if(!$checked) {
            return response()->json([
                'message' => 'Uncorrect Password'
            ]);
        }

        $input =  $request->only(['phone', 'password']);
        $token = JWTAuth::attempt($input);

        $user = auth()->user();

        $usr = User::find($user->id);

        $agent = Agent::where('user_id', $usr->id)->first();
        if ($agent) {
            $agent->is_online = 1;
            $agent->save();
        }

        //$token = auth()->attempt($validator->validated());
        if ($token) {
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'token' => $token,
                'user' => auth()->user(),
                'expires_in' => JWTAuth::factory()->getTTL(),
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthenticated user!'
            ]);
        }
    }

    //Mobile Login
    public function mobileLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required|min:6|max:9'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'data' => $validator->errors()
            ]);
        }

        $check_password = User::where('phone', $request->phone)->first();
        if(!$check_password) {
            return response()->json([
                'message' => 'Unauthenticated Phone number!'
            ]);
        }
        $checked =  Hash::check($request->password, $check_password->password);
        if(!$checked) {
            return response()->json([
                'message' => 'Uncorrect Password'
            ]);
        }

        $input =  $request->only(['phone', 'password']);
        $token = JWTAuth::attempt($input);

        $user = auth()->user();

        $usr = User::find($user->id);

        $agent = Agent::where('user_id', $usr->id)->first();
        if ($agent) {
            $agent->is_online = 1;
            $agent->save();
        }

        //$token = auth()->attempt($validator->validated());
        if ($token) {
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'token' => $token,
                'user' => auth()->user(),
                'expires_in' => 5 * (JWTAuth::factory()->getTTL() * 24),
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthenticated user!'
            ]);
        }
    }

    // Request For promotion
    public function promoteRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'request_type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => "Validation Error",
                'data' => $validator->errors()
            ]);
        }

        $user = auth()->user();

        if ($user->phone == $request->phone) { // Check Phone
            $user = User::findOrFail($user->id);
            $user->request_type = $request->request_type;

            if ($request->request_type == 'agent') { // if request type is agent
                $user->referee_code = $request->referee_code;
                $user->status = '1';
                $user->update();

                return response()->json([
                    'status' => 200,
                    'message' => 'You requested to be agent, please wait for admin approval',
                    'data' => $user
                ]);
            }

            if ($request->request_type == 'referee') { // if request type is referee
                $user->operationstaff_code = $request->operationstaff_code;
                $user->status = "1";
                $user->update();

                return response()->json([
                    'status' => 200,
                    'message' => 'You requested to be referee, please wait for admin approval!',
                    'data' => $user
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                'message' => "Your phone is not registered in our database yet."
            ]);
        }
    }

    // See Agent Profile
    public function agentProfile()
    {
        $user = auth()->user();

        if ($user) {
            $agent = Agent::where('user_id', $user->id)->with('user', 'cashincashout')->first();

            $current_date = Carbon::now('Asia/Yangon')->toDateString();

            $twod_lists = Twodsalelist::where('status', '<>', 0)
                ->where('agent_id', $agent->id)->with('twod')->whereHas('twod', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->get();

            $threed_lists = Threedsalelist::where('status', '<>', 0)
                ->where('agent_id', $agent->id)->with('threed')->whereHas('threed', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->get();

            $lonepyaing_lists = Lonepyinesalelist::where('status', '<>', 0)
                ->where('agent_id', $agent->id)->with('lonepyine')->whereHas('lonepyine', function ($q) use ($current_date) {
                    $q->where('date', $current_date);
                })->get();

            return response()->json([
                'status' => 200,
                'agent' => $agent,
                'twod_lists' =>  $twod_lists,
                'threed_lists' => $threed_lists,
                'lonepyaing_lists' => $lonepyaing_lists
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized user'
            ]);
        }
    }


    // Profile Update
    public function profileUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Validatioin Error',
                'data' => $validator->errors()
            ]);
        }

        $user = auth()->user();
        if ($user) {
            // $agent = Agent::with('user')->findOrFail($user->id);
            $agent = Agent::where('user_id', $user->id)->with('user')->first();
            $imageName = null;
            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $imageName = uniqid() . '_' .  $file->getClientOriginalName();
                $file->move(public_path() . '/image/', $imageName);
            }

            $agent->user->name = $request->name;
            $agent->image =  $imageName;

            $user->name = $agent->user->name;
            $agent->update();
            $user->update();

            return response()->json([
                'status' => 200,
                'message' => "Agent Profile Updated Successfully!",
                'agent' => $agent
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized'
            ]);
        }
    }

    public function refereeProfile()
    {
        $user = auth()->user();

        if ($user) {
            $agent = Agent::where('user_id', $user->id)->with('referee')->first();
            // return $agent;
            $referee = Referee::where('user_id', $agent->referee->user_id)->with('user')->first();
            return response()->json([
                'status' => 200,
                'referee' =>  $referee
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized User'
            ]);
        }
    }

    public function logout()
    {

        $user = auth()->user();
        if ($user) {
            if ($user->status == '2' && $user->request_type == "agent") {
                $agent = Agent::where('user_id', $user->id)->first();
                $agent->is_online = 0;
                $agent->save();
            }
            auth()->logout();
        }
        //User::where('request_type', 'agent')->where('status',2)->first();

        return response()->json([
            'status' => 200,
            'message' => 'User successfully Logout!'
        ]);
    }

    // Refresh a token, which invalidates the current one
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'status' => 200,
            'message' => 'Login Success',
            'access_token' => $token,
            'token_type' => 'bearer',
            //'expires_in' => auth()->factory()->getTTL(),
            'user' => auth()->user()
        ]);
    }
}
