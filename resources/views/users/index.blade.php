@extends('layouts.basic')

@section('title', 'Home Page')
    
@section('content')
    <p> Posts: </p>

    <ul>
        @foreach ($posts as $post)
            <li><a href="{{ route('users.show', ['id' => $post->id]) }}">{{ $post->name }}</a></li>
        @endforeach
    </ul>

    <a href="{{ route('users.create') }}">Create Post </a>

    {{$posts->onEachSide(1)->links()}}

@endsection