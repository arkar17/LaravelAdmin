<?php

namespace App\Http\Controllers\Auth;

use Session;
use App\Models\Referee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
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
    // protected $redirectTo = '/';
    //protected $redirectTo = RouteServiceProvider::HOME;
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



    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }

    //protected function authenticated(Request $request, $user)
    //{

        // if ( $user->hasAnyRole(['system_admin']) ) {// do your margic here
        //     return redirect()->route('sys-dashboard');
        // }elseif( $user->hasAnyRole(['referee']) ){
        //     return redirect()->route('refe-dashboard');
        // }else
        //  return redirect('/login');
    //}

    protected function authenticated(Request $request, $user)
    {
        if ( $user->hasAnyRole(['system_admin']) ) {// do your margic here
            return redirect()->route('sys-dashboard');

        }elseif( $user->hasAnyRole(['referee'])){

            $referee=Referee::where('user_id',$user->id)->first();
            $r_status=$referee->active_status;

            if($r_status==1){
                return redirect()->route('refe-dashboard');
            }else{
                return redirect('/login')->with('message', 'Account Expired');
            }
        }elseif( $user->hasAnyRole(['phasetwo_admin'])){
             return redirect()->route('matches-register');
        }else
         return redirect('/login');
    }

}
