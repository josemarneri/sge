@extends('layouts.master')

@section('content')
<div class="area-trabalho">
    <div class="title-2">
        Lista de Despesas        
    </div>
    <table class="table table-hover table-condensed" >
        <thead>
        <a href="{{url("/financeiro/despesas/novo")}}" title="Adicionar Cliente">
                <img src="{{url('/assets/imagens/Add.png')}}" alt="Adicionar Cliente" />
            </a>
            <tr>
                <th style="text-align: center">Id</th>
                <th style="text-align: center">Nome</th>
                <th style="text-align: center">Descrição</th>
                <th width="100" style="text-align: center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($despesas as $despesa)               
            <tr>
                <td style="text-align: center">{{$despesa->id}}</td>
                <td style="text-align: center">{{$despesa->nome}}</td>
                <td style="text-align: center">{{$despesa->descricao}}</td>
                <td width="100" style="text-align: center">
                    <a href="{{url("/financeiro/despesas/atualizar/$despesa->id")}}" title="alterar dados do despesa">
                        <img src="{{url('/assets/imagens/Edit.png')}}" alt="alterar dados do despesa" /> 
                    </a>
                    <a href="{{url("/financeiro/despesas/apagar/$despesa->id")}}" title="Remover despesa">
                        <img src="{{url('/assets/imagens/Delete.png')}}" alt="Remover despesa" />
                    </a>
                </td>
            </tr>
            @empty
                <p> Nenhum despesa cadastrado!!!</p>
            @endforelse
        </tbody>
    </table>

    
    
</div>
@endsection


