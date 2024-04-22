@extends('layouts.app')

@section('content')

<div class="container py-5">

    <h1>Pagina di amministrazione</h1>

    <h2>Benvenuto {{$user->name}}</h2>
    {{-- @dump($user) --}}


    <a href="{{route('admin.posts.create')}}" class="btn btn-info">Aggiungi un post</a>

</div>

@endsection