@extends('financeiro.faturar.faturarhoras')

@section('lista')
<script language="JavaScript" src="{{url('js/neri.js')}}"></script>
<div class="area-trabalho-interna">
    <div class="title-2">
        Lista de lançamentos       
    </div>
    <form name="form2" class="form-horizontal" role="form" method="POST" 
                          action="{{ url('/financeiro/faturar/salvar') }}">
                        {{ csrf_field() }}
        <table class="table table-hover table-condensed " style="text-align: center">

            <thead> 
            <a href="{{url("/painel/diariosdebordo/novo")}}" title="Adicionar diariodebordo">
                <img src="{{url('/assets/imagens/Add.png')}}" alt="Adicionar diariodebordo" />
            </a>




                <tr>
                    <th style="text-align: center">Nome</th>
                    <th style="text-align: center">Data</th>
                    <th style="text-align: center">Comessa</th>
                    <th style="text-align: center">N.Horas Real</th>
                    <th style="text-align: center">N.Horas <br> Consultivadas</th>
                    <th style="text-align: center">Descrição</th>
                    <th style="text-align: center">Consultivado </th>
                    <th style="text-align: center; min-width: 100px">Faturar <br>
                        <input id="faturadoAll" type="checkbox" name="faturadoAll" 
                               onchange="marcarTodos(this,'faturado[]')"> Todos                                                    
                    </th>
                    <th style="text-align: center; width: 100px">Nº Nota Fiscal <br>
                        <input id="nfAll" type="checkbox" name="nfAll" 
                               title="Marque para repetir número da
1ª Nota Fiscal em todos os outros campos" 
                               onchange="preencherTodos(this,'nf[]')"> Todos</th>

                </tr>
            </thead>
            <tbody>
                @forelse($diariosdebordo as $ddbs)
                    @if (!empty($ddbs))
                        @foreach ($ddbs as $ddb)
                            <tr>                
                                <td  >{{$ddbordo->getFuncionarioById($ddb->funcionario_id)->nome}}</td>
                                <td >{{$ddb->data}}</td>
                                <td >{{$ddbordo->getComessaById($ddb->comessa_id)->codigo}}</td>
                                <td >{{$ddb->n_horas}}</td>
                                <td >{{ $ddb->n_horas_consultivadas}} </td>
                                <td style="text-align: left" >{{$ddb->descricao}}</td>

                                <td >
                                    <input id="consultivado" type="checkbox" name="consultivado[]"  value="{{$ddb->id}}" disabled
                                            {{ ($ddb->consultivado)? 'checked' : '' }}       >                                                    
                                            <input id="consultivado" type="hidden" name="consultivado[]"  value="{{$ddb->id}}" >
                                                                                               
                                </td>
                                <td >
                                    <input id="faturado" type="checkbox" name="faturado[]" 
                                           value="{{$ddb->id}}" {{ ($ddb->faturado)? 'checked' : '' }}       > 
                                </td>
                                <td >
                                    <input id="nf" type="text" name="nf[]"  style=" width: 100px"
                                           value="{{$ddb->nf}}"  {{ $ddb->nf }}> 
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @empty
                    <p> Nenhum Lançamento cadastrado!!!</p>
                @endforelse
            </tbody>
        </table>
        <div class="form-group" style="margin-top: 15px">
            <div class="col-md-6 col-md-offset-4">
                <button  name="btnSalvar" type="submit" 
                        class="btn btn-primary"  >
                    Salvar
                </button>
            </div>
        </div> 
    </form>
</div>
@endsection


