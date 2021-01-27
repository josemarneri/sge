@extends('layouts.master')

@section('content')
<div class="area-util">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar Cliente</div>
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
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/painel/clientes/salvar') }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="id" name="id" value="{{$cliente->id}}"/>

                               
                        <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                            <label for="nome" class="col-md-4 control-label">Nome</label>

                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control" name="nome" value="{{ $cliente->nome ? $cliente->nome : old('nome') }}" required>

                                @if ($errors->has('nome'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nome') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('cnpj') ? ' has-error' : '' }}">
                            <label for="cnpj" class="col-md-4 control-label">CNPJ</label>

                            <div class="col-md-6">
                                <input id="cnpj" type="text" class="form-control" name="cnpj" value="{{ $cliente->cnpj ?  $cliente->cnpj : old('cnpj') }}" >

                                @if ($errors->has('cnpj'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cnpj') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('endereco') ? ' has-error' : '' }}">
                            <label for="endereco" class="col-md-4 control-label">Endereço</label>

                            <div class="col-md-6">
                                <input id="endereco" type="text" class="form-control" name="endereco" value="{{ $cliente->endereco ?  $cliente->endereco : old('endereco') }}" >

                                @if ($errors->has('endereco'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('endereco') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
            
                        <div class="form-group{{ $errors->has('telefone') ? ' has-error' : '' }}">
                            <label for="telefone" class="col-md-4 control-label">Telefone</label>

                            <div class="col-md-6">
                                <input id="telefone" type="text" class="form-control" name="telefone" value="{{ $cliente->telefone ?  $cliente->telefone : old('telefone') }}" >

                                @if ($errors->has('telefone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('telefone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $cliente->email ? $cliente->email : old('email') }}" >

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>  
                        
                        <div class="form-group{{ $errors->has('sigla') ? ' has-error' : '' }}">
                            <label for="sigla" class="col-md-4 control-label">Sigla</label>

                            <div class="col-md-6">
                                <input id="sigla" type="text" class="form-control" name="sigla" value="{{ $cliente->sigla ? $cliente->sigla : old('sigla') }}" required>

                                @if ($errors->has('sigla'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sigla') }}</strong>
                                    </span>
                                @endif
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
