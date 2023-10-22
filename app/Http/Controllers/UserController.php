<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
  public function login(Request $request)
  {
    sleep(2);
    $credentials = $request->validate([
      "email" => ['required'],
      "password" => 'required',
    ]);

    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();
      return redirect("/");
    }

    return back()->withErrors(['messages' => 'peler']);
  }

  public function register(Request $request)
  {
    sleep(2);
    $credentials = $request->validate([
      'firstname' => ['required', 'regex:/^[A-Za-z]+$/'],
      'surname' => ['required', 'regex:/^[A-Za-z]+$/'],
      'email' => ['required', 'email', Rule::unique('users', 'email')],
      'password' => ['required']
    ]);
    $user = User::create($credentials);
    Auth::login($user);
    return redirect('/');
  }

  public function logout()
  {
    Auth::logout();
  }
}
