<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;

class PostController extends Controller
{
  public function store(Request $request)
  {
    $post = $request->validate([
      'caption' => 'required',
    ]);
    $post['user_id'] = Auth()->user()->id;

    Post::create($post);
    return Inertia::location('/');
  }

  public function destroy(Post $id)
  {
    if (Auth()->user()->id = $id->user_id) {
      $id->delete();
      return redirect('/');
    }
    return abort(404);
  }
}
