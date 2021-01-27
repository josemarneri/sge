@extends('layouts.master')

@section('content')
<div class="area-util">
    
    @if(Session::has('mensagem_sucesso'))
        <div class="alert alert-success">{{Session::get('mensagem_sucesso')}}</div>    
    @endif
    
    <div class="title-2">
        Listagem de usuários        
    </div>
    <table class="table table-hover table-condensed" >
        <thead>
        <a href="{{url("/painel/usuarios/novo")}}" title="Adicionar usuário">
                <img src="{{url('/assets/imagens/Add.png')}}" alt="Adicionar usuário" />
            </a>
            <tr>
                <th style="text-align: center">Id</th>
                <th style="text-align: center">Nome</th>
                <th style="text-align: center">Login</th>
                <th style="text-align: center">Email</th>
                <th style="text-align: center">Perfil</th>
                <th width="100" style="text-align: center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            @if($user->id != 2 )                
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->login}}</td>
                <td>{{$user->email}}</td>
                <td style="text-align: center">
                    <select id="perfil" name="perfil" >
                        @foreach($user->getRoles() as $role)
                            <option >{{$role->label}}</option>
                        @endforeach
                    </select>
                    <a href="{{url("/painel/perfis/addusuarioperfil/$user->id")}}" title="Alterar perfil do usuário">
                        <img src="{{url('/assets/imagens/editperfil.png')}}" alt="Alterar perfil do usuário" /> 
                    </a>
                </td>
                <td>
                    <a href="{{url("/painel/usuarios/ativar/".$user->id)}}" title="Ativar/Desativar o usuário">
                        <img src="{{url("/assets/imagens/ativo".$user->ativo.".png")}}" alt="Ativar/Desativar o usuário" /> 
                    </a>
                    
                    <a href="{{url("/painel/usuarios/atualizar/$user->id")}}" title="alterar dados do usuário">
                        <img src="{{url('/assets/imagens/edit.png')}}" alt="alterar dados do usuário" /> 
                    </a>
                    <a href="{{url("/painel/usuarios/apagar/$user->id")}}" title="Remover usuário">
                        <img src="{{url('/assets/imagens/delete.png')}}" alt="Remover usuário" />
                    </a>
                </td>
            </tr>
            @endif
            @empty
                <p> Nenhum post cadastrado!!!</p>
            @endforelse
        </tbody>
    </table>

    
    
</div>
@endsection


