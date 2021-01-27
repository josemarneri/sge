@extends('layouts.master')

@section('content')

<div class="area-util">
<script language="JavaScript" src="{{url('js/neri.js')}}"></script>
    @if(Session::has('mensagem_sucesso'))
        <div class="alert alert-success">{{Session::get('mensagem_sucesso')}}</div>    
    @endif
    @if(Session::has('mensagem_error'))
        <div class="alert alert-danger">{{Session::get('mensagem_error')}}</div>    
    @endif
    <div >
        <form action="{{url("arquivos/anexar/")}}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="file" name="filefield[]" multiple><br/>
            <input type="hidden" name="anexode" value="{{$anexode}}"/>
            <input type="hidden" name="from_id" value="{{$from_id}}"/>
            <button type="submit" class="btn btn-primary">
                Carregar Arquivo
            </button>

        </form>
    </div>
    <div class="title-2">
        Lista de anexos salvos no servidor        
    </div>
    
    <table class="table table-hover table-condensed " style="text-align: center">
        
        <thead> 
            
        
             <tr>
                <th style="text-align: center">Id</th>
<!--                <th style="text-align: center">Nome</th>   --> 
                <th style="text-align: center">Arquivo</th>
                <th style="text-align: center">Anexo de</th>
<!--                <th style="text-align: center">Tipo</th>    -->
                <th width="100" style="text-align: center">Ações </th>
            </tr>
        </thead>
        <tbody>
            @forelse($arquivos as $arquivo)
            <tr>                
                <td >{{$arquivo->id}}</td>
<!--                <td >{{$arquivo->nome}}</td>      -->  
                <td >{{$arquivo->nomearquivo}}</td> 
                <td >{{$arquivo->anexode}}</td> 
<!--                <td >{{$arquivo->mime}}</td>          -->  
                
                <td >
                    
                    
                    <a href="javascript:func()" title="Remover Arquivo" 
                       onclick="confirmacao('/arquivos/apagar/','{{$arquivo->id}}')">
                        <img src="{{url('/assets/imagens/delete.png')}}" alt="Remover Arquivo" />
                    </a>
                    <a href="{{url("/arquivos/baixar/$arquivo->id")}}" title="Baixar Arquivo">
                        <img src="{{url('/assets/imagens/ArrowDown.png')}}" alt="Baixar Arquivo" />
                    </a>
                </td>
            </tr>
            @empty
                <p> Nenhum Arquivo Encontrado!!!</p>
            @endforelse
        </tbody>
    </table>

    
    
</div>
@endsection


