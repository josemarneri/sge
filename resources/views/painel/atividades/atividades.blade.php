@extends('layouts.master')

@section('content')
<script language="JavaScript" src="{{url('js/neri.js')}}"></script>
<div class="area-util">
    <div class="title-2">
        Lista de atividades        
    </div>
    <table class="table table-hover table-condensed " style="text-align: center">
        
        <thead> 
        <a href="{{url("/painel/atividades/novo")}}" title="Adicionar atividade">
            <img src="{{url('/assets/imagens/Add.png')}}" alt="Adicionar atividade" />
        </a>
        
            <tr>
                <th style="text-align: center">Código</th>
                <th style="text-align: center">Título</th>
                <th style="text-align: center">Executor</th>
                <th style="text-align: center">Previsão</th>
                <th style="text-align: center">Status</th>
                <th width="130" style="text-align: center">Ações </th>
            </tr>
        </thead>
        <tbody>
            @forelse($atividades as $atividade)
            <tr>                
                <td >{{$atividade->codigo}}</td>
                <td >{{$atividade->titulo}}</td>
                <td >{{$atividade->getFuncionario()->nome}}</td>
                <td >{{$atividade->formatDateToDMY($atividade->prev_fim)}}</td>
                <td >{{$atividade->status}}</td>
                
                <td >
                    <a href="{{url("/painel/atividades/addnota/".$atividade->id)}}" title="Adicionar Nota">
                        <img src="{{url('/assets/imagens/editperfil.png')}}" alt="Adicionar Nota" />
                    </a>
                    <a href="{{url("/painel/atividades/atualizar/".$atividade->id)}}" title="alterar dados do atividade">
                        <img src="{{url('/assets/imagens/edit.png')}}" alt="alterar dados do $atividade" /> 
                    </a>
                    <a href="javascript:func()" title="Remover atividade"
                       onclick="confirmacao('/painel/atividades/apagar/','{{$atividade->id}}')">
                        <img src="{{url('/assets/imagens/delete.png')}}" alt="Remover atividade" />
                    </a>
                </td>
            </tr>
            @empty
                <p> Nenhuma Atividade cadastrada!!!</p>
            @endforelse
        </tbody>
    </table>
    
</div>
@endsection


