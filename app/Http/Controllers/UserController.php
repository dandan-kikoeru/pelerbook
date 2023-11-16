<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Image;

class UserController extends Controller
{
  public function login(Request $request)
  {
    $credentials = $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required', 'min:8'],
    ]);

    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();
      return redirect('/');
    }

    return back()->withErrors(['messages' => 'Invalid credentials']);
  }

  public function register(Request $request)
  {
    $credentials = $request->validate([
      'firstname' => ['required', 'regex:/^[A-Za-z]+$/'],
      'surname' => ['required', 'regex:/^[A-Za-z]+$/'],
      'email' => ['required', 'email', Rule::unique('users', 'email')],
      'password' => ['required', 'min:8'],
    ]);
    $user = User::create($credentials);
    Auth::login($user);
    return redirect('/');
  }

  public function logout()
  {
    Auth::logout();
  }

  public function update(Request $request)
  {
    $user = auth()->user();

    if ($request->hasFile('avatar')) {
      $request->validate([
        'avatar' => ['mimes:jpeg,png,jpg,webp', 'max:2048'],
      ]);

      $avatarName = $user->id . '.webp';
      $avatar = Image::make($request->file('avatar'))->encode('webp', 90);
      $avatar
        ->resize(128, null, function ($constraint) {
          $constraint->aspectRatio();
        })
        ->save(public_path('/avatars/' . $avatarName));
      $user->avatar = '/avatars/' . $avatarName;
    }

    if ($request->hasFile('cover')) {
      $request->validate([
        'cover' => ['mimes:jpeg,png,jpg,webp', 'max:2048'],
      ]);

      $coverName = $user->id . '.webp';
      $cover = Image::make($request->file('cover'))->encode('webp', 90)->save(public_path('/covers/' . $coverName));
      $user->cover = '/covers/' . $coverName;
    }

    if ($request->firstname) {
      $request->validate([
        'firstname' => ['required', 'regex:/^[A-Za-z]+$/'],
        'surname' => ['required', 'regex:/^[A-Za-z]+$/'],
      ]);
      $user->firstname = $request->firstname;
      $user->surname = $request->surname;
    }
    $user->save();

    return back();
  }

}
