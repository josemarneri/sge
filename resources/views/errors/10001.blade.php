@extends('layouts.master')

@section('content')

<div class="area-util"> 

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Ops, Algo deu errado!</b>
                    <br>{{$mensagemErro}} </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
