<?php

use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

Route::get('/login', function () {
  return Inertia::render('Auth/Login');
})->name('login');

Route::get('/register', function () {
  return Inertia::render('Auth/Register');
})->name('register');

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);


$japaneseGoblin = ['/recover', '/help', '/about', '/about/terms', '/about/privacy', '/about/cookies'];
foreach ($japaneseGoblin as $route) {
  Route::get($route, function () {
    return Inertia::location('https://youtu.be/UIp6_0kct_U');
  });
}

Route::middleware(['auth'])->group(
  function () {

    Route::post('/logout', [UserController::class, 'logout']);

    Route::get('/', function () {
      return Inertia::render('Home', [
        'users' => User::all()
          ->map(function ($user) {
            return [
              'id' => $user->id,
              'firstname' => $user->firstname,
              'surname' => $user->surname,
            ];
          }),
        'auths' => [
          'id' => Auth::user()->id,
          'firstname' => Auth::user()->firstname,
          'surname' => Auth::user()->surname,
        ],
        'posts' => Post::with(['user' => function($query) {
          $query->select('id', 'firstname', 'surname');
      }])->latest()->get(),
      ]);
    });

    Route::post('/store', [PostController::class, 'store']);

  }
);
