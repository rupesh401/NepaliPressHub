<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class AuthController extends Controller
{

  public function getDecryptedData(Request $request)
  {
    try {
      $decryptedValue = $request->cookie('language'); // Replace 'lang' with your cookie name
      return response()->json(['decryptedValue' => $decryptedValue]);
  } catch (\Exception $e) {
      return response()->json(['error' => $e->getMessage()], 500);
  }
  }

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
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
      if (Auth::user()->status == 'Active') {
        return response()->json(['status' => 'success', 'status_code' => 200]);
      } else {
        Auth::logout();
        return response()->json(['status' => 'blocked', 'status_code' => 200]);
      }
    } else {
      return response()->json(['status' => 'failed', 'status_code' => 200]);
    }
  }
}
