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
        <div class="form-group{{ $errors->has('valor_beneficio') ? ' has-error' : '' }}">
            <label for="valor_beneficio" class="col-md-4 control-label">Valor de<br>Benefícios</label>

            <div class="col-md-6">
                <input id="valor_beneficios" type="text" class="form-control" name="valor_beneficio" 
                       value="{{ $pagamento->valor_beneficio ?  $pagamento->valor_beneficio : old('valor_beneficio') }}" >

                @if ($errors->has('valor_beneficio'))
                    <span class="help-block">
                        <strong>{{ $errors->first('valor_beneficio') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('valor_descontos') ? ' has-error' : '' }}">
            <label for="valor_descontos" class="col-md-4 control-label">Valor de<br>Descontos</label>

            <div class="col-md-6">
                <input id="valor_descontos" type="text" class="form-control" name="valor_descontos" 
                       value="{{ $pagamento->valor_descontos ?  $pagamento->valor_descontos : old('valor_descontos') }}" >

                @if ($errors->has('valor_descontos'))
                    <span class="help-block">
                        <strong>{{ $errors->first('valor_descontos') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('valor') ? ' has-error' : '' }}">
            <label for="valor" class="col-md-4 control-label">Salário <br> Líquido</label>

            <div class="col-md-6">
                <input id="valor" type="text" class="form-control" name="valor" required
                       value="{{ $pagamento->valor ?  $pagamento->valor : old('valor') }}" >

                @if ($errors->has('valor'))
                    <span class="help-block">
                        <strong>{{ $errors->first('valor') }}</strong>
                    </span>
                @endif
            </div>
        </div>
                        
    </body>
</html>
