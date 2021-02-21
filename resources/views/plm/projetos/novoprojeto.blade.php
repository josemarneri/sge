@extends('layouts.master')

@section('content')
<div class="area-trabalho">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar Projeto</div>
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
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/plm/projetos/salvar') }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="id" name="id" value="{{$projeto->id}}"/>

                               
                        <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                            <label for="nome" class="col-md-4 control-label">Código</label>

                            <div class="col-md-6">
                                <input id="codigo" type="text"  class="form-control" name="codigo" value="{{ $projeto->codigo ? $projeto->codigo : old('codigo') }}" required>

                                @if ($errors->has('nome'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nome') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
            
                        <div class="form-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
                            <label for="descricao" class="col-md-4 control-label">Descrição</label>

                            <div class="col-md-6">
                                <input id="descricao" type="text" class="form-control" name="descricao" value="{{ $projeto->descricao ?  $projeto->descricao : old('descricao') }}" >

                                @if ($errors->has('descricao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descricao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('observacoes') ? ' has-error' : '' }}">
                            <label for="observacoes" class="col-md-4 control-label">Observações</label>

                            <div class="col-md-6">
                                <input id="peso" type="text" class="form-control" name="observacoes" value="{{ $projeto->observacoes ? $projeto->observacoes : old('observacoes') }}" >

                                @if ($errors->has('observacoes'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('observacoes') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('comessa_id') ? ' has-error' : '' }}">
                            <label for="comessa_id" class="col-md-4 control-label">Comessa</label>

                            <div class="col-md-6">
                                <select id="comessa_id" name="comessa_id" >
                                    @foreach($comessas as $comessa)
                                        @if(!empty($comessa))
                                        <option <?php echo ($projeto->comessa_id == $comessa->id) ? "selected" :""; ?> 
                                            value="{{$comessa->id}}" onchange="enableSalvar(document.form1.comessa_id, document.form1.btnSalvar)">
                                            {{$comessa->codigo}}</option>
                                        
                                        @endif
                                    @endforeach
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
