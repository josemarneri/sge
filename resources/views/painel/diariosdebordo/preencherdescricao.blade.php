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
        <div id='div_descricao' class="border_bottom form-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
            <label for="descricao" class="col-md-1 control-label col-md-offset-1">Descrição</label>

            <div  class="col-md-9">
                <input  id="descricao" name="descricao"  class="form-control" required readonly
                         value="{{ $descricao ? $descricao : old('descricao') }}">

                @if ($errors->has('descricao'))
                    <span class="help-block">
                        <strong>{{ $errors->first('descricao') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </body>
</html>
