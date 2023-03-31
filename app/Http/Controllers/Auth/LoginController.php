<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ThrottlesLogins;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class LoginController extends Controller
{

    protected $redirectTo = RouteServiceProvider::HOME;
    /**
     * Show the login form.
     * 
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function showLoginForm()
    {
        return view('auth.login', [
            'title' => 'Login',
            'loginRoute' => 'login',
            'forgotPasswordRoute' => 'password.request',
        ]);
    }

    /**
     * Login the admin.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userLogin(Request $request)
    {
        //validate the fields....

        // $credentials = ['email' => $request->email, 'password' => $request->password];
        $user = User::where('email', $request->email)->first();
        
        if(isset($user)){
            if($user->user_type === 0){
                // if (Auth::guard('user')->attempt($credentials, $request->remember)) { // login attempt
                if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) { // login attempt
                    //login successful, redirect the user to your preferred url/route...
                    return redirect()
                        ->intended(route('user.dashboard'))
                        ->with('status', 'You are logged in as user!');
                } else {
                    //Authentication failed...
                    return $this->loginFailed();
                }
            }else{
                //Authentication failed...
                return $this->loginFailed();
            }
        }else{
            //Authentication failed...
            return $this->loginFailed();
        }
        
        

        //login failed...
    }
    /**
     * Logout the admin.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect()
            ->route('user.login')
            ->with('status', 'User has been logged out!');
    }

    /**
     * Validate the form data.
     * 
     * @param \Illuminate\Http\Request $request
     * @return 
     */
    private function validator(Request $request)
    {
        //validation rules.
        $rules = [
            'email'    => 'required|email|min:5|max:191',
            // 'email'    => 'required|email|exists:users|min:5|max:191',
            'password' => 'required|string|min:4|max:255',
        ];

        //custom validation error messages.
        $messages = [
            'email.exists' => 'These credentials do not match our records.',
        ];

        //validate the request.
        $request->validate($rules, $messages);
    }

    /**
     * Redirect back after a failed login.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    private function loginFailed()
    {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Login failed, please try again!');
    }
}
