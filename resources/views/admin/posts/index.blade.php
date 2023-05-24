@extends('layouts.admin')

@section('content')
<div class="container">
  <h1>Tutti i post</h1>

  <table class="table table-striped mb-4">
    <thead>
      <th>
        Titolo
      </th>
      <th>
        Slug
      </th>
      <th>
        Categoria
      </th>
      <th>
        Tags
      </th>
      <th>

      </th>
    </thead>

    <tbody>
      @foreach($posts as $post)
        <tr>
          <td>
            {{$post->title}}
          </td>
          <td>
            {{$post->slug}}
          </td>
          <td>
            {{$post->category?->name}}
          </td>
          <td>
            {{-- @foreach($post->tags as $tag)
            <span class="badge rounded-pill mx-1" style="background-color: {{$tag->color}}">{{$tag->name}}</span>
            @endforeach --}}
            @php
            $tagNames = [];
            
            foreach ($post->tags as $tag) {
              $tagNames[] = $tag->name;
            }

            echo implode(', ', $tagNames);
            @endphp
          </td>
          <td>
            <a href="{{route('admin.posts.show', $post)}}"><i class="fa-solid fa-magnifying-glass"></i></a>
          </td>
        </tr>
      @endforeach

    </tbody>
  </table>

  <div class="d-flex justify-content-around">
    <a href="{{route('admin.posts.create')}}" class="btn btn-primary">
      Aggiungi un post
    </a>
  </div>
</div>
@endsection