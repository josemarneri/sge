@extends('layouts.master')

@section('content')
<div class="area-trabalho">
    <script language="JavaScript" src="{{url('js/neri.js')}}"></script>
    <script language="JavaScript" src="{{url('js/jquery-1.6.4.js')}}"></script>
    
    <script type="text/javascript">
    $(document).ready(function(){
        $('#funcionario_id').change(function(){
            $('#div_valores').load('/financeiro/pagamentos/preencherdadossalario/'+$('#funcionario_id').val()+'/'+$('#data_inicio').val()+'/'+$('#data_fim').val());
        });
        
    });
    </script>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar Pagamento</div>
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
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/financeiro/pagamentos/salvar') }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="id" name="id" value="{{$pagamento->id}}"/>
                        
                        <div class="form-group{{ $errors->has('despesa_id') ? ' has-error' : '' }}">
                            <label for="despesa_id" class="col-md-4 control-label">Despesa</label>

                            <div class="col-md-6">
                                <select id="despesa_id" name="despesa_id" required>
                                    @foreach($despesas as $despesa)
                                        @if(!empty($despesa))
                                        <option <?php echo ($pagamento->despesa_id == $despesa->id) ? "selected" :""; ?> 
                                            value="{{$despesa->id}}" >
                                            {{$despesa->nome}}</option>
                                        
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('data_inicio') ? ' has-error' : '' }}">
                            <label for="data_inicio" class="col-md-4 control-label">De</label>

                            <div class="col-md-6">
                                <input id="data_inicio" type="date" class="form-control" name="data_inicio" required
                                       value="{{ $data_inicio ?  $data_inicio : old('data_inicio') }}" >

                                @if ($errors->has('data_inicio'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('data_inicio') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('data_fim') ? ' has-error' : '' }}">
                            <label for="data_fim" class="col-md-4 control-label">Até</label>

                            <div class="col-md-6">
                                <input id="data_fim" type="date" class="form-control" name="data_fim" required
                                       value="{{ $data_fim ?  $data_fim : old('data_fim') }}" >

                                @if ($errors->has('data_fim'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('data_fim') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('comessa_id') ? ' has-error' : '' }}">
                            <label for="comessa_id" class="col-md-4 control-label">Comessa</label>

                            <div class="col-md-6">
                                <select id="comessa_id" name="comessa_id" required>
                                    <option value=""> Selecione uma Comessa </option>
                                    @foreach($comessas as $comessa)
                                        @if(!empty($comessa))
                                        <option <?php echo ($pagamento->comessa_id == $comessa->id) ? "selected" :""; ?> 
                                            value="{{$comessa->id}}" >
                                            {{$comessa->codigo . ' - ' . $comessa->descricao}}</option>
                                        
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('funcionario_id') ? ' has-error' : '' }}">
                            <label for="funcionario_id" class="col-md-4 control-label">Colaborador</label>

                            <div class="col-md-6">
                                <select id="funcionario_id" name="funcionario_id" >
                                    <option value =""> Selecione...</option>
                                    @foreach($funcionarios as $funcionario)
                                        @if(!empty($funcionario))
                                        <option <?php echo ($pagamento->funcionario_id == $funcionario->id) ? "selected" :""; ?> 
                                            value="{{$funcionario->id}}" >
                                            {{$funcionario->nome}}</option>
                                        
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div id="div_valores" >
                            <div class="form-group{{ $errors->has('valor_beneficio') ? ' has-error' : '' }}">
                                <label for="valor_beneficio" class="col-md-4 control-label">Valor de<br>Benefícios</label>

                                <div class="col-md-6">
                                    <input id="valor_beneficios" type="text" class="form-control" name="valor_beneficio" 
                                           value="{{ $pagamento->valor_beneficio ?  $pagamento->valor_beneficio : old('valor_beneficio') }}" >

                                    @if ($errors->has('valor_beneficio'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('valor_beneficio') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('valor_descontos') ? ' has-error' : '' }}">
                                <label for="valor_descontos" class="col-md-4 control-label">Valor de<br>Descontos</label>

                                <div class="col-md-6">
                                    <input id="valor_descontos" type="text" class="form-control" name="valor_descontos" value="{{ $pagamento->valor_descontos ?  $pagamento->valor_descontos : old('valor_descontos') }}" >

                                    @if ($errors->has('valor_descontos'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('valor_descontos') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('valor') ? ' has-error' : '' }}">
                                <label for="valor" class="col-md-4 control-label">Salário <br> Líquido</label>

                                <div class="col-md-6">
                                    <input id="valor" type="text" class="form-control" name="valor" required
                                           value="{{ $pagamento->valor ?  $pagamento->valor : old('valor') }}" >

                                    @if ($errors->has('valor'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('valor') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('juros') ? ' has-error' : '' }}">
                            <label for="juros" class="col-md-4 control-label">Juros</label>

                            <div class="col-md-6">
                                <input id="juros" type="text" class="form-control" name="juros" value="{{ $pagamento->juros ?  $pagamento->juros : old('juros') }}" >

                                @if ($errors->has('juros'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('juros') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('data_vencimento') ? ' has-error' : '' }}">
                            <label for="data_vencimento" class="col-md-4 control-label">Data de<br>Vencimento</label>

                            <div class="col-md-6">
                                <input id="data_vencimento" type="date" class="form-control" name="data_vencimento" required
                                       value="{{ $pagamento->data_vencimento ?  $pagamento->data_vencimento : old('data_vencimento') }}" >

                                @if ($errors->has('data_vencimento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('data_vencimento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('data_pagamento') ? ' has-error' : '' }}">
                            <label for="data_pagamento" class="col-md-4 control-label">Data de<br>Pagamento</label>

                            <div class="col-md-6">
                                <input id="data_pagamento" type="date" class="form-control" name="data_pagamento" required
                                       value="{{ $pagamento->data_pagamento ?  $pagamento->data_pagamento : old('data_pagamento') }}" >

                                @if ($errors->has('data_pagamento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('data_pagamento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('valor_pago') ? ' has-error' : '' }}">
                            <label for="valor_pago" class="col-md-4 control-label">Valor<br>Pago</label>

                            <div class="col-md-6">
                                <input id="valor_pago" type="text" class="form-control" name="valor_pago" required
                                       value="{{ $pagamento->valor_pago ?  $pagamento->valor_pago : old('valor_pago') }}" >

                                @if ($errors->has('valor_pago'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('valor_pago') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
            
                        <div class="form-group{{ $errors->has('obs') ? ' has-error' : '' }}">
                            <label for="obs" class="col-md-4 control-label">Observações</label>

                            <div class="col-md-6">
                                <input id="obs" type="text" class="form-control" name="obs" value="{{ $pagamento->obs ?  $pagamento->obs : old('obs') }}" >

                                @if ($errors->has('obs'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('obs') }}</strong>
                                    </span>
                                @endif
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
