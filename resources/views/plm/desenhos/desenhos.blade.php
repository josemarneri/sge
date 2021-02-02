@extends('layouts.master')

@section('content')
<div class="area-util">
    <div class = "wrapper">        
              
        <div class="title-2 wrapperL" >
            Lista de desenhos        
        </div>

            <form class="wrapperR" role="form" method="POST" action="{{ url('/plm/desenhos/filtrar') }}">
                        {{ csrf_field() }}
                <div class="box">
                    <div class="form-group{{ $errors->has('filtronumero') ? ' has-error' : '' }}">
                        <label for="filtronumero" class="col-md-4 control-label">Número</label>

                        <div class="col-md-6">
                            <input id="filtronumero" type="text" class="form-control" name="filtronumero"  >

                            @if ($errors->has('filtronumero'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('filtronumero') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>       
                </div>
                <div class="box">
                    <div class="form-group{{ $errors->has('filtrodescricao') ? ' has-error' : '' }}">
                        <label for="filtrodescricao" class="col-md-4 control-label">Descrição</label>

                        <div class="col-md-6">
                            <input id="filtrodescricao" type="text" class="form-control" name="filtrodescricao"  >

                            @if ($errors->has('filtrodescricao'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('filtrodescricao') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>       
                </div>       
                <div class="box">
                    <div class="form-group{{ $errors->has('filtromaterial') ? ' has-error' : '' }}">
                        <label for="filtromaterial" class="col-md-4 control-label">Material</label>

                        <div class="col-md-6">
                            <input id="filtromaterial" type="text" class="form-control" name="filtromaterial"  >

                            @if ($errors->has('filtromaterial'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('filtromaterial') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>       
                </div>
                <div class="box">
                    <div class="form-group{{ $errors->has('filtroprojeto_id') ? ' has-error' : '' }}">
                        <label for="filtroprojeto_id" class="col-md-4 control-label">Projeto</label>

                        <div class="col-md-6">
                                <select id="filtroprojeto_id" name="filtroprojeto_id" >
                                    <option value="" > </option>
                                    @foreach($projetos as $projeto)
                                        @if(!empty($projeto))
                                        
                                        <option <?php echo ($desenho->projeto_id == $projeto->id) ? "selected" :""; ?> 
                                            value="{{$projeto->id}}" >
                                            {{$projeto->codigo}}</option>
                                        
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                    </div>       
                </div>
                <div class="box">
                    <div class="form-group{{ $errors->has('filtropai') ? ' has-error' : '' }}">
                        <label for="filtropai" class="col-md-4 control-label">Nº Pai</label>

                        <div class="col-md-6">
                            <input id="filtropai" type="text" class="form-control" name="filtropai"  >

                            @if ($errors->has('filtropai'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('filtropai') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>       
                </div>
                <div class="box">
                    <div class="form-group{{ $errors->has('filtrofilho') ? ' has-error' : '' }}">
                        <label for="filtrofilho" class="col-md-4 control-label">Nº Filho</label>

                        <div class="col-md-6">
                            <input id="filtrofilho" type="text" class="form-control" name="filtrofilho"  >

                            @if ($errors->has('filtrofilho'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('filtrofilho') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>       
                </div>
                        
                        
                <div class="box">
                    <div class="form-group{{ $errors->has('filtroalias') ? ' has-error' : '' }}">
                        <label for="filtroalias" class="col-md-4 control-label">Alias</label>

                        <div class="col-md-6">
                            <input id="filtroalias" type="text" class="form-control" name="filtroalias"  >

                            @if ($errors->has('filtroalias'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('filtroalias') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>       
                </div>
                

                
                <div class="box">
                    <div class="col-md-4">  
                        
                        <a {{ $hasPlanilha ? ' ' : 'hidden' }} href="{{url("/plm/desenhos/baixarplanilha")}}" title="Baixar Lista" >
                            <img src="{{url('/assets/imagens/ArrowDown.png')}}" alt="Importar planilha de criação de desenhos" />

                        </a>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary" >
                            Filtrar
                        </button> 
                    </div>
                    

                </div>
                   
                        
            </form>
        </div>    
        
    
    
    <table class="table table-hover table-condensed" >
        <thead>
        <a href="{{url("/plm/desenhos/novo")}}" title="Criar Desenho">
                <img src="{{url('/assets/imagens/Add.png')}}" alt="Criar Desenho" />
            </a>
            <tr>
<!--                <th style="text-align: center">Id</th>-->
                <th style="text-align: center">Numero</th>
                <th style="text-align: center">Alias</th>
                <th style="text-align: center">Descrição</th>
                <th style="text-align: center">Material</th>
                <th style="text-align: center">Peso</th>
                <th style="text-align: center">Projeto</th>
                <th width="100" style="text-align: center">Anexos </th>
                <th width="100" style="text-align: center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($desenhos))
                @forelse($desenhos as $desenho)               
                <tr>
<!--                    <td style="text-align: center">{{$desenho->id}}</td>-->
                    <td style="text-align: center">{{$desenho->numero}}</td>
                    <td style="text-align: center">{{$desenho->alias}}</td>
                    <td >{{$desenho->descricao}}</td>
                    <td style="text-align: center">{{$desenho->material}}</td>
                    <td style="text-align: center">{{$desenho->peso}}</td>
                    <td style="text-align: center">{{$desenho->getCodigoProjeto($desenho->projeto_id)}}</td>
                    <td style="text-align: right">
                    <?php
                        $i=1;
                        echo "[ ";
                        foreach($desenho->getAnexos($desenho->id) as $anexo){
                            echo "<a href=\"".url("/arquivos/baixar/".$anexo->id)."\" title=$anexo->nomearquivo>";
                               echo "$i </a>";
                               $i++;
                        }
                        echo " ]";
                    ?>
                    <a href="{{url("arquivos/anexar/desenhos/".$desenho->id)}}" title="Adicionar anexo">
                        <img src="{{url('/assets/imagens/Add.png')}}" alt="Adicionar anexo" />
                    </a>
                </td>
                    <td style="text-align: center">
                        <a href="{{url("/plm/desenhos/atualizar/$desenho->id")}}" title="alterar dados do desenho">
                            <img src="{{url('/assets/imagens/Edit.png')}}" alt="alterar dados do desenho" /> 
                        </a>
                        <a href="{{url("/plm/desenhos/apagar/$desenho->id")}}" title="Remover desenho">
                            <img src="{{url('/assets/imagens/Delete.png')}}" alt="Remover desenho" />
                        </a>
                    </td>
                </tr>
                @empty
                    <p> Nenhum desenho cadastrado!!!</p>
                @endforelse
            @endif
        </tbody>
        
    </table>
    
    
</div>
@endsection


