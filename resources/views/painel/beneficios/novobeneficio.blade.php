@extends('layouts.master')

@section('content')
<div class="area-trabalho">
    <script language="JavaScript" src="{{url('js/neri.js')}}"></script>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar Beneficio</div>
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
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/painel/beneficios/salvar') }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="id" name="id" value="{{$beneficio->id}}"/>

                               
                        <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                            <label for="nome" class="col-md-4 control-label">Nome</label>

                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control" name="nome" required
                                       value="{{ $beneficio->nome ? $beneficio->nome : old('nome') }}" >

                                @if ($errors->has('nome'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nome') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
                            <label for="descricao" class="col-md-4 control-label">Descrição</label>

                            <div class="col-md-6">
                                <input id="descricao" type="text" class="form-control" name="descricao" 
                                       value="{{ $beneficio->descricao ?  $beneficio->descricao : old('descricao') }}" >

                                @if ($errors->has('descricao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descricao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('valor') ? ' has-error' : '' }}">
                            <label for="valor" class="col-md-4 control-label">Valor (R$)</label>

                            <div class="col-md-6">
                                <input id="valor" type="text" class="form-control" name="valor" required
                                       onkeydown ="return(mascaraMoeda(this,event))"
                                       value="{{ $beneficio->valor ?  $beneficio->valor : old('valor') }}" >

                                @if ($errors->has('valor'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('valor') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('percentual') ? ' has-error' : '' }}">
                            <label for="percentual" class="col-md-4 control-label">Valor (%)</label>

                            <div class="col-md-6">
                                <input id="percentual" type="text" class="form-control" name="percentual" required
                                       onkeydown ="return(mascaraPercentual(this,event))"
                                       value="{{ $beneficio->percentual ?  $beneficio->percentual : old('percentual') }}" >

                                @if ($errors->has('percentual'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('percentual') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('desconto_valor') ? ' has-error' : '' }}">
                            <label for="desconto_valor" class="col-md-4 control-label">Desconto (R$)</label>

                            <div class="col-md-6">
                                <input id="desconto_valor" type="text" class="form-control" name="desconto_valor" 
                                       onkeydown ="return(mascaraMoeda(this,event))"
                                       value="{{ $beneficio->desconto_valor ?  $beneficio->desconto_valor : old('desconto_valor') }}" >

                                @if ($errors->has('desconto_valor'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('desconto_valor') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('desconto_percentual') ? ' has-error' : '' }}">
                            <label for="desconto_percentual" class="col-md-4 control-label">Desconto (%)</label>

                            <div class="col-md-6">
                                <input id="desconto_percentual" type="text" class="form-control" name="desconto_percentual" 
                                       onkeydown="return(mascaraPercentual(this,event))"
                                       value="{{ $beneficio->desconto_percentual ?  $beneficio->desconto_percentual : old('desconto_percentual') }}" >

                                @if ($errors->has('desconto_percentual'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('desconto_percentual') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('ativo') ? ' has-error' : '' }}">
                            <label for="ativo" class="col-md-4 control-label">Ativo</label>

                            <div class="col-md-6">
                                <input type="checkbox" name="ativo" value="1"
                                           <?php echo ($beneficio->ativo) ? "checked" :""; ?> >
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
