@extends('layouts.master')

@section('content')
<script language="JavaScript" src="{{url('js/neri.js')}}"></script>
<div class="area-trabalho">
    <div class="title-2">
        Carga de trabalho por funcionário       
    </div>
    <table class="table table-hover table-condensed " style="text-align: center">
        <thead> 
        <a href="{{url("/painel/cargas/novo")}}" title="Adicionar carga de trabalho para um funcionário">
            <img src="{{url('/assets/imagens/Add.png')}}" alt="Adicionar comessa" />
        </a>
        
            <tr>
                <th style="text-align: center">Funcionario</th>
                <th style="text-align: center">Comessa</th>
                <th style="text-align: center">Início</th>
                <th style="text-align: center">Término</th>
                <th style="text-align: center">Obs:</th>
                <th width="130" style="text-align: center">Ações </th>
            </tr>
        </thead>
        <tbody>
            @forelse($cargas as $carga)
            <tr>                
                <td >{{$carga->getNomeFuncionario($carga->funcionario_id)}}</td>
                <td title="{{$carga->getInforComessa()}}">{{$carga->getCodigoComessa($carga->comessa_id)}}</td>
                <td >{{$carga->getDataYmdToDmY($carga->data_inicio)}}</td>
                <td >{{$carga->getDataYmdToDmY($carga->data_fim)}}</td>
                <td >{{$carga->obs}}</td>
                
                <td >
                    <a href="{{url("/painel/cargas/livre/".$carga->id)}}" title="Liberar/Bloquear">
                        <img src="{{url("/assets/imagens/ativo".$carga->livre.".png")}}" /> 
                    </a>
                    <a href="{{url("/painel/cargas/atualizar/".$carga->id)}}" title="alterar dados do Funcionário">
                        <img src="{{url('/assets/imagens/edit.png')}}" alt="alterar dados do Funcionários" /> 
                    </a>
                    <a href="{{url("/painel/cargas/apagar/$carga->id")}}" title="Remover Carga de Trabalho para este Funcionário">
                        <img src="{{url('/assets/imagens/delete.png')}}" alt="Remover Carga" />
                    </a>
                </td>
            </tr>
            @empty
                <p> Nenhuma Carga de trabalho cadastrada!!!</p>
            @endforelse
        </tbody>
    </table>
    
</div>
@endsection


