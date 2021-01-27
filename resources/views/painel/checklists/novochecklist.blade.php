@extends('layouts.master')

@section('content')

<div class="area-util"> 
    <script language="JavaScript" src="{{url('js/neri.js')}}"></script>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar checklist</div>
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
                    <form name="form1" class="form-horizontal" role="form" method="POST" 
                          action="{{ url('/painel/checklists/salvar') }}">
                        {{ csrf_field() }}
           
                        
                        <input type="hidden" id="id" name="id" value="{{$checklist->id}}"/>
                        
                        <div class="form-group{{ $errors->has('nome') ? ' has-error' : '' }}">
                            <label for="nome" class="col-md-4 control-label">Nome</label>

                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control" name="nome" 
                                       value="{{ $checklist->nome ? $checklist->nome : old('nome') }}" 
                                       maxlength="20" required>

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
                                       value="{{ $checklist->descricao ? $checklist->descricao : old('descricao') }}" 
                                        required>

                                @if ($errors->has('descricao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descricao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>  
 
                        <div id="newquestion" class="form-group{{ $errors->has('perguntasnovas') ? ' has-error' : '' }}">
                            <label for="perguntasnovas" class="col-md-4 control-label">Pergunta</label>

                            <div class="col-md-6">
                                <input id="perguntasnovas" type="text" class="form-control" name="perguntasnovas[]"
                                       value="{{old('perguntasnovas') }}" >

                                @if ($errors->has('perguntasnovas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('perguntasnovas') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div>
                                <img  src="{{url('/assets/imagens/add.png')}}" style="cursor: pointer;" onclick="duplicarCampos('newquestion','addquestion','input');">
                                <img  src="{{url('/assets/imagens/delete.png')}}" style="cursor: pointer;" onclick="removerCampos('addquestion');">
                            </div>
                        </div>
                        <div id="addquestion">
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button name="btnSalvar" type="submit" 
                                        class="btn btn-primary" >
                                    Salvar
                                </button>
                            </div>
                        </div>
                        
                        <div class="painel-carga">  
                            <div style="border-top: #e4edf0 solid 1px" class="perguntas">                              
              
                            @if(!empty($checklist->id))                        
                            <div style="border-top: #e4edf0 solid 1px" class="perguntas">
                                @if(!empty($perguntas))
                                    <div  >
                                        <label for="" class=" control-label">Perguntas</label>
                                    </div>
                                    @foreach($perguntas as $pergunta)
                                        <div  >
                                            <label for="" class=" control-label">{{$pergunta->id}} : {{$pergunta->descricao}}</label>
                                            <a href="javascript:func()" title="Alterar checklist"
                                                onclick="confirmacao('/painel/checklists/apagarpergunta/','{{$pergunta->id}}')">
                                                <img src="{{url('/assets/imagens/delete.png')}}" alt="Alterar checklist" /> 
                                            </a>
                                        </div> 
                                    @endforeach 
                                @endif
                                <br>                                

                            </div>
                            @endif
                        </div>                      
                    </form>
                 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
