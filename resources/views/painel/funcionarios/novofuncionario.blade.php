@extends('layouts.master')

@section('content')
<div class="container">
    <script language="JavaScript" src="{{url('js/neri.js')}}"></script>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar</div>
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
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/painel/funcionarios/salvar') }}">
                        {{ csrf_field() }}
                        
                        <input type="hidden" id="ativo" name="ativo" value="{{$funcionario->ativo}}"/>

                        <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
                            <label for="id" class="col-md-4 control-label">Registro</label>

                            <div class="col-md-6">
                                <input id="id" type="text" class="form-control" name="id" value="{{ $funcionario->id ? $funcionario->id : old('id') }}" required autofocus>

                                @if ($errors->has('id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div> 
                        
                        <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                            <label for="nome" class="col-md-4 control-label">Nome</label>

                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control" name="nome" value="{{ $funcionario->nome ? $funcionario->nome : old('nome') }}" required>

                                @if ($errors->has('nome'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nome') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
                            <label for="cpf" class="col-md-4 control-label">CPF</label>

                            <div class="col-md-6">
                                <input id="cpf" type="text" class="form-control" name="cpf" value="{{ $funcionario->cpf ? $funcionario->cpf : old('cpf') }}">

                                @if ($errors->has('cpf'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cpf') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('rg') ? ' has-error' : '' }}">
                            <label for="rg" class="col-md-4 control-label">RG</label>

                            <div class="col-md-6">
                                <input id="rg" type="text" class="form-control" name="rg" value="{{ $funcionario->rg ? $funcionario->rg : old('rg') }}">

                                @if ($errors->has('rg'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rg') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('regCliente') ? ' has-error' : '' }}">
                            <label for="regCliente" class="col-md-4 control-label">Registro (Cliente)</label>

                            <div class="col-md-6">
                                <input id="regCliente" type="text" class="form-control" name="regCliente" value="{{ $funcionario->regCliente ? $funcionario->regCliente : old('regCliente') }}">

                                @if ($errors->has('regCliente'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('regCliente') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('endereco') ? ' has-error' : '' }}">
                            <label for="endereco" class="col-md-4 control-label">Endereço</label>

                            <div class="col-md-6">
                                <input id="endereco" type="text" class="form-control" name="endereco" value="{{ $funcionario->endereco ?  $funcionario->endereco : old('endereco') }}" >

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
                                <input id="telefone" type="text" class="form-control" name="telefone" value="{{ $funcionario->telefone ?  $funcionario->telefone : old('telefone') }}" >

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
                                <input id="email" type="email" class="form-control" name="email" value="{{ $funcionario->email ? $funcionario->email : old('email') }}" >

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('cargo_id') ? ' has-error' : '' }}">
                            <label for="cargo_id" class="col-md-4 control-label">Cargo</label>
                            <div class="col-md-6">
                                <select id="cargo_id" name="cargo_id" >
                                         <option value="">Selecione um cargo</option>
                                    @foreach($cargos as $cargo)
                                        <option <?php echo ($cargo->id == $funcionario->cargo_id) ? "selected" :""; ?> 
                                            value="{{$cargo->id}}">{{$cargo->nome}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('funcao_id') ? ' has-error' : '' }}">
                            <label for="funcao_id" class="col-md-4 control-label">Função</label>
                            <div class="col-md-6">
                                <select id="funcao_id" name="funcao_id" >
                                         <option value="">Selecione uma Função</option>
                                    @foreach($funcoes as $funcao)
                                        <option <?php echo ($funcao->id == $funcionario->funcao_id) ? "selected" :""; ?> 
                                            value="{{$funcao->id}}">{{$funcao->nome}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                            <label for="user_id" class="col-md-4 control-label">Usuário</label>
                            <div class="col-md-6">
                                <select id="user_id" name="user_id" >
                                         <option value="{{$users[1]->id}}">{{$users[1]->name}}</option>
                                    @foreach($users as $user)
                                        @if($user->id != 2)
                                        <option <?php echo ($user->id == $funcionario->user_id) ? "selected" :""; ?> 
                                            value="{{$user->id}}">{{$user->login}}</option>
                                        @endif
                                    @endforeach

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
