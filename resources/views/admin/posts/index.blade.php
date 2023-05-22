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
            <a href="{{route('admin.posts.show', $post)}}">Apri</a>
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