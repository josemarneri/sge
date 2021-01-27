@extends('layouts.app')

@section('content')

<div class="container">
    @if(Session::has('mensagem_sucesso'))
        <div class="alert alert-success">{{Session::get('mensagem_sucesso')}}</div>    
    @endif
    {!! Form::open(['url'=>'post/salvar' ]) !!}
        {!! Form::label('user_id', 'User Id:') !!}
        {!! Form::input('text','user_id', '', ['class'=>'form-control', 'placeholder'=>'User Id']) !!}
        {!! Form::label('title', 'Titulo:') !!}
        {!! Form::input('text','title', '', ['class'=>'form-control', 'placeholder'=>'titulo']) !!}
        {!! Form::label('description', 'Descricão:') !!}
        {!! Form::input('text','description', '', ['class'=>'form-control', 'placeholder'=>'descrição']) !!}
        {!! Form::submit('Salvar', ['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}
</div>
@endsection


