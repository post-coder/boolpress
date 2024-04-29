<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    
    public function index() {
        // restituirà tutti i post dal db

        // per ricevere tutti i post senza paginazione
        // $posts = Post::all();

        // per ricevere i post con paginazione
        // $posts = Post::paginate(2);

        // per ricevere i post E tutte le categorie e i tag collegati
        $posts = Post::with(['category', 'tags'])->paginate(2);

        

        // dd($posts);

        // restituiamo un oggetto php che verrà convertito in JSON
        // i dati utili dell'api sono dentro la proprietà "results"
        return response()->json([
            "success" => true,
            "results" => $posts
        ]);

    }

}
