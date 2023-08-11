<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function index(Request $request)
    {
      
      if (!Auth::check() && $request->path() == 'blocked') {
        return view('welcome');
      } 
      
      if (!Auth::check() && $request->path() != 'login') {
        return redirect('/login');
      } 

      if (Auth::check() && ($request->path() == 'login' || $request->path() == 'blocked')) {
        return redirect('/dashboard');
        } 
     
      return view('welcome');

    }
    
    public function login(Request $request)
    {
       if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (Auth::user()->status == 'Active') {
                return response()->json(['status' => 'success', 'status_code' => 200 ]);
            } else {
                Auth::logout();
                return response()->json(['status' => 'blocked', 'status_code' => 200 ]);
            }
        } else {
            return response()->json([ 'status' => 'failed', 'status_code' => 200 ]);
        }
       
    }
}
