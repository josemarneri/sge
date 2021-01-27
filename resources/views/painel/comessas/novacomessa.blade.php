@extends('layouts.master')

@section('content')

<div class="area-util"> 
    <script language="JavaScript" src="{{url('js/neri.js')}}"></script>

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
                        @if($comessa->orcamento_id)
                            <input type="hidden" id="orcamento_id" name="orcamento_id" value="{{$comessa->orcamento_id}}"/>
                        @endif
                        <input type="hidden" id="ativa" name="ativa" value="{{$comessa->ativa}}"/>
                        
                        @if(empty($comessa->orcamento_id))
                        <div class="form-group{{ $errors->has('Orcamento') ? ' has-error' : '' }}">
                            <label for="Orcamento" class="col-md-4 control-label">Orçamento</label>

                            <div class="col-md-6">
                                <select id="orcamento_id" name="orcamento_id" >
                                    <option value="0" onclick="getCodigo(this,'',document.form1.btnSalvar)">
                                        Selecione um orçamento</option>
                                    @foreach($orcamentos as $orcamento)
                                        <option <?php echo ($orcamento->id == $comessa->orcamento_id) ? "selected" :" "; ?> 
                                            value="{{$orcamento->id}}" 
                                            onclick="getCodigo(this,'{{$comessa->getCodigo($orcamento->id)}}',document.form1.btnSalvar)"> 
                                            {{$orcamento->id.' - '.$orcamento->descricao}} </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        @endif
                        
                        <div class="form-group{{ $errors->has('codigo') ? ' has-error' : '' }}">
                            <label for="codigo" class="col-md-4 control-label">Código</label>

                            <div class="col-md-6">
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
                                <input id="n_horas" type="text" class="form-control" name="n_horas"
                                       value="{{ $comessa->n_horas ? $comessa->n_horas : old('n_horas') }}" 
                                       onmouseover="enableSalvar(document.form1.orcamento_id, document.form1.btnSalvar)" required autofocus>

                                @if ($errors->has('n_horas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('n_horas') }}</strong>
                                    </span>
                                @endif
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
