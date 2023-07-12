<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Redirect;

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

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    /**
     * login
     *
     * @param  mixed $request
     * @return void
     */
    public function login(Request $request)
    {

        $rules = array (
            'email' => array ('required', 'email'),
            'password' => array ('required', 'min:6'),
        );
        $input = $request->all ();    
        $validator = Validator::make ($input, $rules);
        
        if ($validator){
            $user = $this->_adminAuthentication ($input['email'], $input['password']);
    
            if ($user) {
                Session::put('session_login', "1234");
                return Redirect::to('/image-form');
            }
            return view('auth.login');
        }
    }
    
    /**
     * _adminAuthentication
     *
     * @param  mixed $email
     * @param  mixed $password
     * @param  mixed $status
     * @return void
     */
    private function _adminAuthentication($email, $password, $status = true)
    {
        $emailCorrect = "user1@correo.com";
        $passCorrect  = base64_encode("admin1234");
        
        $pass = base64_encode($password);
        return ($email == $emailCorrect) && ($pass == $passCorrect) ? true : false;
    }
}
