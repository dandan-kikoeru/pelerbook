<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Image; // alias of Intervention\Image\ImageServiceProvider::class,
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

    if ($request->deleteAvatar) {
      $user->avatar = "/avatars/guest.png";
      $user->firstname = $request->firstname;
      $user->surname = $request->surname;
      $user->save();
      return redirect('/');
    }

    if ($request->hasFile('avatar')) {
      $request->validate([
        'avatar' => ['mimes:jpeg,png,jpg,gif,webp', 'max:2048']
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

    $request->validate([
      'firstname' => ['required', 'regex:/^[A-Za-z]+$/'],
      'surname' => ['required', 'regex:/^[A-Za-z]+$/'],
    ]);

    $user->firstname = $request->firstname;
    $user->surname = $request->surname;
    $user->save();

    return redirect('/');
  }

}
