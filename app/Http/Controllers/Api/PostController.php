<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        // restituisce tutti i post nel db
        // $posts = Post::all();
        $posts = Post::with('category', 'tags')
            ->orderBy('posts.created_at', 'desc')
            ->paginate(6);

        return response()->json([
            'success' => true,
            'results' => $posts
        ]);
    }
}
