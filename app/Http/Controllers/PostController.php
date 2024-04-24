<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // prendiamo tutte le categorie dal db
        // le passiamo alla view per mostrarle
        $categories = Category::all();

        // prelevo tutti i tag dal database e li passo alla vista
        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        // dd($request);

        // validiamo i nostri parametri
        $request->validated();

        $newPost = new Post();
        
        // controlliamo se nella request è presente un file in arrivo
        if($request->hasFile('cover_image')) {
            // ci salviamo il percorso dell'immagine in una variabile e contemporaneamente salviamo l'immagine nel server
            // la cartella che abbiamo indicato nel metodo put() se è già presente viene utilizzata, altrimenti viene creata vuota
            $path = Storage::disk('public')->put('post_images', $request->cover_image);
    
            // salvo il nuovo percorso che ho ottenuto dal salvataggio dell'immagine (Laravel per privacy e sicurezza cambia il nome del file)
            $newPost->cover_image = $path;
        }
        

        $newPost->fill($request->all());

        // dd($newPost);
        $newPost->save();


        // quando dobbiamo inserire dei dati presenti in una tabella ponte (con relazione many to many)
        // dobbiamo fare tutto DOPO il ->save()

        // importante: quando colleghiamo un metodo ai tag (in questo caso) siamo obbligati ad inserire le parentesi
        // normalmente, se dobbiamo solo leggere i tags invece non sono necessarie
        $newPost->tags()->attach($request->tags);


        return redirect()->route('admin.posts.show', $newPost->id);

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        // dd($post->tags);
        return view("admin.posts.show", compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        // dd($request);

        $request->validated();

        // siccome la cover image è nullable prima controlliamo se è stata inserita
        if($request->hasFile('cover_image')) {
            // ci salviamo il percorso dell'immagine in una variabile e contemporaneamente salviamo l'immagine nel server
            // la cartella che abbiamo indicato nel metodo put() se è già presente viene utilizzata, altrimenti viene creata vuota
            $path = Storage::disk('public')->put('post_images', $request->cover_image);
    
            // salvo il nuovo percorso che ho ottenuto dal salvataggio dell'immagine (Laravel per privacy e sicurezza cambia il nome del file)
            $post->cover_image = $path;
        }

        $post->update($request->all());


        // modifichiamo i tag collegati al post
        $post->tags()->sync($request->tags);


        return redirect()->route('admin.posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index');
    }
}
