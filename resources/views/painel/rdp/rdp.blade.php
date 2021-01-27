@extends('layouts.master')

@section('content')

<div class="container">

    <div >
        <form action="/rdp/exceltodb" method="post" enctype="multipart/form-data">
            
            <input type="file" name="filefield" ><br/>
            <button type="submit" class="btn btn-primary">
                Carregar Arquivo
            </button>
            {{ csrf_field() }}
        </form>
    </div>
    
    
</div>
@endsection


