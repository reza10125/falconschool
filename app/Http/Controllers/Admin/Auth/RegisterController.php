<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

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
            $admin = new Admin();
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->password = Hash::make($request->password);
            if ($admin->save()) {
                return redirect()
                    ->intended(route('admin.home'))
                    ->with('status', 'You are Logged in as Admin!');
            } else {
                return redirect()
                    ->intended(route('register'))
                    ->with('status', 'Admin Registration Failed!');
            }
        }
    }
}
