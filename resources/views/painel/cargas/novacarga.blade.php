@extends('layouts.master')

@section('content')

<div class="area-trabalho"> 
    <script language="JavaScript" src="{{url('js/neri.js')}}"></script>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar carga de trabalho</div>
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
                          action="{{ url('/painel/cargas/salvar') }}">
                        {{ csrf_field() }}
           
                        
                        <input type="hidden" id="id" name="id" value="{{$carga->id}}"/>
                        
                        
                        @if(empty($carga->funcionario_id))
                        <div class="form-group{{ $errors->has('funcionario_id') ? ' has-error' : '' }}">
                            <label for="funcionario" class="col-md-4 control-label">Funcionário</label>

                            <div class="col-md-6">
                                <select id="funcionario" name="funcionario_id" >
                                    <option value="0" onclick="disableSalvar(document.form1.btnSalvar)">Selecione um funcionário</option>
                                    @foreach($funcionarios as $funcionario)
                                        <option <?php echo ($funcionario->id == $carga->funcionario_id) ? "selected" :" "; ?> 
                                            value="{{$funcionario->id}}"  > 
                                            {{$funcionario->nome}} </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        @else
                            <input type="hidden" id="funcionario_id" name="funcionario_id" value="{{$carga->funcionario_id}}"/>
                        @endelse
                        @endif
                   
                        <div class="form-group{{ $errors->has('comessa_id') ? ' has-error' : '' }}">
                            <label for="comessa" class="col-md-4 control-label">Comessa</label>

                            <div class="col-md-6">
                                <select id="comessa" name="comessa_id" >
                                    <option value="0" onclick="disableSalvar(document.form1.btnSalvar)">Selecione uma comessa</option>
                                    @foreach($comessas as $comessa)
                                        <option <?php echo ($comessa->id == $carga->comessa_id) ? "selected" :""; ?> 
                                            value="{{$comessa->id}}" title="{{$comessa->descricao}}">  {{$comessa->codigo}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('data_inicio') ? ' has-error' : '' }}">
                            <label for="data_inicio" class="col-md-4 control-label">Data de início</label>
                            
                            <div class="col-md-6">
                                <input id="data_inicio" name="data_inicio" type="date" 
                                        value="{{$carga->data_inicio ? $carga->data_inicio : old('data_inicio')}}"
                                        required>
                                
                                

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
                                       value="{{$carga->data_fim ? $carga->data_fim : old('data_fim')}}" required>

                                @if ($errors->has('data_fim'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('data_fim') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('obs') ? ' has-error' : '' }}">
                            <label for="obs" class="col-md-4 control-label">Observações</label>

                            <div class="col-md-6">
                                <input id="obs" type="text" class="form-control" name="obs"
                                       value="{{ $carga->obs ? $carga->obs : old('obs') }}" autofocus>

                                @if ($errors->has('obs'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('obs') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('livre') ? ' has-error' : '' }}">
                            <label for="livre" class="col-md-4 control-label">Livre</label>

                            <div class="col-md-6">
                                <input type="checkbox" name="livre" value="1"
                                           <?php echo ($carga->livre) ? "checked" :""; ?> >
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button onmouseover="enableSalvar2(document.form1.funcionario_id,document.form1.comessa_id, this)"
                                        name="btnSalvar" type="submit" 
                                        class="btn btn-primary"  >
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
