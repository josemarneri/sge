@extends('layouts.master')

@section('content')
<div class="area-trabalho">
    <script language="JavaScript" src="{{url('js/neri.js')}}"></script>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar Desenho</div>
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
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/plm/desenhos/salvar') }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="id" name="id" value="{{$desenho->id}}"/>

                               
                        <div class="form-group{{ $errors->has('numero') ? ' has-error' : '' }}">
                            <label for="numero" class="col-md-4 control-label">Número</label>

                            <div class="col-md-6">
                                <input id="numero" type="text" readonly="true" class="form-control" name="numero" 
                                       value="{{ $desenho->numero ? $desenho->numero : old('numero') }}" required>

                                @if ($errors->has('numero'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('numero') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('alias') ? ' has-error' : '' }}">
                            <label for="alias" class="col-md-4 control-label">Alias</label>

                            <div class="col-md-6">
                                <input id="alias" type="text" class="form-control" name="alias" value="{{ $desenho->alias ?  $desenho->alias : old('alias') }}" >

                                @if ($errors->has('alias'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('alias') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
            
                        <div class="form-group{{ $errors->has('descricao') ? ' has-error' : '' }}">
                            <label for="descricao" class="col-md-4 control-label">Descrição</label>

                            <div class="col-md-6">
                                <input id="descricao" type="text" class="form-control" name="descricao" value="{{ $desenho->descricao ?  $desenho->descricao : old('descricao') }}" >

                                @if ($errors->has('descricao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descricao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('material') ? ' has-error' : '' }}">
                            <label for="material" class="col-md-4 control-label">Material</label>

                            <div class="col-md-6">
                                <input id="material" type="material" class="form-control" name="material" value="{{ $desenho->material ? $desenho->material : old('material') }}" >

                                @if ($errors->has('material'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('material') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>  
                        
                        <div class="form-group{{ $errors->has('peso') ? ' has-error' : '' }}">
                            <label for="peso" class="col-md-4 control-label">Peso</label>

                            <div class="col-md-6">
                                <input id="peso" type="text" class="form-control" name="peso" value="{{ $desenho->peso ? $desenho->peso : old('peso') }}" >

                                @if ($errors->has('peso'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('peso') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('tratamento') ? ' has-error' : '' }}">
                            <label for="tratamento" class="col-md-4 control-label">Tratamento</label>

                            <div class="col-md-6">
                                <input id="peso" type="text" class="form-control" name="tratamento" value="{{ $desenho->tratamento ? $desenho->tratamento : old('tratamento') }}" >

                                @if ($errors->has('tratamento'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('tratamento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('observacoes') ? ' has-error' : '' }}">
                            <label for="observacoes" class="col-md-4 control-label">Observações</label>

                            <div class="col-md-6">
                                <input id="peso" type="text" class="form-control" name="observacoes" value="{{ $desenho->observacoes ? $desenho->observacoes : old('observacoes') }}" >

                                @if ($errors->has('observacoes'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('observacoes') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('projeto_id') ? ' has-error' : '' }}">
                            <label for="projeto_id" class="col-md-4 control-label">Projeto</label>

                            <div class="col-md-6">
                                <select id="projeto_id" name="projeto_id" >
                                    @foreach($projetos as $projeto)
                                        @if(!empty($projeto))
                                        <option <?php echo ($desenho->projeto_id == $projeto->id) ? "selected" :""; ?> 
                                            value="{{$projeto->id}}" onchange="enableSalvar(document.form1.projeto_id, document.form1.btnSalvar)">
                                            {{$projeto->codigo}}</option>
                                        
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @foreach($pais as $p)
                            @if(!empty($p))
                                <div id="novopai" class="form-group{{ $errors->has('pai') ? ' has-error' : '' }}">
                                    <label for="pai" class="col-md-4 control-label">Pai</label>

                                    <div class="col-md-6">
                                        <input id="pai" type="text" class="form-control" name="pai[]"
                                               value="{{ $desenho->getNumeroById($p->pai_id) }}" >

                                        @if ($errors->has('pai'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('pai') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        <img  src="{{url('/assets/imagens/add.png')}}" style="cursor: pointer;" onclick="duplicarCampos('novopai','addpai','input');">
                                        <img  src="{{url('/assets/imagens/delete.png')}}" style="cursor: pointer;" onclick="removerCampos('addpai');">
                                    </div>  
                                </div>
                            @endif
                        @endforeach
                        <div id="novopai" class="form-group{{ $errors->has('pai') ? ' has-error' : '' }}">
                            <label for="pai" class="col-md-4 control-label">Pai</label>

                            <div class="col-md-6">
                                <input id="pai" type="text" class="form-control" name="pai[]"
                                       value="{{old('pai') }}" >

                                @if ($errors->has('pai'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pai') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div>
                                <img  src="{{url('/assets/imagens/add.png')}}" style="cursor: pointer;" onclick="duplicarCampos('novopai','addpai','input');">
                                <img  src="{{url('/assets/imagens/delete.png')}}" style="cursor: pointer;" onclick="removerCampos('addpai');">
                            </div>
                        </div>
                        <div id="addpai">
                        </div>
                        
                        @foreach($filhos as $f)
                            @if(!empty($f))
                                <div id="novofilho" class="form-group{{ $errors->has('filho') ? ' has-error' : '' }}">
                                    <label for="filho" class="col-md-4 control-label">Filho</label>

                                    <div class="col-md-6">
                                        <input id="filho" type="text" class="form-control" name="filho[]"
                                               value="{{ $desenho->getNumeroById($f->filho_id) }}" >

                                        @if ($errors->has('filho'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('filho') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        <img  src="{{url('/assets/imagens/add.png')}}" style="cursor: pointer;" onclick="duplicarCampos('novofilho','addfilho','input');">
                                        <img  src="{{url('/assets/imagens/delete.png')}}" style="cursor: pointer;" onclick="removerCampos('addfilho');">
                                    </div>
                                </div>
                            
                            @endif
                        @endforeach
                        <div id="novofilho" class="form-group{{ $errors->has('filho') ? ' has-error' : '' }}">
                            <label for="filho" class="col-md-4 control-label">Filho</label>

                            <div class="col-md-6">
                                <input id="filho" type="text" class="form-control" name="filho[]"
                                       value="{{old('filho') }}" >

                                @if ($errors->has('filho'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('filho') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div>
                                <img  src="{{url('/assets/imagens/add.png')}}" style="cursor: pointer;" onclick="duplicarCampos('novofilho','addfilho','input');">
                                <img  src="{{url('/assets/imagens/delete.png')}}" style="cursor: pointer;" onclick="removerCampos('addfilho');">
                            </div>
                        </div>
                        <div id="addfilho">
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Salvar
                                </button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    
                     <div >                        
                         <a href="{{url("/plm/desenhos/novo/importarplanilha")}}" title="Importar planilha de criação de desenhos">
                            <img src="{{url('/assets/imagens/ArrowUpload2.png')}}" alt="Importar planilha de criação de desenhos" />
                             Importar planilha de criação de desenhos
                        </a>
                    </div>
                    <br/>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
