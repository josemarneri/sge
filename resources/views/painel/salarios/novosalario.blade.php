@extends('layouts.master')

@section('content')

<div class="area-trabalho">
    <script language="JavaScript" src="{{url('js/neri.js')}}"></script>
    
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar Salario</div>
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
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/painel/salarios/salvar') }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="id" name="id" value="{{$salario->id}}"/>
                        
                        <div class="form-group{{ $errors->has('cargo_id') ? ' has-error' : '' }}">
                            <label for="cargo_id" class="col-md-4 control-label">Cargo</label>
                            <div class="col-md-6">
                                <select id="cargo_id" name="cargo_id" required >
                                         <option value="">Selecione um cargo</option>
                                    @foreach($cargos as $cargo)
                                        <option <?php echo ($cargo->id == $salario->getCargo()) ? "selected" :""; ?> 
                                            value="{{$cargo->id}}">{{$cargo->nome}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                               
                        <div class="form-group{{ $errors->has('valor_mensal') ? ' has-error' : '' }}">
                            <label for="valor_mensal" class="col-md-4 control-label">Valor Mensal</label>

                            <div class="col-md-6">
                                <input id="valor_mensal" type="text" class="form-control" name="valor_mensal" 
                                       onkeydown ="return(mascaraMoeda(this,event))"
                                       value="{{ $salario->valor_mensal ? $salario->valor_mensal : old('valor_mensal') }}" >

                                @if ($errors->has('valor_mensal'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('valor_mensal') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('valor_hora') ? ' has-error' : '' }}">
                            <label for="valor_hora" class="col-md-4 control-label">Valor / Hora</label>

                            <div class="col-md-6">
                                <input id="valor_hora" type="text" class="form-control" name="valor_hora" 
                                       onkeydown ="return(mascaraMoeda(this,event))"
                                       value="{{ $salario->valor_hora ? $salario->valor_hora : old('valor_hora') }}" >

                                @if ($errors->has('valor_hora'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('valor_hora') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('ativo') ? ' has-error' : '' }}">
                            <label for="ativo" class="col-md-4 control-label">Ativo</label>

                            <div class="col-md-6">
                                <input type="checkbox" name="ativo" value="1"
                                           <?php echo ($salario->ativo) ? "checked" :""; ?> >
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
