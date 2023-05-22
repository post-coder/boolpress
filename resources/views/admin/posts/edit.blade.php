@extends('layouts.admin')

@section('content')

<div class="container">
  <h1 class="mb-3">Modifica il post</h1>

  <form action="{{route('admin.posts.update', $post)}}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label for="title">Titolo</label>
      <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{old('title') ?? $post->title}}">
      @error('title')
        <div class="invalid-feedback">
          {{$message}}
        </div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="content">Contenuto del post</label>
      <textarea name="content" id="content" cols="30" rows="10" class="form-control  @error('content') is-invalid @enderror">{{old('content') ?? $post->content}}</textarea>
      @error('content')
        <div class="invalid-feedback">
          {{$message}}
        </div>
      @enderror
    </div>
    
    <button class="btn btn-primary" type="submit">Modifica</button>
  </form>
</div>

@endsection