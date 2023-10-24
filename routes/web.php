<?php

use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

Route::middleware(['guest'])->group(function () {

  Route::get('/login', function () {
    return Inertia::render('Auth/Login');
  })->name('login');
  Route::post('/login', [UserController::class, 'login']);
  Route::post('/register', [UserController::class, 'register']);
});

$japaneseGoblin = ['/recover', '/help', '/about', '/about/terms', '/about/privacy', '/about/cookies'];
foreach ($japaneseGoblin as $route) {
  Route::get($route, function () {
    return Inertia::location('https://youtu.be/UIp6_0kct_U');
  });
}

Route::middleware(['auth'])->group(
  function () {

    Route::post('/logout', [UserController::class, 'logout']);
    Route::redirect('/home', '/');

    Route::get('/', function () {
      sleep(1);
      $posts = Post::latest()
        ->with([
          'user' => function ($q) {
            $q->select('id', 'firstname', 'surname');
          }
        ])
        ->get()
        ->map(function ($post) {
          $post->created_at_human = $post->created_at->diffForHumans();
          $post->caption = nl2br($post->caption);
          return $post;
        });
      return Inertia::render('Home', [
        'posts' => $posts
      ]);
    });

    Route::post('/store', [PostController::class, 'store']);

    Route::get('/{id}', function ($id) {
      sleep(1);
      return Inertia::render('Profile', [
        'posts' =>
          Post::where('user_id', $id)
            ->select('id', 'caption', 'created_at', 'user_id')
            ->with([
              'user' => function ($q) {
                $q->select('id', 'firstname', 'surname');
              }
            ])
            ->latest()
            ->get()
            ->map(function ($post) {
              $post->created_at_human = $post->created_at->diffForHumans();
              return $post;
            }),
        'profileId' => intVal($id),
      ]);
    });

    Route::post('/delete/{id}', [PostController::class, 'destroy']);
  }
);
