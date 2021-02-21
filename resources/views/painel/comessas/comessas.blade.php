@extends('layouts.master')

@section('content')
<script language="JavaScript" src="{{url('js/neri.js')}}"></script>
<div class="area-trabalho">
    <div class="title-2">
        Lista de comessas        
    </div>
    <table class="table table-hover table-condensed " style="text-align: center">
        
        <thead> 
        <a href="{{url("/painel/comessas/novo")}}" title="Adicionar comessa">
            <img src="{{url('/assets/imagens/Add.png')}}" alt="Adicionar comessa" />
        </a>
        
            <tr>
                <th style="text-align: center">Id</th>
                <th style="text-align: center">Código</th>
                <th style="text-align: center">Descricao</th>
                <th style="text-align: center">Início</th>
                <th style="text-align: center">Término</th>
                <th style="text-align: center">Gerente</th>
                <th style="text-align: center">Coordenador</th>
                <th width="130" style="text-align: center">Ações </th>
            </tr>
        </thead>
        <tbody>
            @forelse($comessas as $comessa)
            <tr>                
                <td >{{$comessa->id}}</td>
                <td >{{$comessa->codigo}}</td>
                <td >{{$comessa->descricao}}</td>
                <td >{{$comessa->getDataYmdToDmY($comessa->data_inicio)}}</td>
                <td >{{$comessa->getDataYmdToDmY($comessa->data_fim)}}</td>
                <td >{{$comessa->getNomeFuncionario($comessa->gerente_id)}}</td>
                <td >{{$comessa->getNomeFuncionario($comessa->coordenador_id)}}</td>
                
                <td >
                    <a href="{{url("/painel/comessas/ativardesativar/".$comessa->id)}}" title="Ativar/Desativar">
                        <img src="{{url("/assets/imagens/ativo".$comessa->ativa.".png")}}" /> 
                    </a>
                    <a href="{{url("/painel/comessas/equipe/".$comessa->id)}}" title="Adicionar equipe">
                        <img src="{{url('/assets/imagens/users.png')}}" alt="Adicionar proposta" />
                    </a>
                    <a href="{{url("/painel/comessas/atualizar/".$comessa->id)}}" title="alterar dados do comessa">
                        <img src="{{url('/assets/imagens/edit.png')}}" alt="alterar dados do $comessa" /> 
                    </a>
                    <a href="javascript:func()" title="Remover comessa"
                       onclick="confirmacao('/painel/comessas/apagar/','{{$comessa->id}}')">
                        <img src="{{url('/assets/imagens/delete.png')}}" alt="Remover comessa" />
                    </a>
                </td>
            </tr>
            @empty
                <p> Nenhuma Comessa cadastrada!!!</p>
            @endforelse
        </tbody>
    </table>
    
</div>
@endsection


