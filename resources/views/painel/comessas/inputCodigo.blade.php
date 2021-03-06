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
        <div id="div_Codigo" class="col-md-6">
            <input id="codigo" type="text" class="form-control" readonly name="codigo" 
                   value="{{ $codigo }}" required>

            @if ($errors->has('codigo'))
                <span class="help-block">
                    <strong>{{ $errors->first('codigo') }}</strong>
                </span>
            @endif
        </div>
    </body>
</html>
