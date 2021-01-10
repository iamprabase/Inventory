<?php

namespace App\Http\Controllers\Staff\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Console\Input\Input;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:staffs')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.staffs-login');
    }

    public function login(Request $request)
    {
        // Validate form data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        // Attempt to log the user in
        if(Auth::guard('staffs')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember))
        {
            return redirect()->intended(route('staff.dashboard'));
        }

        // if unsuccessful
        $errors = new MessageBag(['email' => ['These credentials do not match our records.']]); // if Auth::attempt fails (wrong credentials) create a new message bag instance.
        return redirect()->back()->withErrors($errors)->withInput($request->only('email','remember'));
    }
}