@extends('layouts.master')

@section('content')
<div class="area-trabalho-interna">
    <script language="JavaScript" src="{{url('js/neri.js')}}"></script>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar orçamento</div>
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
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/painel/orcamentos/salvar') }}">
                        {{ csrf_field() }}
           
                        
                        <input type="hidden" id="id" name="id" value="{{$orcamento->id}}"/>
                        <input type="hidden" id="user_id" name="user_id" value="{{auth()->user()->id}}"/>

                        <div class="form-group{{ $errors->has('cliente_id') ? ' has-error' : '' }}">
                            <label for="cliente_id" class="col-md-4 control-label">Cliente*</label>

                            <div class="col-md-6">
                                <select id="cliente_id" name="cliente_id" >
                                    @foreach($clientes as $cliente)
                                        <option <?php echo ($cliente->id == $orcamento->cliente_id) ? "selected" :""; ?> 
                                            value="{{$cliente->id}}">  {{ $cliente->nome . '  -- ( '. $cliente->sigla. ' )'}} </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
                            <label for="descricao" class="col-md-4 control-label">Descrição*</label>

                            <div class="col-md-6">
                                <input id="descricao" type="text" class="form-control" name="descricao" 
                                       value="{{ $orcamento->descricao ? $orcamento->descricao : old('descricao') }}" 
                                       required autofocus>

                                @if ($errors->has('descricao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descricao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group{{ $errors->has('n_horas') ? ' has-error' : '' }}">
                            <label for="n_horas" class="col-md-4 control-label">Nº de horas*</label>

                            <div class="col-md-6">
                                <input id="n_horas" type="number" class="form-control" name="n_horas" 
                                       value="{{ $orcamento->n_horas ? $orcamento->n_horas : old('n_horas') }}" 
                                       required autofocus>

                                @if ($errors->has('n_horas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('n_horas') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        
                        <div class="form-group{{ $errors->has('tarifa') ? ' has-error' : '' }}">
                            <label for="tarifa" class="col-md-4 control-label">Tarifa*</label>

                            <div class="col-md-6">
                                <input id="tarifa" type="text" class="form-control" name="tarifa" 
                                       onkeydown ="return(mascaraMoeda(this, event))"
                                       value="{{ $orcamento->tarifa ? $orcamento->tarifa : old('tarifa') }}" 
                                       required autofocus>

                                @if ($errors->has('tarifa'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tarifa') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group{{ $errors->has('custo_inicial') ? ' has-error' : '' }}">
                            <label for="custo_inicial" class="col-md-4 control-label">Custo Inicial</label>

                            <div class="col-md-6">
                                <input id="custo_inicial" type="text" class="form-control" name="custo_inicial" 
                                       onkeydown ="return(mascaraMoeda(this, event))"
                                       value="{{ $orcamento->custo_inicial ? $orcamento->custo_inicial : old('custo_inicial') }}" 
                                       autofocus>

                                @if ($errors->has('custo_inicial'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('custo_inicial') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group{{ $errors->has('custo_mensal') ? ' has-error' : '' }}">
                            <label for="custo_mensal" class="col-md-4 control-label">Custo Mensal</label>

                            <div class="col-md-6">
                                <input id="custo_mensal" type="text" class="form-control" name="custo_mensal" 
                                       onkeydown ="return(mascaraMoeda(this, event))"
                                       value="{{ $orcamento->custo_mensal ? $orcamento->custo_mensal : old('custo_mensal') }}" 
                                       autofocus>

                                @if ($errors->has('custo_mensal'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('custo_mensal') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group{{ $errors->has('impostos') ? ' has-error' : '' }}">
                            <label for="impostos" class="col-md-4 control-label">Impostos (%)</label>

                            <div class="col-md-6">
                                <input id="impostos" type="text" class="form-control" name="impostos" 
                                       onkeydown ="return(mascaraPercentual(this, event))"
                                       value="{{ $orcamento->impostos ? $orcamento->impostos : old('impostos') }}" 
                                       autofocus>

                                @if ($errors->has('impostos'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('impostos') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group{{ $errors->has('pedido') ? ' has-error' : '' }}">
                            <label for="pedido" class="col-md-4 control-label">Pedido</label>

                            <div class="col-md-6">
                                <input id="pedido" type="text" class="form-control" name="pedido" 
                                       value="{{ $orcamento->pedido ? $orcamento->pedido : old('pedido') }}">

                                @if ($errors->has('pedido'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pedido') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group{{ $errors->has('obs') ? ' has-error' : '' }}">
                            <label for="obs" class="col-md-4 control-label">Observações</label>

                            <div class="col-md-6">
                                <input id="obs" type="text" class="form-control" name="obs" 
                                       value="{{ $orcamento->obs ? $orcamento->obs : old('obs') }}" autofocus>

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
                                         <option value="Aguardando" 
                                                 {{($orcamento->status == 'Aguardando') ? 'selected' : ''}} >Aguardando</option>
                                         <option value="Aprovado" 
                                                 {{($orcamento->status == 'Aprovado') ? 'selected' : ''}} >Aprovado</option>
                                         <option value="Reprovado" 
                                                 {{ ($orcamento->status == 'Reprovado') ? 'selected' : '' }}>Reprovado</option>
                                </select>
                            </div>
                        </div> 
                        <div class="form-group{{ $errors->has('gatilho') ? ' has-error' : '' }}">
                            <label for="gatilho" class="col-md-4 control-label">Gatilho (horas)</label>

                            <div class="col-md-6">
                                <input id="gatilho" type="number" class="form-control" name="gatilho" 
                                       value="{{ $orcamento->gatilho ? $orcamento->gatilho : old('gatilho') }}" 
                                       required autofocus>

                                @if ($errors->has('gatilho'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gatilho') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group{{ $errors->has('bloqueio') ? ' has-error' : '' }}">
                            <label for="bloqueio" class="col-md-4 control-label">Bloqueio após Gatilho? </label>
                            <div class="col-md-6">
                                <input type="checkbox" name="bloqueio" value="1"
                                           <?php echo ($orcamento->bloqueio) ? "checked" :""; ?> >
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
