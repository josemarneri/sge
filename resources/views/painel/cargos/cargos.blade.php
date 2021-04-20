@extends('layouts.master')

@section('content')
<div class="area-trabalho">
    <div class="title-2">
        Lista de Cargos        
    </div>
    <table class="table table-hover table-condensed" >
        <thead>
        <a href="{{url("/painel/cargos/novo")}}" title="Adicionar Cargo">
                <img src="{{url('/assets/imagens/Add.png')}}" alt="Adicionar Cargo" />
            </a>
            <tr>
                <th style="text-align: center">Id</th>
                <th style="text-align: center">Nome</th>
                <th style="text-align: center">Descrição</th>
                <th width="100" style="text-align: center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cargos as $cargo)               
            <tr>
                <td style="text-align: center">{{$cargo->id}}</td>
                <td style="text-align: center">{{$cargo->nome}}</td>
                <td style="text-align: center">{{$cargo->descricao}}</td>
                <td width="100" style="text-align: center">
                    <a href="{{url("/painel/cargos/atualizar/$cargo->id")}}" title="alterar dados do cargo">
                        <img src="{{url('/assets/imagens/Edit.png')}}" alt="alterar dados do cargo" /> 
                    </a>
                    <a href="{{url("/painel/cargos/apagar/$cargo->id")}}" title="Remover cargo">
                        <img src="{{url('/assets/imagens/Delete.png')}}" alt="Remover cargo" />
                    </a>
                </td>
            </tr>
            @empty
                <p> Nenhum cargo cadastrado!!!</p>
            @endforelse
        </tbody>
    </table>

    
    
</div>
@endsection


