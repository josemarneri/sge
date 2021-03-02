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
                               
            <select  class="col-md-6 form-control" id="funcionario_id" name="funcionario_id[]" 
                     multiple size="5">
                @foreach($funcionarios as $funcionario)
                    @if(!empty($funcionario))
                    <option value="{{$funcionario->id}}" selected >{{$funcionario->nome}}</option>
                    @endif
                @endforeach
            </select>

    </body>
</html>
