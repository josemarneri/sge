@extends('layouts.master')

@section('content')
<div class="area-trabalho">
    <div class="title-2">
        Lista de Descontos        
    </div>
    <table class="table table-hover table-condensed" >
        <thead>
        <a href="{{url("/painel/descontos/novo")}}" title="Adicionar Desconto">
                <img src="{{url('/assets/imagens/Add.png')}}" alt="Adicionar Desconto" />
            </a>
            <tr>
                <th style="text-align: center">Id</th>
                <th style="text-align: center">Nome</th>
                <th style="text-align: center">Descrição</th>
                <th style="text-align: center">Valor (R$)</th>
                <th style="text-align: center">Valor (%)</th>

                <th width="130" style="text-align: center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($descontos as $desconto)               
            <tr>
                <td style="text-align: center">{{$desconto->id}}</td>
                <td style="text-align: center">{{$desconto->nome}}</td>
                <td style="text-align: center">{{$desconto->descricao}}</td>
                <td style="text-align: center">{{$desconto->valor}}</td>
                <td style="text-align: center">{{$desconto->percentual}}</td>

                <td width="130" style="text-align: center">
                    <a href="{{url("/painel/descontos/ativardesativar/".$desconto->id)}}" title="Ativar/Desativar">
                        <img src="{{url("/assets/imagens/ativo".$desconto->ativo.".png")}}" /> 
                    </a>
                    <a href="{{url("/painel/descontos/descontados/".$desconto->id)}}" title="Adicionar funcionários">
                        <img src="{{url('/assets/imagens/users.png')}}" alt="Adicionar funcionarios" />
                    </a>
                    <a href="{{url("/painel/descontos/atualizar/$desconto->id")}}" title="alterar dados do desconto">
                        <img src="{{url('/assets/imagens/Edit.png')}}" alt="alterar dados do desconto" /> 
                    </a>
                    <a href="{{url("/painel/descontos/apagar/$desconto->id")}}" title="Remover desconto">
                        <img src="{{url('/assets/imagens/Delete.png')}}" alt="Remover desconto" />
                    </a>
                </td>
            </tr>
            @empty
                <p> Nenhum desconto cadastrado!!!</p>
            @endforelse
        </tbody>
    </table>

   
    
</div>
@endsection


