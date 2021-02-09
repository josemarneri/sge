@extends('layouts.master')

@section('content')

<div class="area-util"> 
    <script language="JavaScript" src="{{url('js/neri.js')}}"></script>
    <script language="JavaScript" src="{{url('js/jquery-1.6.4.js')}}"></script>
    
    <script type="text/javascript">
    $(document).ready(function(){
        $('#comessa_id').change(function(){
            $('#funcionario').load('/painel/atividades/funcionarioshabilitados/'+$('#comessa_id').val());
        });
        
    });
    </script>
    

    <div class="row">
        <div class="col-md-10 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar atividade</div>
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
                          action="{{ url('/painel/atividades/salvar') }}">
                        {{ csrf_field() }}
           
                        <div>
                            <input type="hidden" id="id" name="id" value="{{$atividade->id}}"/>
                        </div>                    
                                                
                        <div class="form-group{{ $errors->has('Comessa') ? ' has-error' : '' }}">
                            <label for="Comessa_id" class="col-sm-1 control-label col-md-offset-1">Comessa</label>
                            <div class="col-sm-2 ">
                                <select id="comessa_id" name="comessa_id" >
                                    <option value="0" onclick="getCodigo(this,'',document.form1.btnSalvar)">
                                        Selecione </option>
                                    @foreach($comessas as $comessa)
                                        <option <?php echo ($comessa->id == $atividade->comessa_id) ? "selected" :" "; ?> 
                                            value="{{$comessa->id}}" 
                                            onclick="getCodigo(this,'{{$atividade->getCodigo($comessa->id)}}',document.form1.btnSalvar)"> 
                                            {{$comessa->codigo}} </option>
                                    @endforeach

                                </select>
                            </div>
                            
                            <label for="codigo" class="col-sm-1 control-label">Código</label>
                            <div class="col-sm-2">
                                <input id="codigo" type="text" size="12" class="form-control" readonly name="codigo" 
                                       value="{{ $atividade->codigo ? $atividade->codigo : old('codigo') }}" required>

                                @if ($errors->has('codigo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('codigo') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="form-group{{ $errors->has('funcionario_id') ? ' has-error' : '' }}">
                                <label for="funcionario_id" style="width: 115px" class="col-md-1 control-label">Funcionário</label>

                                <div id="funcionario" class="col-md-2" >                                
                                    <select style="max-width: 150px" id="funcionario_id" name="funcionario_id" >
                                            Selecione </option>
                                        @foreach($funcionarios as $funcionario)
                                            @if(!empty($funcionario))
                                                <option <?php echo ($atividade->funcionario_id == $funcionario->id) ? "selected" :""; ?> 
                                                value="{{$funcionario->id}}" > 
                                                {{$funcionario->nome}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <label for="horasprev" class="col-sm-1 control-label col-md-offset-1">Horas</label>
                            <div class="col-md-1">
                                <input id="horasprev" type="text" class="form-control" name="horasprev" 
                                       value="{{ $atividade->horasprev ? $atividade->horasprev : old('horasprev') }}" 
                                       style="width: 100px" required>

                                @if ($errors->has('horasprev'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('horasprev') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <label for="prev_inicio" class="col-md-2 control-label">Prev. início</label>                            
                            <div class="col-md-1">
                                <input id="prev_inicio" name="prev_inicio" type="date" 
                                        value="{{$atividade->prev_inicio ? $atividade->prev_inicio : old('prev_inicio')}}"
                                         required>
                                @if ($errors->has('prev_inicio'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('prev_inicio') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <label for="prev_fim" style="width: 120px" class="col-md-1 col-md-offset-1 control-label">Prev. Término</label>                            
                            <div class="col-md-1 ">
                                <input  id="prev_fim" name="prev_fim" type="date" 
                                        value="{{$atividade->prev_fim ? $atividade->prev_fim : old('prev_fim')}}"
                                        required>
                                @if ($errors->has('prev_fim'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('prev_fim') }}</strong>
                                    </span>
                                @endif
                            </div>                            
                        </div>
                        
                        <div class="form-group{{ $errors->has('titulo') ? ' has-error' : '' }}">
                            <label for="titulo" class="col-md-1 control-label col-md-offset-1">Titulo</label>

                            <div class="col-md-9">
                                <input id="titulo" type="text"  class="form-control" name="titulo"
                                       value="{{ $atividade->titulo ? $atividade->titulo : old('titulo') }}" 
                                       required >

                                @if ($errors->has('titulo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('titulo') }}</strong>
                                    </span>
                                @endif
                            </div>                            
                        </div>

                        <div  class="border_bottom form-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
                            <label for="descricao" class="col-md-1 control-label col-md-offset-1">Descrição</label>

                            <div class="col-md-9">
                                <textarea id="descricao" ROWS=4  class="form-control" name="descricao">{{ $atividade->descricao ? $atividade->descricao : old('descricao') }}</textarea>

                                @if ($errors->has('descricao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descricao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div id="espaco2">   
                            <label > CheckLists</label><br>
                            <div id="check-list">                                
                                @if(!empty($checklists))
                                    @foreach($checklists as $checklist)
                                        <div  class="col-md-4">
                                            <input type="checkbox" name="checklists_id[]" value="{{$checklist->id}}"
                                            <?php echo $atividade->hasChecklist($checklist->id)? "checked": ""  ?>       >{{$checklist->nome}}
                                        </div> 
                                    @endforeach 
                                @endif   
                            </div>
                            @if(!empty($atividade->id))
                            <label style="padding-top: 10px"> Anexos </label>
                            <a href="{{url("arquivos/anexar/atividades/".$atividade->id)}}" title="Adicionar anexo">
                                    <img src="{{url('/assets/imagens/add.png')}}" alt="Adicionar anexo" />
                            </a>
                            <div id="anexos" class="anexos">  
                               @if(!empty($anexos))
                                    @foreach($anexos as $anexo)
                                    <div  class="col-md-5">
                                        <a href="{{url("arquivos/baixar/".$anexo->id)}}" title="Adicionar anexo">  {{$anexo->nome}} </a>
                                    </div>  
                                    @endforeach 
                                @endif 
                            </div>
                            @endif
                        </div>
                        <div class="form-group" style="margin-top: 15px">
                            <div class="col-md-6 col-md-offset-4">
                                <button onmouseover="enableSalvar2(document.form1.funcionario_id,document.form1.comessa_id, this)" name="btnSalvar" type="submit" 
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
