@extends('layouts.master')

@section('content')
<div class="area-trabalho">
    <div class="title-2">
        Lista de Beneficios        
    </div>
    <table class="table table-hover table-condensed" >
        <thead>
        <a href="{{url("/painel/beneficios/novo")}}" title="Adicionar Beneficio">
                <img src="{{url('/assets/imagens/Add.png')}}" alt="Adicionar Beneficio" />
            </a>
            <tr>
                <th style="text-align: center">Id</th>
                <th style="text-align: center">Nome</th>
                <th style="text-align: center">Descrição</th>
                <th style="text-align: center">Valor (R$)</th>
                <th style="text-align: center">Valor (%)</th>
                <th style="text-align: center">Desconto (R$)</th>
                <th style="text-align: center">Desconto (%)</th>
                <th width="130" style="text-align: center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($beneficios as $beneficio)               
            <tr>
                <td style="text-align: center">{{$beneficio->id}}</td>
                <td style="text-align: center">{{$beneficio->nome}}</td>
                <td style="text-align: center">{{$beneficio->descricao}}</td>
                <td style="text-align: center">{{$beneficio->valor}}</td>
                <td style="text-align: center">{{$beneficio->percentual}}</td>
                <td style="text-align: center">{{$beneficio->desconto_valor}}</td>
                <td style="text-align: center">{{$beneficio->desconto_percentual}}</td>
                <td width="130" style="text-align: center">
                    <a href="{{url("/painel/beneficios/ativardesativar/".$beneficio->id)}}" title="Ativar/Desativar">
                        <img src="{{url("/assets/imagens/ativo".$beneficio->ativo.".png")}}" /> 
                    </a>
                    <a href="{{url("/painel/beneficios/beneficiados/".$beneficio->id)}}" title="Adicionar beneficiados">
                        <img src="{{url('/assets/imagens/users.png')}}" alt="Adicionar beneficiados" />
                    </a>
                    <a href="{{url("/painel/beneficios/atualizar/$beneficio->id")}}" title="alterar dados do beneficio">
                        <img src="{{url('/assets/imagens/Edit.png')}}" alt="alterar dados do beneficio" /> 
                    </a>
                    <a href="{{url("/painel/beneficios/apagar/$beneficio->id")}}" title="Remover beneficio">
                        <img src="{{url('/assets/imagens/Delete.png')}}" alt="Remover beneficio" />
                    </a>
                </td>
            </tr>
            @empty
                <p> Nenhum beneficio cadastrado!!!</p>
            @endforelse
        </tbody>
    </table>

   
    
</div>
@endsection


