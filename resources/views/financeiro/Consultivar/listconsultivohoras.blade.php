@extends('financeiro.consultivar.consultivarhoras')

@section('lista')
<script language="JavaScript" src="{{url('js/neri.js')}}"></script>
<div class="area-trabalho">
    <div class="title-2">
        Lista de lançamentos       
    </div>
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
                <th style="text-align: center">N.Horas <br> Consultivar</th>
                <th style="text-align: center">Descrição</th>
                <th style="text-align: center; min-width: 200px">Consultivar <br>
                    <input id="consultivadoAll" type="checkbox" name="consultivadoAll" 
                           onchange="marcarTodos(this,'consultivado')" > Todos                                                    
                </th>
                <th style="text-align: center">Faturar <br>
                    <input id="faturadoAll" type="checkbox" name="faturadoAll" > Todos                                                    
                </th>

            </tr>
        </thead>
        <tbody>
            @forelse($diariosdebordo as $ddbs)
                @if (!empty($ddbs))
                    @foreach ($ddbs as $ddb)
                        <tr>                
                            <td >{{$ddb->funcionario_id}}</td>
                            <td >{{$ddb->data}}</td>
                            <td >{{$ddb->comessa_id}}</td>
                            <td >{{$ddb->n_horas}}</td>
                            <td >
                                <input id="n_horas" type="time"   name="n_horas" 
                                       value="{{ $ddb->n_horas_consultivadas ? $ddb->n_horas_consultivadas : $ddb->n_horas }}" 
                                       required >

                                @if ($errors->has('n_horas'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('n_horas') }}</strong>
                                    </span>
                                @endif
                            </td>
                            <td style="text-align: left" >{{$ddb->descricao}}</td>

                            <td >
                                <input id="consultivado" type="checkbox" name="consultivado[]"  value="{{$ddb->id}}" 
                                        {{ ($ddb->consultivado)? checked : '' }}       >                                                    
                            </td>
                            <td >
                                <input id="faturado" type="checkbox" name="faturado[]"  value="{{$ddb->id}}" 
                                        {{ ($ddb->faturado)? checked : '' }}       > 
                            </td>
                        </tr>
                    @endforeach
                @endif
            @empty
                <p> Nenhum Lançamento cadastrado!!!</p>
            @endforelse
        </tbody>
    </table>
    
</div>
@endsection


