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
            <input id="codigo" type="text" class="form-control" readonly name="codigo" 
                   value="{{ $comessa->codigo ? $comessa->codigo : old('codigo') }}" required>

            @if ($errors->has('codigo'))
                <span class="help-block">
                    <strong>{{ $errors->first('codigo') }}</strong>
                </span>
            @endif
    </body>
</html>
