@extends('layouts.master')

@section('content')
<div class="area-trabalho">
    <div class="title-2">
        Lista de Salarios        
    </div>
    <table class="table table-hover table-condensed" >
        <thead>
        <a href="{{url("/painel/salarios/novo")}}" title="Adicionar Salario">
                <img src="{{url('/assets/imagens/Add.png')}}" alt="Adicionar Salario" />
            </a>
            <tr>
                <th style="text-align: center">Id</th>
                <th style="text-align: center">Valor Mensal</th>
                <th style="text-align: center">Valor / Hora</th>
                <th style="text-align: center">Cargo</th>
                <th width="100" style="text-align: center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($salarios as $sal)               
            <tr>
                <td style="text-align: center">{{$sal->id}}</td>
                <td style="text-align: center">{{$sal->valor_mensal}}</td>
                <td style="text-align: center">{{$sal->valor_hora}}</td>
                <td style="text-align: center">{{$salario->getCargo($sal->id)->nome}}</td>
                <td width="100" style="text-align: center">
                    <a href="{{url("/painel/salarios/atualizar/$sal->id")}}" title="alterar dados do salario">
                        <img src="{{url('/assets/imagens/Edit.png')}}" alt="alterar dados do salario" /> 
                    </a>
                    <a href="{{url("/painel/salarios/apagar/$sal->id")}}" title="Remover salario">
                        <img src="{{url('/assets/imagens/Delete.png')}}" alt="Remover salario" />
                    </a>
                </td>
            </tr>
            @empty
                <p> Nenhum salario cadastrado!!!</p>
            @endforelse
        </tbody>
    </table>

    
    
</div>
@endsection


