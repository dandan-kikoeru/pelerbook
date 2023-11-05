<?php

use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

/**
 * * API
 */

Route::middleware(['guest'])->group(function () {
  Route::post('/api/user/register', [UserController::class, 'register']);
  Route::post('/api/user/login', [UserController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
  Route::post('/api/user/logout', [UserController::class, 'logout']);
  Route::post('/api/user/update', [UserController::class, 'update']);

  Route::post('/api/post/store', [PostController::class, 'store']);
  Route::post('/api/post/update/{id}', [PostController::class, 'update']);
  Route::post('/api/post/destroy/{id}', [PostController::class, 'destroy']);

  Route::post('/api/like/{id}', [LikeController::class, 'like']);
});

Route::get('/login', function () {
  return Inertia::render('Auth/Login');
})->name('login')->middleware('guest');

$japaneseGoblin = ['/recover', '/help', '/about', '/about/terms', '/about/privacy', '/about/cookies'];
foreach ($japaneseGoblin as $route) {
  Route::get($route, function () {
    return Inertia::location('https://youtu.be/UIp6_0kct_U');
  });
}

Route::middleware(['auth'])->group(function () {
  Route::redirect('/home', '/');

  /**
   * * Home
   */

  //
  Route::get('/', function (Request $request) {
    $posts = Post::latest()->get();

    return Inertia::render('Home', [
      'posts' => PostResource::collection($posts),
    ]);
  });

  Route::get('/settings', function () {
    return Inertia::render('Settings');
  });

  /**
   * * Post
   */

  Route::get('/post/{id}', function ($id) {
    $post = Post::find($id);
    if (!$post) {
      return abort(404);
    }

    return Inertia::render('SinglePost', [
      'post' => new PostResource($post),
    ]);
  });

  /**
   * * Profile
   */

  Route::get('/{id}', function ($id, User $user, Request $request) {
    $user = User::find($id);
    $posts = Post::where('user_id', $id)->latest()->get();

    return Inertia::render('Profile', [
      'posts' => PostResource::collection($posts),
      'profile' => [
        'id' => $user->id,
        'firstname' => $user->firstname,
        'surname' => $user->surname,
      ]
    ]);
  });
});
