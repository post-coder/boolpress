@extends('layouts.admin')

@section('content')

  <div class="container py-3">
    <h1>Categorie</h1>

    <table class="table table-striped">

      <thead>
        <th>Nome</th>
        <th>Descrizione</th>
        <th>Slug</th>
        <th>N° articoli</th>
        <th></th>
      </thead>

      <tbody>

        @foreach($categories as $category)
        
          <tr>
            <td>{{$category->name}}</td>
            <td>{{$category->description}}</td>
            <td>{{$category->slug}}</td>
            <td>{{ count($category->posts) }}</td>
            <td><a href="{{route('admin.categories.show', $category)}}"><i class="fa-solid fa-magnifying-glass"></i></a></td>
          </tr>

        @endforeach

      </tbody>

    </table>
  </div>

@endsection 