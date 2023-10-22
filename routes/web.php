<?php

use App\Http\Controllers\UserController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
  return Inertia::render('Auth/Login');
})->name('login');

Route::get('/register', function () {
  return Inertia::render('Auth/Register');
})->name('register');

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);


$japaneseGoblin = ['/recover', '/help', '/about', '/about/terms', '/about/privacy', '/about/cookies'];
foreach ($japaneseGoblin as $route) {
  Route::get($route, function () {
    return Inertia::location('https://youtu.be/UIp6_0kct_U');
  });
}

Route::middleware(['auth'])->group(
  function () {
    Route::get('/', function () {
      return Inertia::render('Home');
    });
  }
);
