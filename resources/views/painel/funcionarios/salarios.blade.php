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
        <select id="salario_id" name="salario_id" >
            -------
            @if (!empty($salarios))
                @foreach($salarios as $salario)
                    <option value="{{$salario->id}}">{{'Mensal: R$'.$salario->valor_mensal .' +   R$'.$salario->valor_hora .' / hora  '}}</option>
                @endforeach
            @endif
        </select>
    </body>
</html>
