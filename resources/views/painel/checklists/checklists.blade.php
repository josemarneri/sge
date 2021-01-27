@extends('layouts.master')

@section('content')
<script language="JavaScript" src="{{url('js/neri.js')}}"></script>
<div class="area-util">
    <div class="title-2">
        Lista de checklists        
    </div>
    <table class="table table-hover table-condensed " style="text-align: center">
        
        <thead> 
        <a href="{{url("/painel/checklists/novo")}}" title="Adicionar checklist">
            <img src="{{url('/assets/imagens/Add.png')}}" alt="Adicionar checklist" />
        </a>
        
            <tr>
                <th style="text-align: center">Id</th>
                <th style="text-align: center">Nome</th>
                <th style="text-align: center">Descricao</th>
                <th style="text-align: center">Qtde Perguntas</th>
                <th width="130" style="text-align: center">Ações </th>
            </tr>
        </thead>
        <tbody>
            @forelse($checklists as $checklist)
            <tr>                
                <td >{{$checklist->id}}</td>
                <td >{{$checklist->nome}}</td>
                <td >{{$checklist->descricao}}</td>
                <td >{{$checklist->getQtdePerguntas()}}</td>
                
                <td >
                    <a href="{{url("/painel/checklists/atualizar/".$checklist->id)}}" title="Alterar checklist">
                        <img src="{{url('/assets/imagens/Edit.png')}}" alt="Alterar checklist" /> 
                    </a>
                    <a href="javascript:func()" title="Remover checklist"
                       onclick="confirmacao('/painel/checklists/apagar/','{{$checklist->id}}')">
                        <img src="{{url('/assets/imagens/Delete.png')}}" alt="Remover checklist" />
                    </a>
                </td>
            </tr>
            @empty
                <p> Nenhum CheckList cadastrado!!!</p>
            @endforelse
        </tbody>
    </table>
    
</div>
@endsection


