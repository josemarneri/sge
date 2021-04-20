@extends('layouts.master')

@section('content')
<div class="area-trabalho">
    <div class = "wrapper">        
              
        <div class="title-2 wrapperL" >
            Lista de pagamentos        
        </div>

            <form class="wrapperR" role="form" method="POST" action="{{ url('/financeiro/pagamentos/filtrar') }}">
                        {{ csrf_field() }}
                
                     
                
                <div class="box">
                    <div class="form-group{{ $errors->has('filtrodespesa_id') ? ' has-error' : '' }}">
                        <label for="filtrodespesa_id" class="col-md-4 control-label">Despesa</label>

                        <div class="col-md-6">
                                <select id="filtrodespesa_id" name="filtrodespesa_id" style="width: 130px">
                                    <option value="" > </option>
                                    @foreach($despesas as $despesa)
                                        @if(!empty($despesa))
                                        
                                        <option <?php echo ($pagamento->despesa_id == $despesa->id) ? "selected" :""; ?> 
                                            value="{{$despesa->id}}" >
                                            {{$despesa->nome}}</option>
                                        
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                    </div>       
                </div>
                
                <div class="box">
                    <div class="form-group{{ $errors->has('filtrodata_inicial') ? ' has-error' : '' }}">
                        <label for="filtrodata_inicial" class="col-md-4 control-label">Data Inicial</label>

                        <div class="col-md-6">
                            <input id="filtrodata_inicial" type="date" class="input-group-text" name="filtrodata_inicial"  >

                            @if ($errors->has('filtrodata_inicial'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('filtrodata_inicial') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>       
                </div>  
                <div class="box">
                    <div class="form-group{{ $errors->has('filtrodata_final') ? ' has-error' : '' }}">
                        <label for="filtrodata_final" class="col-md-4 control-label">Data Final</label>

                        <div class="col-md-6">
                            <input id="filtrodata_final" type="date" class="input-group-text" name="filtrodata_final"  >

                            @if ($errors->has('filtrodata_final'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('filtrodata_final') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>       
                </div> 
                <div class="box">
                    <div class="form-group{{ $errors->has('filtrocomessa_id') ? ' has-error' : '' }}">
                        <label for="filtrocomessa_id" class="col-md-5 control-label">Comessa</label>

                        <div class=" offset-1 col-md-6">
                                <select id="filtrocomessa_id" name="filtrocomessa_id" style="width: 130px">
                                    <option value="" > </option>
                                    @foreach($comessas as $comessa)
                                        @if(!empty($comessa))
                                        
                                        <option <?php echo ($pagamento->comessa_id == $comessa->id) ? "selected" :""; ?> 
                                            value="{{$comessa->id}}" >
                                            {{$comessa->nome}}</option>
                                        
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                    </div>       
                </div>
                <div class="box">
                    <div class="form-group{{ $errors->has('filtrofuncionario_id') ? ' has-error' : '' }}">
                        <label for="filtrofuncionario_id" class="col-md-5 control-label">Funcionário</label>

                        <div class=" offset-1 col-md-6">
                                <select id="filtrofuncionario_id" name="filtrofuncionario_id" style="width: 130px">
                                    <option value="" > </option>
                                    @foreach($funcionarios as $funcionario)
                                        @if(!empty($funcionario))
                                        
                                        <option <?php echo ($pagamento->funcionario_id == $funcionario->id) ? "selected" :""; ?> 
                                            value="{{$funcionario->id}}" >
                                            {{$funcionario->nome}}</option>
                                        
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                    </div>       
                </div>
                <div class="box">
                    <div class="form-group{{ $errors->has('filtroobs') ? ' has-error' : '' }}">
                        <label for="filtroobs" class="col-md-6 ">Observações</label>

                        <div class="col-md-5 offset-1">
                            <input id="filtroobs" type="text" class="input-group-text" name="filtroobs"  >

                            @if ($errors->has('filtroobs'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('filtroobs') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>       
                </div>  
                

                
                <div class="box">
                    <div class="col-md-4 offset-1">  
                        
                        <a {{ !empty($hasPlanilha) ? ' ' : 'hidden' }} href="{{url("/financeiro/pagamentos/baixarplanilha")}}" title="Baixar Lista" >
                            <img src="{{url('/assets/imagens/ArrowDown.png')}}" alt="Importar planilha de criação de pagamentos" />

                        </a>
                    </div>
                    <div class="col-md-6 offset-1">
                        <button type="submit" class="btn btn-primary" >
                            Filtrar
                        </button> 
                    </div>
                    

                </div>
                   
                        
            </form>
        </div>    
        
    
    <table class="table table-hover table-condensed" >
        <thead>
        <a href="{{url("/financeiro/pagamentos/novo")}}" title="Cadastrar Pagamento"> 
            <img src="{{url('/assets/imagens/Add.png')}}" alt="Cadastrar Pagamento de despesas" /> 
        </a>

        @if( $pag)
            <div style="float: right">
                {{ $pagamentos->links() }}
            </div>
            
        @endif
            <tr>
<!--                <th style="text-align: center">Id</th>-->
                <th style="text-align: center">Despesa</th>
                <th style="text-align: center">Funcionário</th>                
                <th style="text-align: center">Valor do <br> Pagamento</th>
                <th style="text-align: center">Data do <br> Pagamento</th>
                <th style="text-align: center">Observações</th>
                <th width="100" style="text-align: center">Anexos </th>
                <th width="100" style="text-align: center">Ações</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($pagamentos))
                @forelse($pagamentos as $paym)               
                <tr>
<!--                    <td style="text-align: center">{{$pagamento->id}}</td>-->
                    <td style="text-align: center">{{$pagamento->getNomeDespesa($paym->despesa_id)}}</td>
                    <td style="text-align: center">{{$paym->funcionario_id}}</td>                    
                    <td style="text-align: center">{{$paym->valor_pago}}</td>
                    <td style="text-align: center">{{$paym->data_pagamento}}</td>
                    <td >{{$paym->obs}}</td>
                    <td style="text-align: right">
                    <?php
                        $i=1;
                        echo "[ ";
                        foreach($pagamento->getAnexos($paym->id) as $anexo){
                            echo "<a href=\"".url("/arquivos/baixar/".$anexo->id)."\" title=$anexo->nomearquivo>";
                               echo "$i </a>";
                               $i++;
                        }
                        echo " ]";
                    ?>
                    <a href="{{url("arquivos/anexar/pagamentos/".$paym->id)}}" title="Adicionar anexo">
                        <img src="{{url('/assets/imagens/Add.png')}}" alt="Adicionar anexo" />
                    </a>
                </td>
                    <td style="text-align: center">
                        <a href="{{url("/financeiro/pagamentos/atualizar/$paym->id")}}" title="alterar dados do pagamento">
                            <img src="{{url('/assets/imagens/Edit.png')}}" alt="alterar dados do pagamento" /> 
                        </a>
                        <a href="{{url("/financeiro/pagamentos/apagar/$paym->id")}}" title="Remover pagamento">
                            <img src="{{url('/assets/imagens/Delete.png')}}" alt="Remover pagamento" />
                        </a>
                    </td>
                </tr>
                @empty
                    <p> Nenhum pagamento cadastrado!!!</p>
                @endforelse
                
            @endif
        </tbody>
        
    </table>
    @if(  $pag)
        <div style="float: right">
            {{ $pagamentos->links() }}
        </div>
    @endif
    
</div>
@endsection


