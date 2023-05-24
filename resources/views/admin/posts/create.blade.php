@extends('layouts.admin')

@section('content')

<div class="container">
  <h1 class="mb-3">Crea un post</h1>

  <form action="{{route('admin.posts.store')}}" method="POST">
    @csrf

    <div class="mb-3">
      <label for="title">Titolo</label>
      <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{old('title')}}">
      @error('title')
        <div class="invalid-feedback">
          {{$message}}
        </div>
      @enderror
    </div>

    <div class="mb-3">
      <label for="category_id">Categoria</label>
      <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">

        <option>Nessuna</option>

        @foreach ($categories as $category)
            <option value="{{$category->id}}" {{$category->id == old('category_id') ? 'selected' : ''}}>{{$category->name}}</option>
        @endforeach

      </select>
      @error('category_id')
        <div class="invalid-feedback">
          {{$message}}
        </div>
      @enderror
    </div>

    <div class="mb-3 form-group">
      <h4>Tags</h4>

      @foreach($tags as $tag)
      <div class="form-check">
        <input type="checkbox" id="tag-{{$tag->id}}" name="tags[]" value="{{$tag->id}}">
        <label for="tag-{{$tag->id}}">{{$tag->name}}</label>
      </div>
      @endforeach

    </div>

    <div class="mb-3">
      <label for="content">Contenuto del post</label>
      <textarea name="content" id="content" cols="30" rows="10" class="form-control  @error('content') is-invalid @enderror">{{old('content')}}</textarea>
      @error('content')
        <div class="invalid-feedback">
          {{$message}}
        </div>
      @enderror
    </div>

    <button class="btn btn-primary" type="submit">Aggiungi</button>
  </form>
</div>

@endsection