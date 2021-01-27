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
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/painel/orcamentos/salvarproposta') }}">
                        {{ csrf_field() }}
           
                        
                        <input type="hidden" id="id" name="id" value="{{$proposta->id}}"/>
                        <input type="hidden" id="orcamento_id" name="orcamento_id" value="{{$proposta->orcamento_id}}"/>

                        <div class="form-group{{ $errors->has('tarifa') ? ' has-error' : '' }}">
                            <label for="tarifa" class="col-md-4 control-label">Tarifa</label>

                            <div class="col-md-6">
                                <input id="tarifa" type="text" class="form-control" name="tarifa" value="{{ $proposta->tarifa ? $proposta->tarifa : old('tarifa') }}" required autofocus>

                                @if ($errors->has('tarifa'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tarifa') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        
                        <div class="form-group{{ $errors->has('n_horas') ? ' has-error' : '' }}">
                            <label for="n_horas" class="col-md-4 control-label">Numero de Horas</label>

                            <div class="col-md-6">
                                <input id="n_horas" type="text" class="form-control" name="n_horas" value="{{ $proposta->n_horas ? $proposta->n_horas : old('n_horas') }}" required autofocus>

                                @if ($errors->has('n_horas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('n_horas') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        
                        <div class="form-group{{ $errors->has('data_envio') ? ' has-error' : '' }}">
                            <label for="data_envio" class="col-md-4 control-label">Data de envio</label>

                            <div class="col-md-6">
                                <input id="data_envio" name="data_envio" type="text" value="{{$proposta->data_envio ? $proposta->data_envio : old('data_envio')}}">

                                @if ($errors->has('data_envio'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('data_envio') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        
                        <div class="form-group{{ $errors->has('data_resposta') ? ' has-error' : '' }}">
                            <label for="data_resposta" class="col-md-4 control-label">Data de Resposta</label>

                            <div class="col-md-6">
                                <input id="data_resposta" name="data_resposta" size="16" type="text" value="{{$proposta->data_resposta ? $proposta->data_resposta : old('data_resposta')}}">

                                @if ($errors->has('data_resposta'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('data_resposta') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('obs') ? ' has-error' : '' }}">
                            <label for="obs" class="col-md-4 control-label">Observações</label>

                            <div class="col-md-6">
                                <input id="obs" type="text" class="form-control" name="obs" value="{{ $proposta->obs ? $proposta->obs : old('obs')}}" >

                                @if ($errors->has('obs'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('obs') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label for="status" class="col-md-4 control-label">Status</label>
                            <div class="col-md-6">

                                <select id="status" name="status" >
                                         <option value="Enviado">Enviado</option>
                                         <option value="Aprovado">Aprovado</option>
                                         <option value="Reprovado">Reprovado</option>
                                </select>
                            </div>
                        </div>            

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Salvar
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
