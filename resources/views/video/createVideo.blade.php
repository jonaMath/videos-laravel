@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <h2>Crear video</h2>
            <form action="{{ route('saveVideo') }}" method="post" enctype="multipart/form-data" class="col-lg-7">
                {!! csrf_field() !!}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                    <label for="title">Titulo</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{old('title')}}">
                </div>
                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea name="description" id="description" class="form-control" >{{old('description')}}</textarea>
                </div>  
                <div class="form-group">
                    <label for="image">Miniatura</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>  
                <div class="form-group">
                    <label for="video">Video</label>
                    <input type="file" name="video" id="video" class="form-control">
                </div>   
                <button type="submit" class="btn btn-success">Crear Video</button>         
            </form>
        </div>
    </div>
@endsection