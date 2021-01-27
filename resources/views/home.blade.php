@extends('layouts.master')

@section('content')
<div class="area-util">
    @if(!empty(@posts))
        @forelse($posts as $post)
            @can('view_post',$post)
                    <h1>{{$post->title}}</h1>
                    <p>{{$post->description}}</p><br>
                    <b>Autor: {{$post->user->name}}</b>
                    @can('edit_notice',$notice)
                            <a href="{{url("post/$post->id/update")}}">Editar</a>
                            <hr>
                        @endcan
                @endcan

        @empty
            <p> Nenhuma noticia cadastrada!!!</p>

        @endforelse
    @endif
</div>
@endsection
