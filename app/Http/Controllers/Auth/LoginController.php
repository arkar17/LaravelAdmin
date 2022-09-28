<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Referee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    // protected $redirectTo = RouteServiceProvider::HOME;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'phone';
    }
    protected function authenticated(Request $request, $user)
    {
        if( $user->hasAnyRole(['referee'])){

            $referee=Referee::where('user_id',$user->id)->first();
            $r_status=$referee->active_status;

            if($r_status==1){
                Auth::login($user);
            }else{
                Auth::logout();
                return redirect()->back()->with('message','Referee Account is expired !');
            }
        }
    }

    public function logout(Request $request) {
        session()->flush();
        // $request->session()->regenerate();
        Auth::logout();
        return redirect('/login');
    }
}
