@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="container">
            <div class="col-md-4">
                <h2>Busqueda: "{{$search}}"</h2>
            </div>    
            <div class="col-md-8">
                <form action="{{url('/buscar/'.$search)}}" class="col-md-4 pull-right" method="get">
                    <label for="filter">Ordenar</label>
                    <select name="filter" id="filter" class="form-control">
                        <option value="new">Más nuevo primero</option>
                        <option value="old">Más antiguos primero</option>
                        <option value="alfa">A-Z</option>
                    </select>
                    <input type="submit" value="Ordenar" class="btn-filter btn btn-primary">
                </form>
            </div> 
            <div class="clearfix"></div>   
            @include('video.videosList');
        </div>  
    </div>
</div>
@endsection
