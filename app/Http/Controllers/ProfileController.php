<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;

class ProfileController extends Controller
{
    public function index($id, Request $request)
    {
        $takePage = $request->input('take', 1);

        $user = User::find($id);

        $posts = Post::where('user_id', $user->id)->latest()->paginate(10 * $takePage);
        return PostResource::collection($posts);
    }
}
