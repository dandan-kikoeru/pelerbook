<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
  public function store(Request $request)
  {
    $request->validate([
      'caption' => 'required',
    ]);
    $post = [
      'user_id' => Auth()->user()->id,
      'id' => Str::random(16),
      'caption' => $request->caption
    ];

    Post::create($post);
    return Inertia::location('/');
  }

  public function destroy(Post $id)
  {
    if (Auth()->user()->id = $id->user_id) {
      $id->delete();
      return back();
    }
    return abort(404);
  }

}
