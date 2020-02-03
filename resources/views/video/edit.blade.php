@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">   
            <h2>Editar el {{$video->title}}</h2>
            <form action="{{ route('updateVideo', ['video_id' => $video->id]) }}" method="post" enctype="multipart/form-data" class="col-lg-7">
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
                    <input type="text" name="title" id="title" class="form-control" value="{{$video->title}}">
                </div>
                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea name="description" id="description" class="form-control" >{{$video->description}}</textarea>
                </div>  
                <div class="form-group">
                    <label for="image">Miniatura</label>
                    @if(Storage::disk('images')->has($video->image))
                    <div class="video-image-thumb">
                        <div class="video-image-mask">
                            <img src="{{url('/miniatura/'.$video->image)}}" alt="" class="video-image">
                        </div>
                    </div>   
                    @endif    
                    <input type="file" name="image" id="image" class="form-control">
                </div>  
                <div class="form-group">
                    
                    <label for="video">Video</label>
                    <video  controls id="video-player">
                        <source src="{{route('fileVideo',['filename'=>$video->video_path])}}"></source>
                        Tu navegador no es compatible con html5
                    </video>
                    <input type="file" name="video" id="video" class="form-control">
                </div>   
                <button type="submit" class="btn btn-success">Guardar cambios</button>         
            </form>
        </div>
    </div>
@endsection