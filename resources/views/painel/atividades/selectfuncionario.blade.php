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
        <select style="max-width: 200px" id="funcionario_id" name="funcionario_id" >
            @foreach($funcionarios as $funcionario)
                @if(!empty($funcionario))
                <option <?php echo ($funcionario->id == $funcionario->id) ? "selected" :""; ?> 
                    value="{{$funcionario->id}}" onchange="enableSalvar(document.form1.orcamento_id, document.form1.btnSalvar)"> 
                    {{$funcionario->nome}}</option>
                @endif
            @endforeach
        </select>
    </body>
</html>
