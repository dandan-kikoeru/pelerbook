<?php

use App\Models\Post;
use App\Models\User;
use Inertia\Inertia;
use App\Services\Formatting;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
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

    /**
     * Home
     */
    Route::get('/', function (Request $request) {

      $posts = Post::latest()->cursorPaginate(10);

      if ($request->wantsJson()) {
        return PostResource::collection($posts);
      }

      return Inertia::render('Home', [
        'posts' => PostResource::collection($posts),
      ]);
    });

    Route::post('/store', [PostController::class, 'store']);
    Route::get('/settings', function () {
      sleep(1);
      return Inertia::render('Settings');
    });
    Route::post('settings', [UserController::class, 'update']);

    Route::post('/delete/{id}', [PostController::class, 'destroy']);
    Route::post('/edit/{id}', [PostController::class, 'update']);

    Route::get(
      '/post/{id}',
      function ($id) {
        $post = Post::find($id);
        if (!$post) {
          return abort(404);
        }

        return Inertia::render('SinglePost', [
          'post' => Post::where('id', $id)
            ->with([
              'user' => function ($q) {
                $q->select('id', 'firstname', 'surname', 'avatar');
              }
            ])
            ->latest()
            ->get()
            ->map(function ($post) {
              $post->created_at_human = $post->created_at->diffForHumans();
              $post->caption = Formatting::format_message($post->caption);
              return $post;
            }),
        ]);
      }
    );

    /**
     * Profile
     */

    Route::get('/{id}', function ($id, User $user) {
      sleep(1);
      $user = User::find($id);

      if (!$user) {
        return abort(404);
      }
      return Inertia::render('Profile', [
        'posts' =>
          Post::where('user_id', $id)
            ->select('id', 'caption', 'created_at', 'user_id')
            ->with([
              'user' => function ($q) {
                $q->select('id', 'firstname', 'surname', 'avatar');
              }
            ])
            ->latest()
            ->get()
            ->map(function ($post) {
              $post->created_at_human = $post->created_at->diffForHumans();
              $post->caption = Formatting::format_message($post->caption);
              return $post;
            }),
        'profile' => [
          'id' => $user->id,
          'firstname' => $user->firstname,
          'surname' => $user->surname,
        ]
      ]);
    });

  }
);
