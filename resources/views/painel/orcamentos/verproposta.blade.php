@extends('layouts.master')

@section('content')
<div class="area-util">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar proposta de orçamento</div>
                @if(count($errors->all()) > 0)
                <div class="alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}} </li>                   
                        @endforeach  
                    </ul>
                </div>                    
                    
                @endif
                @if(Session::has('mensagem_sucesso'))
                    <div class="alert alert-success">{{Session::get('mensagem_sucesso')}}</div>    
                @endif
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="GET" action="{{ url('/painel/orcamentos') }}">
                        {{ csrf_field() }}
           
                        
                        <input type="hidden" id="id" name="id" value="{{$proposta->id}}"/>
                        <input type="hidden" id="orcamento_id" name="orcamento_id" value="{{$proposta->orcamento_id}}"/>

                        <div class="form-group{{ $errors->has('tarifa') ? ' has-error' : '' }}">
                            <label for="tarifa" class="col-md-4 control-label">Tarifa: </label>
                            <input type="text" id="tarifa" name="tarifa" readonly value="{{$proposta->tarifa}}"/>
                        </div> 
                        
                        <div class="form-group{{ $errors->has('n_horas') ? ' has-error' : '' }}">
                            <label for="n_horas" class="col-md-4 control-label">Numero de Horas: </label>
                            <input name="n_horas" readonly value="{{ $proposta->n_horas}}"/>
                        </div> 
                        
                        <div class="form-group{{ $errors->has('data_envio') ? ' has-error' : '' }}">
                            <label id="data_envio" for="data_envio" class="col-md-4 control-label">Data de envio: </label>
                            <input name="data_envio" readonly value="{{$proposta->data_envio}}"/> 
                        </div> 
                        
                        <div class="form-group{{ $errors->has('data_resposta') ? ' has-error' : '' }}">
                            <label for="data_resposta" class="col-md-4 control-label">Data de Resposta: </label>
                            <input name="data_resposta" readonly value="{{$proposta->data_resposta}}"/> 
                        </div>
                        
                        <div class="form-group{{ $errors->has('obs') ? ' has-error' : '' }}">
                            <label for="obs" class="col-md-4 control-label">Observações: </label>
                            <input name="obs" readonly value="{{$proposta->obs}}"/>
                        </div>
                        
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label for="status" class="col-md-4 control-label">Status: </label>
                            <input name="status" readonly value="{{$proposta->status}}"/>
                        </div>            

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Voltar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
