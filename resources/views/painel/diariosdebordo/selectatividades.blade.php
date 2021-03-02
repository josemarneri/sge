<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
                           
        <div  id="div_atividade" class="form-group{{ $errors->has('Atividade') ? ' has-error' : '' }}"> 
            <label for="atividade_id" class="col-sm-1 control-label col-md-offset-1">Atividade</label>                           
            <div  class="col-md-2" > 
                <select  id="atividade_id" name="atividade_id" onchange="preencherDescricao(document.form1.comessa_id, this,document.form1.descricao)">
                @if(!empty($atividades))                                
                    @foreach($atividades as $atividade)
                        @if(!empty($atividade))
                        <option  value="{{$atividade->id}}"  > 
                            {{$atividade->codigo .' - '. $atividade->titulo}}</option>
                        @endif
                    @endforeach
                @else
                <option value="">Nenhuma atividade cadastrada para esta Comessa</option>                                
                @endif
                </select>
            </div>
        </div>

    </body>
</html>
