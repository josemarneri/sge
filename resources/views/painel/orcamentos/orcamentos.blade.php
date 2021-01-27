@extends('layouts.master')

@section('content')
<div class="area-util">
    <div class="title-2">
        Lista de orçamentos        
    </div>
    <table class="table table-hover table-condensed " style="text-align: center">
        
        <thead> 
        <a href="{{url("/painel/orcamentos/novo")}}" title="Adicionar orcamento">
            <img src="{{url('/assets/imagens/Add.png')}}" alt="Adicionar orcamento" />
        </a>
        
            <tr>
                <th style="text-align: center">Id</th>
                <th style="text-align: center">Cliente</th>
                <th style="text-align: center">Descricao</th>
                <th style="text-align: center">Propostas</th>
                <th style="text-align: center">Situação</th>
                <th style="text-align: center">Pedido</th>
                <th width="100" style="text-align: center">Anexos </th>
                <th width="100" style="text-align: center">Ações </th>
            </tr>
        </thead>
        <tbody>
            @forelse($orcamentos as $orcamento)
            <tr>                
                <td >{{$orcamento->id}}</td>
                <td >{{$orcamento->getcliente($orcamento->id)->sigla}}</td>
                <td >{{$orcamento->descricao}}</td>
                <td >
                    <?php
                    $i=1;
                    echo "[ ";
                    foreach($orcamento->getPropostas($orcamento->id) as $proposta){
                        echo "<a href=\"".url("/painel/orcamentos/verproposta/".$proposta->id)."\" title=\"Abrir proposta\">";
                           echo "$i </a>";
                           $i++;
                    }
                    echo " ]";
                    ?>
                    <a href="{{url("/painel/orcamentos/novaproposta/".$orcamento->id)}}" title="Adicionar proposta">
                        <img src="{{url('/assets/imagens/Add.png')}}" alt="Adicionar proposta" />
                    </a>

                </td>
                <td >{{$orcamento->status}}</td>
                <td >{{$orcamento->pedido}}</td>
                <td >
                    <?php
                        $i=1;
                        echo "[ ";
                        foreach($orcamento->getAnexos($orcamento->id) as $anexo){
                            echo "<a href=\"".url("/arquivos/baixar/".$anexo->id)."\" title=\"Abrir Anexo\">";
                               echo "$i </a>";
                               $i++;
                        }
                        echo " ]";
                    ?>
                    <a href="{{url("arquivos/anexar/orcamentos/".$orcamento->id)}}" title="Adicionar anexo">
                        <img src="{{url('/assets/imagens/Add.png')}}" alt="Adicionar anexo" />
                    </a>
                </td>
                <td >
                    <a href="{{url("/painel/orcamentos/atualizar/".$orcamento->id)}}" title="alterar dados do orcamento">
                        <img src="{{url('/assets/imagens/Edit.png')}}" alt="alterar dados do $orcamento" /> 
                    </a>
                    <a href="{{url("/painel/orcamentos/apagar/$orcamento->id")}}" title="Remover orcamento">
                        <img src="{{url('/assets/imagens/Delete.png')}}" alt="Remover orcamento" />
                    </a>
                </td>
            </tr>
            @empty
                <p> Nenhum Orcamento cadastrado!!!</p>
            @endforelse
        </tbody>
    </table>
    
</div>
@endsection


