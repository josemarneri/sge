@extends('painel.diariosdebordo.diariosdebordo')

@section('lista')
<script language="JavaScript" src="{{url('js/neri.js')}}"></script>
<div class="area-trabalho">
    <div class="title-2">
        Lista de lançamentos       
    </div>
    <table class="table table-hover table-condensed " style="text-align: center">
        
        <thead> 
        <a href="{{url("/painel/diariosdebordo/novo")}}" title="Adicionar diariodebordo">
            <img src="{{url('/assets/imagens/Add.png')}}" alt="Adicionar diariodebordo" />
        </a>

            <div style="float: right">
                {{ $diariosdebordo->links() }}
            </div>
            

            <tr>
                <th style="text-align: center">Data</th>
                <th style="text-align: center">Comessa</th>
                <th style="text-align: center">Atividade</th>
                <th style="text-align: center">N.Horas</th>
                <th width="100" style="text-align: center">Descrição</th>
                <th width="130" style="text-align: center">Ações </th>
            </tr>
        </thead>
        <tbody>
            @forelse($diariosdebordo as $ddb)
            <tr>                
                <td >{{$ddb->formatDateToDMY($ddb->data)}}</td>
                <td >{{$ddb->getComessa($ddb->comessa_id)->codigo}}</td>
                <td >{{$ddb->getAtividadeCodigo()}}</td>
                <td >{{$ddb->n_horas}}</td>
                <td style="text-align: left" >{{$ddb->descricao}}</td>
                
                <td >
                    <a href="{{url("/painel/diariosdebordo/atualizar/".$ddb->id)}}" title="alterar dados do lançamento">
                        <img src="{{url('/assets/imagens/edit.png')}}" alt="alterar dados do lançamento" /> 
                    </a>
                    <a href="javascript:func()" title="Remover diariodebordo"
                       onclick="confirmacao('/painel/diariosdebordo/apagar/','{{$ddb->id}}')">
                        <img src="{{url('/assets/imagens/delete.png')}}" alt="Remover lançamento" />
                    </a>
                </td>
            </tr>
            @empty
                <p> Nenhum Lançamento cadastrado!!!</p>
            @endforelse
        </tbody>
    </table>
    
</div>
@endsection


