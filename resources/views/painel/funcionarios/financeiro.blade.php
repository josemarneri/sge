@extends('layouts.master')

@section('content')
<div class="area-trabalho">
   <div class="row">
        <div class="col-md-8 col-md-offset-1">
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
                <div class="panel-heading control-label">
                    <b><h4>Resumo financeiro</h4></b>
                </div>
                    <div class="panel-body">
                        <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
                            <label  class="col-md-6 control-label col-md-offset-1">
                                {{ $funcionario->nome }}</label>
                            <label  class="col-md-4 control-label col-md-offset-1">
                                Registro : {{ $funcionario->id }}</label>
                            <br> <hr>
                            <label  class="col-md-6 control-label col-md-offset-1">
                                Salário  : </label>
                            <label  class="col-md-4 control-label col-md-offset-1">
                                {{ $funcionario->getValorSalario() }}</label>


                            <label  class="col-md-6 control-label col-md-offset-1">
                                Total de Benefícios :</label>
                            <label  class="col-md-4 control-label col-md-offset-1">
                                {{ $funcionario->getValorBeneficios() }}</label>
                            
                            <label  class="col-md-6 control-label col-md-offset-1">
                                Total de descontos sobre Benefícios : </label>
                            <label  class="col-md-4 control-label col-md-offset-1">
                                {{ $funcionario->getValorDescontoBeneficios() }}</label>
                            <label  class="col-md-6 control-label col-md-offset-1">
                                Total de Descontos : </label>
                            <label  class="col-md-4 control-label col-md-offset-1">
                                {{ $funcionario->getValordescontos() }}</label>
                            <br> <hr>
                            <label  class="col-md-6 control-label col-md-offset-1" style="text-align: right">
                                Salário Liquido : </label>
                            <label  class="col-md-4 control-label col-md-offset-1">
                                {{ $funcionario->getValorSalarioLiquido() }}</label>
                            <br> <hr>

                        </div> 

                    </div>
                </div>
            </div>
       </div>
    <br><br>
    <div class="title-2">
        Lista de Benefícios        
    </div>
    
    
    <table class="table table-hover table-condensed" >
        <thead>

            <tr>
                <th style="text-align: center">Id</th>
                <th style="text-align: center">Nome</th>
                <th style="text-align: center">Descrição</th>
                <th style="text-align: center">Valor (R$)</th>
                <th style="text-align: center">Valor (%)</th>
                <th style="text-align: center">Desconto (R$)</th>
                <th style="text-align: center">Desconto (%)</th>
                <th width="100" style="text-align: center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($beneficios as $beneficio)               
            <tr>
                <td style="text-align: center">{{$beneficio->id}}</td>
                <td style="text-align: center">{{$beneficio->nome}}</td>
                <td style="text-align: center">{{$beneficio->descricao}}</td>
                <td style="text-align: center">{{$beneficio->valor}}</td>
                <td style="text-align: center">{{$beneficio->percentual}}</td>
                <td style="text-align: center">{{$beneficio->desconto_valor}}</td>
                <td style="text-align: center">{{$beneficio->desconto_percentual}}</td>
                <td width="100" style="text-align: center">

                    <a href="{{url("/painel/funcionarios/apagarbeneficio/$beneficio->id/$funcionario->id")}}" title="Remover beneficio">
                        <img src="{{url('/assets/imagens/Delete.png')}}" alt="Remover beneficio" />
                    </a>
                </td>
            </tr>
            @empty
                <p> Nenhum desconto cadastrado!!!</p>
            @endforelse
        </tbody>
    </table>
    <br><br>
    <div class="title-2">
        Lista de Descontos        
    </div>
    
    
    <table class="table table-hover table-condensed" >
        <thead>

            <tr>
                <th style="text-align: center">Id</th>
                <th style="text-align: center">Nome</th>
                <th style="text-align: center">Descrição</th>
                <th style="text-align: center">Valor (R$)</th>
                <th style="text-align: center">Valor (%)</th>

                <th width="100" style="text-align: center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($descontos as $desconto)               
            <tr>
                <td style="text-align: center">{{$desconto->id}}</td>
                <td style="text-align: center">{{$desconto->nome}}</td>
                <td style="text-align: center">{{$desconto->descricao}}</td>
                <td style="text-align: center">{{$desconto->valor}}</td>
                <td style="text-align: center">{{$desconto->percentual}}</td>

                <td width="100" style="text-align: center">

                    <a href="{{url("/painel/funcionarios/apagardesconto/$desconto->id/$funcionario->id")}}" title="Remover desconto">
                        <img src="{{url('/assets/imagens/Delete.png')}}" alt="Remover desconto" />
                    </a>
                </td>
            </tr>
            @empty
                <p> Nenhum desconto cadastrado!!!</p>
            @endforelse
        </tbody>
    </table>

   
    
</div>
@endsection


