@extends('layouts.master')

@section('content')
<div class="area-trabalho">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Incluir beneficiados</div>
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
                    <form class="form-horizontal" perfil="form" method="POST" action="{{ url('/painel/beneficiados/salvar') }}">
                        {{ csrf_field() }}
                        
                        <input type="hidden" name="beneficio_id" value="{{$beneficio->id}}">
                               
                        <div class="form-group{{ $errors->has('beneficio') ? ' has-error' : '' }}">
                            <label for="nome" class="col-md-4 control-label">Beneficio</label>

                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control" name="nome" readonly
                                       value="{{ $beneficio->nome ? $beneficio->nome : old('beneficio') }}"  >

                                @if ($errors->has('beneficio'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('beneficio') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
                            <label for="descricao" class="col-md-4 control-label">Descrição</label>
                            <div class="col-md-6">
                                <input id="descricao" type="text" class="form-control" name="descricao" readonly
                                       value="{{ $beneficio->descricao ? $beneficio->descricao : old('descricao') }}"  >

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
                               <input id="valor" type="text" class="form-control" name="valor" readonly
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
                                <input id="percentual" type="text" class="form-control" name="percentual" readonly
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
                                <input id="desconto_valor" type="text" class="form-control" name="desconto_valor" readonly
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
                                <input id="desconto_percentual" type="text" class="form-control" name="desconto_percentual" readonly
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
                                <input type="checkbox" name="ativo" value="1" disabled 
                                           <?php echo ($beneficio->ativo) ? "checked" :""; ?> >
                            </div>
                        </div>  

                        <div class="painel-beneficiado">
                            
                            @if(!empty($beneficio->id))                        
                            <div style="border-top: #e4edf0 solid 1px" class="listasx">
                                
                                <label  style="text-align: center">Funcionários </label> <br>

                                @if(!empty($funcionarios))
                                    @foreach($funcionarios as $funcionario) 
                                    <div style="width: 100%; float: left"  >
                                            <div class="checkbox_sx">
                                                <input type="checkbox" name="inclusos[]" 
                                                       value="{{$funcionario->id}}" 
                                                       @if($funcionario->hasBeneficio($beneficio->id))
                                                            checked
                                                       @endif
                                                       >
                                            </div>
                                            
                                            <div class="checkbox_text">
                                                {{$funcionario->nome}}
                                            </div>                                        
                                        </div>
                                    <br>
                                    @endforeach
                                @endif

                            @endif
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
