<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Show the Register form.
     * 
     * @return \Illuminate\Http\Response
     */
    public function showRegisterForm()
    {
        return view('auth.register', [
            'title' => 'Login',
            'loginRoute' => 'login',
            'forgotPasswordRoute' => 'password.request',
        ]);
    }

    public function register(Request $request)
    {
        $validation = [
            'name'     => 'required| max:50',
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ];
        $validator = Validator::make($request->all(), $validation);
        if ($validator->fails()) {
            return redirect()->back()->with('error', "Validation Failed!");
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            if ($user->save()) {
                return redirect()
                    ->intended(route('user.login'))
                    ->with('status', 'You are Logged in as User!');
            } else {
                return redirect()
                    ->intended(route('register'))
                    ->with('status', 'User Registration Failed!');
            }
        }
    }
}
