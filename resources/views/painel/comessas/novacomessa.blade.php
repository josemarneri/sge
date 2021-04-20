@extends('layouts.master')

@section('content')

<div class="area-trabalho"> 
    <script language="JavaScript" src="{{url('js/neri.js')}}"></script>
    <script language="JavaScript" src="{{url('js/jquery-1.6.4.js')}}"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        $('#orcamento_id').change(function(){
            $('#div_codigo').load('/painel/comessas/getCodigo/'+$('#orcamento_id').val());
        });
        
    });
    </script>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar comessa</div>
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
                    <form name="form1" class="form-horizontal" role="form" method="POST" 
                          action="{{ url('/painel/comessas/salvar') }}">
                        {{ csrf_field() }}
           
                        
                        <input type="hidden" id="id" name="id" value="{{$comessa->id}}"/>
                        <input type="hidden" id="user_id" name="user_id" value="{{auth()->user()->id}}"/>
                        @if($comessa->orcamento_id)
                            <input type="hidden" id="orcamento_id" name="orcamento_id" value="{{$comessa->orcamento_id}}"/>
                        @endif
                        <input type="hidden" id="ativa" name="ativa" value="{{$comessa->ativa}}"/>
                        
                        @if(empty($comessa->orcamento_id))
                        <div class="form-group{{ $errors->has('orcamento_id') ? ' has-error' : '' }}">
                            <label for="orcamento_id" class="col-md-4 control-label">Orçamento</label>

                            <div class="col-md-6">
                                <select id="orcamento_id" name="orcamento_id" >
                                    <option value="0" >
                                        Selecione um orçamento</option>
                                    @foreach($orcamentos as $orcamento)
                                        <option <?php echo ($orcamento->id == $comessa->orcamento_id) ? "selected" :" "; ?> 
                                            value="{{$orcamento->id}}" > 
                                            {{$orcamento->id.' - '.$orcamento->descricao}} </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        @endif
                        
                        <div class="form-group{{ $errors->has('codigo') ? ' has-error' : '' }}">
                            <label for="codigo" class="col-md-4 control-label">Código</label>

                            <div id="div_codigo" class="col-md-6">
                                <input id="codigo" type="text" class="form-control" readonly name="codigo" 
                                       value="{{ $comessa->codigo ? $comessa->codigo : old('codigo') }}" required>

                                @if ($errors->has('codigo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('codigo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
                            <label for="descricao" class="col-md-4 control-label">Descrição</label>

                            <div class="col-md-6">
                                <input id="descricao" type="text" class="form-control" name="descricao"
                                       value="{{ $comessa->descricao ? $comessa->descricao : old('descricao') }}" 
                                       onmouseover="enableSalvar(document.form1.orcamento_id, document.form1.btnSalvar)" required autofocus>

                                @if ($errors->has('descricao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descricao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>  
                        
                        <div class="form-group{{ $errors->has('n_horas') ? ' has-error' : '' }}">
                            <label for="n_horas" class="col-md-4 control-label">Numero de Horas</label>

                            <div class="col-md-6">
                                <input id="n_horas" type="number" class="form-control" name="n_horas"
                                       value="{{ $comessa->n_horas ? $comessa->n_horas : old('n_horas') }}" 
                                       onmouseover="enableSalvar(document.form1.orcamento_id, document.form1.btnSalvar)" required autofocus>

                                @if ($errors->has('n_horas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('n_horas') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group{{ $errors->has('custo_horario') ? ' has-error' : '' }}">
                            <label for="custo_horario" class="col-md-4 control-label">Custo Horário</label>

                            <div class="col-md-6">
                                <input id="custo_horario" type="text" class="form-control" name="custo_horario"
                                       onkeydown ="return(mascaraMoeda(this,event))"
                                       value="{{ $comessa->custo_horario ? $comessa->custo_horario : old('custo_horario') }}" 
                                       onmouseover="enableSalvar(document.form1.orcamento_id, document.form1.btnSalvar)" autofocus>

                                @if ($errors->has('custo_horario'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('custo_horario') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group{{ $errors->has('obs') ? ' has-error' : '' }}">
                            <label for="obs" class="col-md-4 control-label">Observações</label>

                            <div class="col-md-6">
                                <input id="obs" type="text" class="form-control" name="obs"
                                       value="{{ $comessa->obs ? $comessa->obs : old('obs') }}" 
                                       onmouseover="enableSalvar(document.form1.orcamento_id, document.form1.btnSalvar)" autofocus>

                                @if ($errors->has('obs'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('obs') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        <div class="form-group{{ $errors->has('gatilho') ? ' has-error' : '' }}">
                            <label for="gatilho" class="col-md-4 control-label">Gatilho (horas)</label>

                            <div class="col-md-6">
                                <input id="gatilho" type="text" class="form-control" name="gatilho" 
                                       value="{{ $comessa->gatilho ? $comessa->gatilho : old('gatilho') }}" 
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
                                           <?php echo ($comessa->bloqueio) ? "checked" :""; ?> >
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('data_inicio') ? ' has-error' : '' }}">
                            <label for="data_inicio" class="col-md-4 control-label">Data de início</label>
                            
                            <div class="col-md-6">
                                <input id="data_inicio" name="data_inicio" type="date"                                        
                                        value="{{$comessa->data_inicio ? $comessa->data_inicio : old('data_inicio')}}"
                                       onmouseover="enableSalvar(document.form1.orcamento_id, document.form1.btnSalvar)" required>
                                
                                

                                @if ($errors->has('data_inicio'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('data_inicio') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        
                        <div class="form-group{{ $errors->has('data_fim') ? ' has-error' : '' }}">
                            <label for="data_fim" class="col-md-4 control-label">Data de Término</label>

                            <div class="col-md-6">
                                <input id="data_fim" name="data_fim"  type="date"                                       
                                       value="{{$comessa->data_fim ? $comessa->data_fim : old('data_fim')}}"
                                       onmouseover="enableSalvar(document.form1.orcamento_id, document.form1.btnSalvar)" required>

                                @if ($errors->has('data_resposta'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('data_fim') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('gerente_id') ? ' has-error' : '' }}">
                            <label for="gerente_id" class="col-md-4 control-label">Gerente</label>

                            <div class="col-md-6">
                                <select id="gerente_id" name="gerente_id" >
                                    @foreach($gerentes as $gerente)
                                        @if(!empty($gerente))
                                        <option <?php echo ($gerente->id == $comessa->gerente_id) ? "selected" :""; ?> 
                                            value="{{$gerente->id}}" onchange="enableSalvar(document.form1.orcamento_id, document.form1.btnSalvar)"> 
                                            {{$gerente->nome}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('coordenador_id') ? ' has-error' : '' }}">
                            <label for="coordenador_id" class="col-md-4 control-label">coordenador</label>

                            <div class="col-md-6">
                                <select id="coordenador_id" name="coordenador_id" >
                                    @foreach($coordenadores as $coordenador)
                                        @if(!empty($coordenador))
                                        <option <?php echo ($comessa->coordenador_id == $coordenador->id) ? "selected" :""; ?> 
                                            value="{{$coordenador->id}}" onchange="enableSalvar(document.form1.orcamento_id, document.form1.btnSalvar)">
                                            {{$coordenador->nome}}</option>
                                        
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button onmouseover="statusSalvar()" name="btnSalvar" type="submit" 
                                        class="btn btn-primary" disabled="true" >
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
