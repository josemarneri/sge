@extends('layouts.master')

@section('content')
<div class="area-trabalho">
    <script language="JavaScript" src="{{url('js/neri.js')}}"></script>
    <div class="title-2">
        Lista de funcionario        
    </div>
    <table class="table table-hover table-condensed " style="text-align: center">
        
        <thead> 
        <a href="{{url("/painel/funcionarios/novo")}}" title="Adicionar funcionario">
                <img src="{{url('/assets/imagens/Add.png')}}" alt="Adicionar funcionario" />
            </a>
        
            <tr>
                <th style="text-align: center">Registro</th>
                <th style="text-align: center">Nome</th>
                <th style="text-align: center">CPF</th>
                <th style="text-align: center">RG</th>
                <th style="text-align: center">Reg Cliente</th>
                <th style="text-align: center">Endereço</th>
                <th style="text-align: center">Email</th>
                <th style="text-align: center">Fornecedor</th>
                <th style="text-align: center">Usuário</th>
                <th width="130" style="text-align: center">Ações </th>
            </tr>
        </thead>
        <tbody>
            @forelse($funcionarios as $funcionario)
            <tr>                
                <td >{{$funcionario->id}}</td>
                <td >{{$funcionario->nome}}</td>
                <td >{{$funcionario->cpf}}</td>
                <td >{{$funcionario->rg}}</td>
                <td >{{$funcionario->regCiente}}</td>
                <td >{{$funcionario->endereco}}</td>
                <td >{{$funcionario->email}}</td>
                <td >{{$funcionario->fornecedor_id}}</td>
                <td >{{$funcionario->getUserLogin($funcionario->user_id)}}</td>
                
                <td width="130" style="text-align: center">
                    <a href="{{url("/painel/funcionarios/ativar/".$funcionario->id)}}" title="Ativar/Desativar o funcionário">
                        <img src="{{url("/assets/imagens/ativo".$funcionario->ativo.".png")}}" alt="Ativar/Desativar o funcionário" /> 
                    </a>
                    <a href="{{url("/painel/funcionarios/financeiro/".$funcionario->id)}}" title="Financeiro do funcionário">
                        <img src="{{url('/assets/imagens/cifrao.png')}}" alt="Financeiro do funcionário" /> 
                    </a>
                    <a href="{{url("/painel/funcionarios/atualizar/".$funcionario->id)}}" title="alterar dados do funcionario">
                        <img src="{{url('/assets/imagens/edit.png')}}" alt="alterar dados do $funcionario" /> 
                    </a>
                    <a  href="javascript:func()" title="Remover funcionario"
                       onclick="confirmacao('/painel/funcionarios/apagar/','{{$funcionario->id}}')">
                        <img src="{{url('/assets/imagens/delete.png')}}" alt="Remover funcionario" />
                    </a>

                </td>
            </tr>
            @empty
                <p> Nenhum funcionário cadastrado!!!</p>
            @endforelse
        </tbody>
    </table>
    
</div>
@endsection


