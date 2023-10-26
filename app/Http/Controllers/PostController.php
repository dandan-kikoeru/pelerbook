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
      'caption' => strip_tags($request->caption)
    ];
    Post::create($post);
    return Inertia::location('/post/' . $post['id']);
  }

  public function update(Request $request, Post $id)
  {
    $post = $request->validate([
      'caption' => 'required',
    ]);
    $post['caption'] = strip_tags($post['caption']);
    $id->update($post);
    return Inertia::location('/post/' . $id->id);
  }

  public function destroy(Post $id)
  {
    if (Auth()->user()->id = $id->user_id) {
      $id->delete();
      return Inertia::location('/');
    }
    return abort(404);
  }

}
