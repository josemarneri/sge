@extends('layouts.master')

@section('content')

<div class="area-trabalho"> 
    
    <script language="JavaScript" src="{{url('js/neri.js')}}"></script>
    <script language="JavaScript" src="{{url('js/jquery-1.6.4.js')}}"></script>
    
    <script type="text/javascript">
    $(document).ready(function(){
        $('#comessa_id').change(function(){
            $('#atividade').load('/painel/diariosdebordo/atividades/'+$('#comessa_id').val());
        });
        
        $('#data').change(function(){
            $('#hs_pendentes').load('/painel/diariosdebordo/horaspendentes/'+$('#data').val());
        });
        
    });
    
    
    function changeFocus(campo2){                
        campo2.focus = true;
    }
    </script>
    

    <div class="row">
        <div class="col-md-9 col-md-offset-2">
            <div class="panel panel-default">
               
                @if(!empty($errors->all()))
                <div class="alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}} </li>                   
                        @endforeach  
                    </ul>
                </div>  
                <br>
                    
                @endif
                <div class="panel-heading">Diário de Bordo</div>
                  
                
                <div class="panel-body">
                    <form name="form1" class="form-horizontal" role="form" method="POST" 
                          action="{{ url('/painel/diariosdebordo/salvar') }}">
                        {{ csrf_field() }}
           
                        <div>
                            <input type="hidden" id="id" name="id" value="{{$diariodebordo->id}}"/>
                            <input type="hidden" id="funcionario_id" name="funcionario_id" value="{{$diariodebordo->funcionario_id}}"/>
                            @if(empty($diariodebordo->funcionario_id))
                                <input type="hidden" id="funcionario_id" name="funcionario_id" value="{{$diariodebordo->getFuncionarioByUser()->id}}"/>
                            @endif
                        </div>  
                                                

                        <div class="form-group{{ $errors->has('data') ? ' has-error' : '' }}">  
                            <label for="data" class="col-sm-1 control-label col-md-offset-1">Data</label>
                            <div class="col-sm-2 "> 
                                <input id="data" name="data" type="date" 
                                       value="{{ $diariodebordo->data ? $diariodebordo->data : old('data') }}" 
                                       required>
                            </div>

                            <label for="n_horas" class="col-sm-1 control-label">Horas</label>
                            <div class="col-md-1">
                                <input id="n_horas" type="time"   name="n_horas" 
                                       value="{{ $diariodebordo->n_horas ? $diariodebordo->n_horas : old('n_horas') }}" 
                                       required 
                                       onblur ="maxValue(document.form1.horas_pendentes,this)">

                                @if ($errors->has('n_horas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('n_horas') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <label for="horas_pendentes" class="col-sm-2 control-label ">Horas Pendentes</label>
                            <div  id="hs_pendentes" class="col-md-1">
                                @if(!empty($horas))
                                <input id="horas_pendentes" type="text" class="form-control" name="horas_pendentes"  
                                       style="width: 70px; border:none; background:none; color: red" readonly 
                                       value="{{$horas_pendentes}}" >
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('Comessa') ? ' has-error' : '' }}">

                            <label for="Comessa_id" class="col-sm-1 control-label col-md-offset-1">Comessa  </label>
                            <div class="col-sm-2 ">
                                <select id="comessa_id" name="comessa_id" >
                                    <option value="0" onclick="getCodigo(this,'',document.form1.btnSalvar)">
                                        Selecione </option>
                                    @foreach($comessas as $comessa)
                                        <option <?php echo ($comessa->id == $diariodebordo->comessa_id) ? "selected" :" "; ?> 
                                            value="{{$comessa->id}}" > 
                                            {{$comessa->codigo}} </option>
                                    @endforeach

                                </select>
                            </div>

                            <label for="atividade_id" style="width: 115px" class="col-md-1 control-label">Atividade</label>

                            <div id="atividade" class="col-md-2" > 
                                @if(!empty($atividades))
                                <select style="max-width: 150px" id="atividade_id" name="atividade_id" >
                                    @foreach($atividades as $atividade)
                                        @if(!empty($atividade))
                                        <option <?php echo ($diariodebordo->atividade_id == $atividade->id) ? "selected" :""; ?> 
                                            value="{{$atividade->id}}" > 
                                            {{$atividade->codigo}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @endif
                            </div>
                        </div>

                        <div  class="border_bottom form-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
                            <label for="descricao" class="col-md-1 control-label col-md-offset-1">Descrição</label>

                            <div class="col-md-9">
                                <textarea required id="descricao" ROWS=4  class="form-control" name="descricao">{{ $diariodebordo->descricao ? $diariodebordo->descricao : old('descricao') }}</textarea>

                                @if ($errors->has('descricao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descricao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group" style="margin-top: 15px">
                            <div class="col-md-6 col-md-offset-4">
                                <button onmouseover="enableSalvar(document.form1.comessa_id, this)" name="btnSalvar" type="submit" 
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
    <div>
        @yield('lista')
    </div>
</div>
@endsection
