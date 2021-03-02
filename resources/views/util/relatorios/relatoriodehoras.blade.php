@extends('layouts.master')

@section('content')

<div class="area-trabalho"> 
    <script language="JavaScript" src="{{url('js/neri.js')}}"></script>
    <script language="JavaScript" src="{{url('js/jquery-1.6.4.js')}}"></script>
    
    <script type="text/javascript">
    $(document).ready(function(){
        $('#comessa_id').change(function(){
            $('#funcionario').load('/util/relatorios/funcionarioshabilitados/'+$('#comessa_id').val());
        });
        
    });
    </script>
    

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Gerar relatório de horas</div>
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
                          action="{{ url('/util/relatorios/gerarrelatoriohoras') }}">
                        {{ csrf_field() }}
           
                    
                                                
                        <div class="form-group{{ $errors->has('Comessa') ? ' has-error' : '' }}">
                            <label for="Comessa_id" class="col-md-2 control-label col-md-offset-1">Comessa</label>
                            <div class="col-md-4 ">
                                <select id="comessa_id" name="comessa_id" class="form-control">
                                    <option value="" >Selecione </option>
                                    @foreach($comessas as $comessa)
                                        <option value="{{$comessa->id}}" > {{$comessa->codigo .'-'.$comessa->descricao}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('Funcionario') ? ' has-error' : '' }}">
                            <label for="funcionario_id"  class="col-md-2 control-label col-md-offset-1">Funcionário</label>
                            <div id="funcionario" class="col-md-6" >                                
                                <select  class="col-md-6 form-control"  id="funcionario_id" name="funcionario_id[]" 
                                         multiple size="5">
                                    @foreach($funcionarios as $funcionario)
                                        @if(!empty($funcionario))
                                            <option value="{{$funcionario->id}}">{{$funcionario->nome}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>  
                        
                        <div class="form-group{{ $errors->has('de') ? ' has-error' : '' }} ">                            
                            <label for="de" class="col-md-2 control-label col-md-offset-1">De</label>                            
                            <div class="col-md-2 ">
                                <input id="de" name="de" type="date" style=" min-width: 120px"
                                        value="{{$de ? $de : old('de')}}"
                                         required class="form-control">
                                @if ($errors->has('de'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('de') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <label for="ate" class="col-md-1 control-label">Até</label>                            
                            <div class="col-md-2 ">
                                <input  id="ate" name="ate" type="date" style=" min-width: 120px"
                                        value="{{$ate ? $ate : old('ate')}}"
                                        required class="form-control">
                                @if ($errors->has('ate'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ate') }}</strong>
                                    </span>
                                @endif
                            </div> 
                            
                            <label for="formato" class="col-md-1 control-label ">Formato</label>
                            <div class="col-md-1 ">
                                <select style=" min-width: 80px" id="formato" name="formato" class="form-control">
                                    <option value="xlsx" >xlsx </option>
                                    <option value="pdf" >pdf </option>
                                    
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('titulo') ? ' has-error' : '' }}">
                            <label for="titulo" class="col-md-2 control-label col-md-offset-1">Titulo</label>
                            <div class="col-md-8 ">
                                <input id="titulo" type="text"  class="form-control" name="titulo"
                                       value="{{ $titulo ? $titulo : old('titulo') }}" 
                                       required >

                                @if ($errors->has('titulo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('titulo') }}</strong>
                                    </span>
                                @endif 
                            </div>
                            
                        </div>

                        <div class="form-group" style="margin-top: 15px">
                            <div class="col-md-6 col-md-offset-4">
                                <button  name="btnSalvar" type="submit" 
                                        class="btn btn-primary"  >
                                    Gerar Relatório
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
