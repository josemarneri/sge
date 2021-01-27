@extends('layouts.app')

@section('content')

<div class="container">
    @if(Session::has('mensagem_sucesso'))
        <div class="alert alert-success">{{Session::get('mensagem_sucesso')}}</div>    
    @endif
    <form method="POST" action="{{url("post/salvar")}}" accept-charset="UTF-8"><input name="_token" type="hidden" value="{{{csrf_token()}}}">
        <label for="id">Id:</label>
        <input class="form-control" placeholder="Id" name="id" type="text" value="{{$post->id}}" id="id">        
        <label for="user_id">User Id:</label>
        <input class="form-control" placeholder="User Id" name="user_id" type="text" value="{{$post->user_id}}" id="user_id">
        <label for="title">Titulo:</label>
        <input class="form-control" placeholder="titulo" name="title" type="text" value="{{$post->title}}" id="title">
        <label for="description">Descrição:</label>
        <input class="form-control" placeholder="descrição" name="description" type="text" value="{{$post->description}}" id="description">
        <input class="btn btn-primary" type="submit" value="Salvar">
    </form>
</div>
@endsection


