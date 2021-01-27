@extends('layouts.master')

@section('content')
<div class="area-util">
    <div class="title-2">
        Lista de Clientes        
    </div>
    <table class="table table-hover table-condensed" >
        <thead>
        <a href="{{url("/painel/clientes/novo")}}" title="Adicionar Cliente">
                <img src="{{url('/assets/imagens/Add.png')}}" alt="Adicionar Cliente" />
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
            @forelse($clientes as $cliente)               
            <tr>
                <td>{{$cliente->id}}</td>
                <td>{{$cliente->nome}}</td>
                <td>{{$cliente->cnpj}}</td>
                <td>{{$cliente->endereco}}</td>
                <td>{{$cliente->telefone}}</td>
                <td>{{$cliente->email}}</td>
                <td>
                    <a href="{{url("/painel/clientes/atualizar/$cliente->id")}}" title="alterar dados do cliente">
                        <img src="{{url('/assets/imagens/Edit.png')}}" alt="alterar dados do cliente" /> 
                    </a>
                    <a href="{{url("/painel/clientes/apagar/$cliente->id")}}" title="Remover cliente">
                        <img src="{{url('/assets/imagens/Delete.png')}}" alt="Remover cliente" />
                    </a>
                </td>
            </tr>
            @empty
                <p> Nenhum cliente cadastrado!!!</p>
            @endforelse
        </tbody>
    </table>

    
    
</div>
@endsection


