<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

// helper per gestire le stringhe
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = Post::all();

        // prendo l'id dell'utente
        $user_id = Auth::id();


        $posts = Post::where('user_id', $user_id)->get();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formData = $request->all();

        $this->validation($formData);
        
        $post = new Post();
        
        
        // prima di salvare la riga controlliamo che sia stato inviato un file
        if($request->hasFile('cover_image')) {
            
            // Storage::put crea la cartella specificata in caso non esista
            $path = Storage::put('post_images', $request->cover_image);
            
            // memorizzo il path dell'immagine salvata nell'array delle informazioni pronte da salvare nel db
            $formData['cover_image'] = $path;
        }
        
        $post->fill($formData);

        $post->user_id = Auth::id();

        // inserisco lo slug utilizzando l'helper Str
        $post->slug = Str::slug($post->title, '-');
        
        // il save va fatto prima dell'inserimento dei tag (relazione molti a molti)
        // perchè solo quando effettuiamo il salvataggio della riga nel database viene generato l'id
        $post->save();
    
        // dobbiamo inserire i tag relativi al post nella tabella ponte
        if(array_key_exists('tags',$formData)) {
            // il metodo attach della risorsa many-to-many "tags" che abbiamo collegato a Post (RICORDIAMOCI di usare le tonde)
            // ci permette di inserire in automatico nella tabella ponte i collegamenti, riga per riga, con i tag
            // passatigli tramite un array
            $post->tags()->attach($formData['tags']);
        }

        return redirect()->route('admin.posts.show', $post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if($post->user_id == Auth::id()) {
            
            return view('admin.posts.show', compact('post'));
        } else {
            // se l'utente ha provato a visualizzare IN AMMINISTRAZIONE un post di qualcun altro (con strane intenzioni evidentemente) viene dirottato alla index
            return redirect()->route('admin.posts.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if($post->user_id != Auth::id()) {
            return redirect()->route('admin.posts.index');
        }

        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $formData = $request->all();

        // dd($formData);

        $this->validation($formData);


        if($request->hasFile('cover_image')) {

            if($post->cover_image) {
                // cancelliamo la vecchia immagine
                Storage::delete($post->cover_image);
            }

            // salviamo la nuova
            // Storage::put crea la cartella specificata in caso non esista
            $path = Storage::put('post_images', $request->cover_image);
            
            // memorizzo il path dell'immagine salvata nell'array delle informazioni pronte da salvare nel db
            $formData['cover_image'] = $path;

        }


        $post->slug = Str::slug($formData['title'], '-');
        // $formData['slug'] = Str::slug($formData['title'], '-');
        $post->update($formData);

        // dobbiamo sempre controllare che l'array esista
        if(array_key_exists('tags',$formData)) {
            // la funzione sync() ci permette di sincronizzare i tag selezionati nel form con quelli presenti nella tabella ponte
            $post->tags()->sync($formData['tags']);
        } else {
            // dobbiamo specificare che se non è stato selezionato alcun tag, deve eliminare tutti i suoi riferimenti dalla tabella ponte
            $post->tags()->detach();
        }

        return redirect()->route('admin.posts.show', $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if($post->cover_image) {
            Storage::delete($post->cover_image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index');
    }



    // validazione
    private function validation($formData) {
        $validator = Validator::make($formData, [
            'title' => 'required|max:255|min:3',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'exists:tags,id',
            'cover_image' => 'nullable|image|max:4096',
        ], [
            'title.max' => 'Il titolo deve avere massimo :max caratteri',
            'title.required' => 'Devi inserire un titolo',
            'title.min' => 'Il titolo deve avere minimo :min caratteri',
            'content.required' => 'Il post deve avere un contenuto',
            'category_id.exists' => 'La categoria deve essere presente nel nostro sito',
            'cover_image.max' => "La dimensione del file è troppo grande",
            'cover_image.image' => "Il file deve essere di tipo immagine",
        ])->validate();
    }
}
