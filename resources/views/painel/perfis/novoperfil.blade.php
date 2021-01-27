@extends('layouts.master')

@section('content')
<div class="area-util">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cadastrar Perfil de acesso</div>
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
                    <form class="form-horizontal" perfil="form" method="POST" action="{{ url('/painel/perfis/salvar') }}">
                        {{ csrf_field() }}
                        <input type="hidden" id="id" name="id" value="{{$perfil->id}}"/>

                               
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nome</label>

                            <div class="col-md-6">
                                <input id="nome" type="text" class="form-control" name="name" value="{{ $perfil->name ? $perfil->name : old('name') }}" required>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('label') ? ' has-error' : '' }}">
                            <label for="label" class="col-md-4 control-label">Descrição</label>

                            <div class="col-md-6">
                                <input id="label" type="text" class="form-control" name="label" value="{{ $perfil->label ?  $perfil->label : old('label') }}" >

                                @if ($errors->has('label'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('label') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if(!empty($perfil->id))                        
                        <div style="border-top: #e4edf0 solid 1px">
                            @for($i=0;$i<count($permissoes); $i++)                            
                                <div class="col-md-{{($i%2)? 3:5}}" >
                                    <input type="checkbox" name="permissoes[]" value="{{$permissoes[$i]->id}}"
                                           <?php echo ($permissoes[$i]->isInRole($perfil->id)) ? "checked" :""; ?> >{{$permissoes[$i]->label}}
                                </div>
                                @if($i%2 == 1)
                                    <br>                                    
                                @endif 
                            @endfor
                            
                        </div>
                        @endif

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
