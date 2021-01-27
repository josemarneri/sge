@extends('layouts.tpainel')

@section('content')

<!-- Filtro e pesquisa -->

<div class="actions">
    <div class="container">
        <a class="add" href="forms">
            <i class="fa fa-plus-cicle"></i>
        </a>
        
        <form class="form-search form form-inline">
            <input type="text" name="pesquisar" placeholder="pesquisar?" class="">
            <input type="submit" name="pesquisar" class="btn">            
        </form>
        
    </div>   
</div>
<div class="clearfix"></div>

<div class="container">
    <h1 class="title">Listagem dos posts</h1>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Titulo</th>
                <th>Descrição</th>
                <th width="100px">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
            <tr>
                <td>{{$post->title}}</td>
                <td>{{$post->description}}</td>
                <td>
                    <a class="edit" href="{{url("/post/atualizar/$post->id")}}">
                        edit
                    </a>
                    <a class="delete" href="{{url("/post/apagar/$post->id")}}">
                        delete
                    </a>
                </td>
            </tr>
            @empty
                <p> Nenhum post cadastrado!!!</p>
            @endforelse
        </tbody>
    </table>

    
    
</div>
@endsection


