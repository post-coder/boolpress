<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    
    public function index() {
        // restituirà tutti i post dal db

        $posts = Post::all();

        // dd($posts);

        // restituiamo un oggetto php che verrà convertito in JSON
        // i dati utili dell'api sono dentro la proprietà "results"
        return response()->json([
            "success" => true,
            "results" => $posts
        ]);

    }

}
