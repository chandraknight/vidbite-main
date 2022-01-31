<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\TwoFactorCode;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    // protected $redirectTo = RouteServiceProvider::HOME;
//    protected $redirectTo = 'home';
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function redirectTo() {
        $role = Auth::user()->user_type;

        switch ($role) {
            case 'admin':
                return '/admin';
                break;
            case 'super_admin':
                return '/super-admin';
                break;

            default:
                return '/home';
                break;
        }
    }


    public function authenticated(Request $request,$user)
    {
        if ($request->has('previous')) {
            $this->redirectTo = $request->get('previous');
        }
        if (!$user->verified) {
            auth()->logout();
            return back()->with('warning', 'You need to confirm your account. We have sent you an activation code, please check your email.');
        }

        $user->generateTwoFactorCode();
        // $user->notify(new TwoFactorCode());

        if (!in_array('admin', $user->roles->pluck('name')->toArray())) {
            $this->redirectTo = '/verify';            
        }

        if ( $user->user_type==='admin' ) {// do your magic here
            return redirect()->route('admin.home');
        }elseif($user->user_type==='super_admin'){
            return redirect()->route('super-admin');
        }else{
            return redirect()->route('home');
        }

    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        return $this->authenticated($request, $user);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ],[
            $this->username().'.required'=>'Provide your '.$this->username(),
            'password.required'=>'Provide your password.'
        ]);
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->redirectTo = url()->previous();
    }

  
 
}
