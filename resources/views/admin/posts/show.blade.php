@extends('layouts.admin')

@section('content')

<div class="container">
  <div class="text-center">
    <img src="{{ asset('storage/' . $post->cover_image) }}" alt="" class="w-50">
  </div>


  <h1>{{$post->title}}</h1>
  <span>Categoria: {{$post->category->name ?? 'nessuna'}}</span>
  <br>
  <span>Utente: {{$post->user->name}}</span>

  <div class="d-flex py-3">
    @foreach($post->tags as $tag)
      <span class="badge rounded-pill mx-1" style="background-color: {{$tag->color}}">{{$tag->name}}</span>
    @endforeach
  </div>

  <hr class="mb-4">

  <div class="py-3">
    
  
    <p>
      {{$post->content}}
    </p>

  </div>

  <div class="d-flex justify-content-around">
    <a href="{{route('admin.posts.edit', $post)}}" class="btn btn-primary">Modifica il post</a>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Elimina
    </button>
  </div>



</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Elimina il post</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Sei sicuro di voler eliminare il post "{{$post->title}}"
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
        <form action="{{route('admin.posts.destroy', $post)}}" method="POST">
          @csrf
          @method('DELETE')
        
          <button type="submit" class="btn btn-danger">Elimina il post</button>
        </form>
      </div>
    </div>
  </div>
</div>




@endsection