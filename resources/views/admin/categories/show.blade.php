@extends('layouts.admin')

@section('content')

<div class="container py-3">

  <h1>Tutti i post di categoria "{{$category->name}}"</h1>

  @if( count($category->posts) > 0)
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

      @foreach($category->posts as $post)
        <tr>
          <td>
            {{$post->title}}
          </td>
          <td>
            {{$post->slug}}
          </td>
          <td>
            <a href="{{route('admin.posts.show', $post)}}"><i class="fa-solid fa-magnifying-glass"></i></a>
          </td>
        </tr>
      @endforeach

    </tbody>
  </table>
  @else

    <em>Nessun post di questa categoria</em>
      
  @endif


  <hr>

  <div class="d-flex justify-content-around">
    <a href="{{route('admin.categories.edit', $category)}}" class="btn btn-secondary">Modifica la categoria</a>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
      Elimina
    </button>
    
  </div>

</div>


<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="deleteModalLabel">Elimina la categoria</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Sei sicuro di voler eliminare la categoria {{$category->name}}?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
        
        <form action="{{route('admin.categories.destroy', $category)}}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Elimina</button>
        </form>

      </div>
    </div>
  </div>
</div>


@endsection