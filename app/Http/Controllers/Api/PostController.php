<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request) {
        
        
        $requestData = $request->all();

        $categories = Category::all();

        // controllo se è stata chiesta una categoria specifica
        if($request->has('category_id') && $requestData['category_id']) {

            $posts = Post::where('category_id', $requestData['category_id'])
                ->with('category', 'tags')
                ->orderBy('posts.created_at', 'desc')
                ->get();

            if(count($posts) == 0) {
                return response()->json([
                    'success' => false,
                    'error' => 'Nessun post fa parte di questa categoria',
                ]);
            }
            

        } else {
            // restituisce tutti i post nel db
            // $posts = Post::all();
            $posts = Post::with('category', 'tags')
            ->orderBy('posts.created_at', 'desc')
            ->get();

        }

        return response()->json([
            'success' => true,
            'results' => $posts,
            'allCategories' => $categories,
        ]);

    }

    public function show($slug) {
        
        // controllare se questa stringa corrisponde ad uno slug dei post nel db
        // una volta che abbiamo stilato la query, se vogliamo ricevere solo un risultato, dobbiamo inserire ->first()
        $post = Post::where('slug', $slug)->with('category', 'tags')->first();
        // "SELECT * FROM posts WHERE slug = $slug";

        if($post) {

            return response()->json([
                'success' => true,
                'post' => $post,
            ]);

        } else {

            return response()->json([
                'success' => false,
                'error' => 'Il post non esiste',
            ]);

        }

        
    }
}
