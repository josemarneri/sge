@extends('layouts.master')

@section('content')

<div class="area-util">
        
    @if(Session::has('mensagem_sucesso'))
        <div class="alert alert-success">{{Session::get('mensagem_sucesso')}}</div>    
    @endif
     <div >
        <form action="util/importarfuncionariosdoexcel" method="post" enctype="multipart/form-data">
            <p> Selecionar arquivo para importar os dados dos funcionários!!!</p>
            <input type="file" name="filefield" ><br/>
            <button type="submit" class="btn btn-primary">
                Carregar Arquivo
            </button>
            {{ csrf_field() }}
        </form>
    </div>
    <br/>

    <div >
        <form action="/rdp/exceltodb" method="post" enctype="multipart/form-data">
            <p> Selecionar arquivo para registro de ponto!!!</p>
            <input type="file" name="filefield" ><br/>
            <button type="submit" class="btn btn-primary">
                Carregar Arquivo
            </button>
            {{ csrf_field() }}
        </form>
    </div>
    <br/>
    
    
    <div >
        <form action="util/importarusuariosdoexcel" method="post" enctype="multipart/form-data">
            <p> Selecionar arquivo para criar usuários!!!</p>
            <input type="file" name="filefield" ><br/>
            <button type="submit" class="btn btn-primary">
                Carregar Arquivo
            </button>
            {{ csrf_field() }}
        </form>
    </div>
    
    
</div>
@endsection


