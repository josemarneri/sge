@extends('layouts.master')

@section('content')
<div class="area-util">
    <div class="title-2">
        Lista de perfil de Acesso        
    </div>
    <table class="table table-hover table-condensed" >
        <thead>
        <a href="{{url("/painel/perfis/novo")}}" title="Adicionar Perfil de acesso">
                <img src="{{url('/assets/imagens/Add.png')}}" alt="Adicionar Acesso" />
            </a>
            <tr>
                <th style="text-align: center">Id</th>
                <th style="text-align: center">Nome</th>
                <th style="text-align: center">Descrição</th>
                <th style="text-align: center">Permissões</th>
                <th width="100" style="text-align: center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perfis as $perfil)               
            <tr>
                <td style="text-align: center">{{$perfil->id}}</td>
                <td style="text-align: center">{{$perfil->name}}</td>
                <td style="text-align: center">{{$perfil->label}}</td>
                <td style="text-align: center">
                    <select id="permissao" name="permissao" >
                        @foreach($perfil->getPermissions() as $permissao)
                            <option >{{$permissao->label}}</option>
                        @endforeach
                    </select>
                </td>
                <td style="text-align: center">
                    <a href="{{url("/painel/perfis/atualizar/$perfil->id")}}" title="alterar dados da acesso">
                        <img src="{{url('/assets/imagens/Edit.png')}}" alt="alterar dados do acesso" /> 
                    </a>
                    <a href="{{url("/painel/perfis/apagar/$perfil->id")}}" title="Remover acesso">
                        <img src="{{url('/assets/imagens/Delete.png')}}" alt="Remover acesso" />
                    </a>
                </td>
            </tr>
            @empty
                <p> Nenhum perfil cadastrado!!!</p>
            @endforelse
        </tbody>
    </table>

    
    
</div>
@endsection


