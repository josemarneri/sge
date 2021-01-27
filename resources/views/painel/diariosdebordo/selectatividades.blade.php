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
        <select style="max-width: 200px" id="atividade_id" name="atividade_id" >
            @foreach($atividades as $atividade)
                @if(!empty($atividade))
                <option value="{{$atividade->id}}" >{{$atividade->codigo}}</option>
                @endif
            @endforeach
        </select>
    </body>
</html>
