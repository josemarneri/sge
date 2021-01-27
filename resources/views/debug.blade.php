@extends('layouts.app')

@section('content')
<div class="container">
    @can('edit_post',$post)
        <h1>{{$post->title}}</h1>
        <p>{{$post->description}}</p><br>
        <b>Author: {{$post->user->name}}</b>
    @endcan
</div>
@endsection
