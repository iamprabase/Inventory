<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class LandingPageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      if(Auth::guard('admins')->check())  return redirect(RouteServiceProvider::ADMIN_HOME);
      if(Auth::guard('staffs')->check())  return redirect(RouteServiceProvider::STAFF_HOME);
      return view('landingpage');
    }
}
