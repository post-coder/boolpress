@extends('layouts.app')

@section('content')

<div class="container py-5">

    <h1>Modifica il post</h1>

    <form action="{{route('admin.posts.update', $post->id)}}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Titolo" aria-describedby="titleHelper" value="{{old('title') ?? $post->title}}">
            @error('title')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
            <small id="titleHelper" class="text-muted">Titolo del post, massimo 255 caratteri</small>
        </div>

        <div class="mb-4">
            <label for="content">Contenuto</label>
            <textarea class="form-control  @error('content') is-invalid @enderror" name="content" id="content" rows="4">{{old('content') ?? $post->content}}</textarea>
            @error('content')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>

        <div class="mb-4">
            <img src="{{asset('storage/' . $post->cover_image)}}" alt="Copertina immagine">
            <label for="cover_image">Immagine di copertina</label>
            <input type="file" class="form-control @error('cover_image') is-invalid @enderror" name="cover_image">
            @error('cover_image')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>

        
        <div class="mb-4">

            <label for="category_id">Categoria</label>
            
            <select class="form-select" name="category_id" id="category_id">

                <option value=""></option>
                
                @foreach ($categories as $category)
                <option value="{{$category->id}}" {{ $category->id == old('category_id', $post->category ? $post->category->id : '') ? 'selected' : '' }}>
                    {{ $category->title }}
                </option>
                @endforeach

            </select>

        </div>

        {{-- @dump(old('tags')) --}}
        <div class="mb-4">
            <label class="mb-2" for="">Tag</label>
            <div class="d-flex gap-4">

                @foreach($tags as $tag)
                <div class="form-check ">
                    <input 
                        type="checkbox" 
                        name="tags[]"
                        value="{{$tag->id}}" 
                        class="form-check-input" 
                        id="tag-{{$tag->id}}"
                        
                        {{-- controlliamo se sono presenti errori (stiamo probabilmente ricevendo dei parametri old() ) --}}
                        {{-- se abbiamo errori e quindi old() --}}  
                        @if($errors->any())

                        {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}

                        @else 

                        {{ $post->tags->contains($tag) ? 'checked' : '' }}
                        
                        @endif
                    > 
                    
                    <label for="tag-{{$tag->id}}" class="form-check-label">{{$tag->title}}</label>
                </div>
                @endforeach

            </div>
        </div>

        <button class="btn btn-primary">Modifica</button>
    
    </form>

</div>

@endsection
