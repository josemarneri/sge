@extends('layouts.master')

@section('content')
<div class="area-util">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar equipe</div>
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
                    <form class="form-horizontal" perfil="form" method="POST" action="{{ url('/painel/equipe/salvar') }}">
                        {{ csrf_field() }}
                        
                        <input type="hidden" name="comessa_id" value="{{$comessa->id}}">
                               
                        <div class="form-group{{ $errors->has('comessa') ? ' has-error' : '' }}">
                            <label for="comessa" class="col-md-4 control-label">Comessa</label>

                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control" name="comessa" readonly
                                       value="{{ $comessa->codigo ? $comessa->codigo : old('comessa') }}"  required>

                                @if ($errors->has('comessa'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('comessa') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('responsavel') ? ' has-error' : '' }}">
                            <label for="responsavel" class="col-md-4 control-label">Responsável</label>

                            <div class="col-md-6">
                                <input id="responsavel" type="text" class="form-control" name="responsavel" readonly
                                       value="{{ $comessa->getNomeFuncionario($comessa->coordenador_id) ? $comessa->getNomeFuncionario($comessa->coordenador_id) : old('responsavel') }}" >

                                @if ($errors->has('responsavel'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('responsavel') }}</strong>
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
                        <div class="painel-carga">
                            
                            @if(!empty($comessa->id))                        
                            <div style="border-top: #e4edf0 solid 1px" class="listasx">
                                <label  style="text-align: center">Inclusos</label> <br>
                                @if(!empty($inclusos))
                                    @foreach($inclusos as $incluso)
                                        <div  >
                                            <input type="checkbox" name="inclusos[]" value="{{$incluso->id}}"
                                                   checked >{{$incluso->nome}}
                                        </div> 

                                    @endforeach 
                                @endif
                                <br>
                                <label  style="text-align: center">Habilitados</label> <br>
                                @if(!empty($habilitados))
                                    @foreach($habilitados as $habilitado)
                                        <div  >
                                            <input type="checkbox" name="habilitados[]" value="{{$habilitado->id}}"
                                                   checked >{{$habilitado->nome}}
                                        </div> 

                                    @endforeach 
                                @endif
                            </div>
                            <div style="border-top: #e4edf0 solid 1px" class="listadx">
                                <label  style="text-align: center">Disponíveis (I=Incluir H=Habilitar)</label> <br>
                                <div style="width: 100%; float: left"  >
                                        <div class="checkbox_sx">
                                            <label title="Incluir" style="text-align: center">I</label>
                                        </div>                                        
                                        <div class="checkbox_dx">
                                            <label title="Habilitar" style="text-align: center">H</label>
                                        </div>                                       
                                    </div>
                                <br>
                                @if(!empty($exclusos))
                                    @foreach($exclusos as $excluso) 
                                    <div style="width: 100%; float: left"  >
                                            <div class="checkbox_sx">
                                                <input type="checkbox" name="exclusos_I[]" 
                                                    value="{{$excluso->id}}" >
                                            </div>

                                            <div class="checkbox_dx">
                                                <input type="checkbox" name="exclusos_H[]" 
                                                    value="{{$excluso->id}}" >
                                            </div>
                                            <div class="checkbox_text">
                                                {{$excluso->nome}}
                                            </div>                                        
                                        </div>
                                    <br>
                                    @endforeach
                                @endif

                            </div>
                            @endif
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
