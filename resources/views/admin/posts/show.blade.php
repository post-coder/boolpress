@extends('layouts.app')

@section('content')

<div class="container py-5">

  <div class="mb-4 text-center">
    <img src="{{asset('storage/' . $post->cover_image)}}" alt="Copertina immagine">
  </div>

  <h1>{{$post->title}}</h1>

  {{-- 
    Nullsafe operator: possibilità di accedere ad una variabile di un oggetto che non sappiamo se esista o no
    utilissimo per le relazioni con tabelle che possono anche essere nulle
  --}}
  <small>{{ $post->category?->title }}</small>


  <div class="d-flex gap-2 mb-5">
    @foreach ($post->tags as $tag)
    <span class="badge rounded-pill" style="background-color: {{$tag->color ?? 'rgba(255,255,255,.4)'}}">{{$tag->title}}</span>
    @endforeach
  </div>


  <p>
      {{$post->content}}
  </p>

  <hr>

  <a href="{{route('admin.posts.edit', $post)}}" class="btn btn-warning">Modifica</a>

  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
      Elimina
  </button>

<!-- Button trigger modal -->
  
  <!-- Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
            <h1 class="modal-title fs-5" id="deleteModalLabel">Elimina il post</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            Sei sicuro di voler eliminare il post?
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
            <form action="{{route('admin.posts.destroy', $post)}}" method="POST">
                @csrf
                @method("DELETE")
                <button class="btn btn-danger">Elimina</button>
            </form>
        </div>

      </div>
    </div>
  </div>


</div>

@endsection
