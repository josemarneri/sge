@extends('layouts.master')

@section('content')

<div class="area-util">
        
    @if(Session::has('mensagem_sucesso'))
        <div class="alert alert-success">{{Session::get('mensagem_sucesso')}}</div>    
    @endif
     <div >
        <form action="/plm/desenhos/novo/lerplanilha" method="post" enctype="multipart/form-data">
            <p> Selecionar arquivo para importar os desenhos!!!</p>
            <input type="file" name="filefield" ><br/>
            <button type="submit" class="btn btn-primary">
                Carregar Arquivo
            </button>
            {{ csrf_field() }}
        </form>
    </div>
    <br/>

    
    
</div>
@endsection


