@extends('layouts.master')

@section('content')

<div class="area-util"> 

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Lamento, <b>{{auth()->user()->name }}!</b>
                    <br>você não tem acesso a esta função. </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
