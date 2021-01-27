@extends('layouts.master')

@section('content')
<div class="area-util">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar orçamento</div>
                @if(count($errors->all()) > 0)
                <div class="alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}} </li>                   
                        @endforeach  
                    </ul>
                </div>                    
                    
                @endif
                @if(Session::has('mensagem_sucesso'))
                    <div class="alert alert-success">{{Session::get('mensagem_sucesso')}}</div>    
                @endif
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/painel/orcamentos/salvar') }}">
                        {{ csrf_field() }}
           
                        
                        <input type="hidden" id="id" name="id" value="{{$orcamento->id}}"/>

                        <div class="form-group{{ $errors->has('cliente_id') ? ' has-error' : '' }}">
                            <label for="cliente_id" class="col-md-4 control-label">Cliente</label>

                            <div class="col-md-6">
                                <select id="cliente_id" name="cliente_id" >
                                    @foreach($clientes as $cliente)
                                        <option <?php echo ($cliente->id == $orcamento->cliente_id) ? "selected" :""; ?> 
                                            value="{{$cliente->id}}">  {{$cliente->sigla}} </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
                            <label for="descricao" class="col-md-4 control-label">Descrição</label>

                            <div class="col-md-6">
                                <input id="descricao" type="text" class="form-control" name="descricao" value="{{ $orcamento->descricao ? $orcamento->descricao : old('descricao') }}" required autofocus>

                                @if ($errors->has('descricao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descricao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        
                        
                        
                         
                        
                        <div class="form-group{{ $errors->has('pedido') ? ' has-error' : '' }}">
                            <label for="pedido" class="col-md-4 control-label">Pedido</label>

                            <div class="col-md-6">
                                <input id="pedido" type="text" class="form-control" name="pedido" value="{{ $orcamento->pedido ? $orcamento->pedido : old('pedido') }}">

                                @if ($errors->has('pedido'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pedido') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label for="status" class="col-md-4 control-label">Status</label>
                            <div class="col-md-6">

                                <select id="status" name="status" >
                                         <option value="Aguardando">Aguardando</option>
                                         <option value="Aprovado">Aprovado</option>
                                         <option value="Reprovado">Reprovado</option>
                                </select>
                            </div>
                        </div> 

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Salvar
                                </button>
                            </div>
                        </div>                        
                    </form>
                 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
