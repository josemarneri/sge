@extends('layouts.master')

@section('content')
<div class="area-trabalho">
    <div class="title-2">
        Lista de Fornecedores        
    </div>
    <table class="table table-hover table-condensed" >
        <thead>
        <a href="{{url("/painel/fornecedores/novo")}}" title="Adicionar Empresa">
                <img src="{{url('/assets/imagens/Add.png')}}" alt="Adicionar Empresa" />
            </a>
            <tr>
                <th style="text-align: center">Id</th>
                <th style="text-align: center">Nome</th>
                <th style="text-align: center">CNPJ</th>
                <th style="text-align: center">Endereço</th>
                <th style="text-align: center">Telefone</th>
                <th style="text-align: center">Email</th>
                <th width="100" style="text-align: center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($fornecedores as $fornecedor)               
            <tr>
                <td style="text-align: center">{{$fornecedor->id}}</td>
                <td style="text-align: center">{{$fornecedor->nome}}</td>
                <td style="text-align: center">{{$fornecedor->cnpj}}</td>
                <td style="text-align: center">{{$fornecedor->endereco}}</td>
                <td style="text-align: center">{{$fornecedor->telefone}}</td>
                <td style="text-align: center">{{$fornecedor->email}}</td>
                <td width="100" style="text-align: center">
                    <a href="{{url("/painel/fornecedores/atualizar/$fornecedor->id")}}" title="alterar dados da fornecedor">
                        <img src="{{url('/assets/imagens/Edit.png')}}" alt="alterar dados do fornecedor" /> 
                    </a>
                    <a href="{{url("/painel/fornecedores/apagar/$fornecedor->id")}}" title="Remover fornecedor">
                        <img src="{{url('/assets/imagens/Delete.png')}}" alt="Remover fornecedor" />
                    </a>
                </td>
            </tr>
            @empty
                <p> Nenhum fornecedor cadastrado!!!</p>
            @endforelse
        </tbody>
    </table>

    
    
</div>
@endsection


