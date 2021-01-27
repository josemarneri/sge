@extends('layouts.master')

@section('content')
<div class="area-util">
    <div class="title-2">
        Lista de Permissões        
    </div>
    <table class="table table-hover table-condensed" >
        <thead>
        <a href="{{url("/painel/permissoes/novo")}}" title="Adicionar Permissão">
                <img src="{{url('/assets/imagens/Add.png')}}" alt="Adicionar Permissão" />
            </a>
            <tr>
                <th style="text-align: center">Id</th>
                <th style="text-align: center">Nome</th>
                <th style="text-align: center">Descrição</th>
                <th width="100" style="text-align: center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($permissoes as $permissao)               
            <tr>
                <td>{{$permissao->id}}</td>
                <td>{{$permissao->name}}</td>
                <td>{{$permissao->label}}</td>
                <td>
                    <a href="{{url("/painel/permissoes/atualizar/$permissao->id")}}" title="alterar dados da permissão">
                        <img src="{{url('/assets/imagens/Edit.png')}}" alt="alterar dados do permissão" /> 
                    </a>
                    <a href="{{url("/painel/permissoes/apagar/$permissao->id")}}" title="Remover permissão">
                        <img src="{{url('/assets/imagens/Delete.png')}}" alt="Remover permissão" />
                    </a>
                </td>
            </tr>
            @empty
                <p> Nenhuma permissão cadastrada!!!</p>
            @endforelse
        </tbody>
    </table>

    
    
</div>
@endsection


