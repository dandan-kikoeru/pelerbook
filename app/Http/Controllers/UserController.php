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
      "password" => ['required', 'min:8'],
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
      'password' => ['required', 'min:8']
    ]);
    $user = User::create($credentials);
    Auth::login($user);
    return redirect('/');
  }

  public function logout()
  {
    sleep(1);
    Auth::logout();
  }

  public function update(Request $request)
  {
    sleep(1);
    $user = Auth()->user();
    $request->validate([
      'firstname' => ['required', 'regex:/^[A-Za-z]+$/'],
      'surname' => ['required', 'regex:/^[A-Za-z]+$/'],
    ]);

    if ($request->deleteAvatar) {
      $user->avatar = "/avatars/guest.png";
    }

    elseif ($request->file('avatar')) {
      $request->validate([
        'avatar' => ['mimes:jpeg,png,jpg,gif,webp', 'max:2048']
      ]);
      $imageName = $user->id . '.' . $request->file('avatar')->extension();
      $request->file('avatar')->move(public_path('avatars'), $imageName);
      $user->avatar = 'avatars/' . $imageName;
    }

    $user->firstname = $request->firstname;
    $user->surname = $request->surname;
    $user->save();
    return redirect('/');

  }
}
