<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use App\Video;
use App\Comment;

class VideoController extends Controller
{
    public function createVideo(){
        return view('video.createVideo');
    }

    public function saveVideo(Request $request){
        //validate form
        $validatedData = $this->validate($request, [
            'title'=> 'required|min:5',
            'description' => 'required',
            'video' => 'mimes:mp4,avi'
        ]); 
        //return view('video.createVideo');

        $video = new Video();
        $user = \Auth::user();
        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');
        
        //subir miniatura
        $image = $request->file('image');
        if($image){
            $image_path = time().$image->getClientOriginalName();
            \Storage::disk('images')->put($image_path, \File::get($image));
            $video->image = $image_path;
        }

        //subir video
        $video_file = $request->file('video');
        if($video_file){
            $video_path = time().$video_file->getClientOriginalName();
            \Storage::disk('videos')->put($video_path, \File::get($video_file));
            $video->video_path = $video_path;
        }
        
        $video->save();

        return redirect()->route('home')->with(array(
            "message" => 'El video se ha subido correctamente'
        ));
    }

    public function getImage($filename){
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }

    public function getVideoDetail($video_id){
        $video = Video::find($video_id);
        return view('video.detail', array(
            'video'=> $video 
        ));
    }

    public function getVideo($filename){
        $file = Storage::disk('videos')->get($filename);
        return new Response($file, 200);
    }

    public function delete($video_id){
        $user = \Auth::user();
        $video = Video::find($video_id);
        $comments = Comment::where('video_id', $video_id)->get();
        if($user && $video->user_id ==$user->id){
            //Eliminar comentarios
            if($comments && count($comments)>=1){
                foreach($comments as $comment){
                    $comment->delete();
                }
            }
            //eliminar ficheros
            Storage::disk('images')->delete($video->image);
            Storage::disk('videos')->delete($video->video_path);
            
            //eliminar registro
            $video->delete();
            $message = array(
                'message' => 'Video Eliminado Correctamente'
            );
        }else{
            $message = array(
                'message' => 'El video no se ha eliminado'
            );
        }

        return redirect()->route('home')->with($message);
    }

    public function edit($video_id){
        $user = \Auth::user();
        $video = Video::findOrFail($video_id);
        
        if($user && $video->user_id ==$user->id){
            return view('video.edit', array(
                'video'=> $video
            ));
        }else{
            return redirect()->route('home');
        }
    }
    
    public function update($video_id, Request $request){
        $validatedData = $this->validate($request, [
            'title'=> 'required|min:5',
            'description' => 'required',
            'video' => 'mimes:mp4,avi'
        ]);
        $user = \Auth::user();
        $video = Video::findOrFail($video_id);
        $comments = Comment::where('video_id', $video_id)->get();
        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');
        
        //subir miniatura
        $image = $request->file('image');
        if($image){
            Storage::disk('images')->delete($video->image);
            $image_path = time().$image->getClientOriginalName();
            \Storage::disk('images')->put($image_path, \File::get($image));
            $video->image = $image_path;
        }
        
        //subir video
        $video_file = $request->file('video');
        if($video_file){
            Storage::disk('videos')->delete($video->video_path);
            $video_path = time().$video_file->getClientOriginalName();
            \Storage::disk('videos')->put($video_path, \File::get($video_file));
            $video->video_path = $video_path;
        }
        
        $video->update();

        return redirect()->route('home')->with(array(
            'message'=>'el video se ha actualizado correctamente'
        ));

    }

    public function search($search = null,$filter = null ){
        if(is_null($search)){
            //recogemos lo que traiga la caja de la busqueda
            $search = \Request::get('search');
            if(is_null($search)){
                return redirect()->route('home');
            }
            //redireccionamos correctamente
            return redirect()->route('videoSearch', array(
                'search'=>$search
            ));
        }
        if(is_null($filter)&& \Request::get('filter') && !is_null($search)){
            //recogemos lo que traiga la caja de la busqueda
            $filter = \Request::get('filter');
            //redireccionamos correctamente
            return redirect()->route('videoSearch', array(
                'search'=>$search,
                'filter'=>$filter
            ));
        }

        $column = 'id';
        $order = 'desc';
        if(!is_null($filter)){
            if($filter=='new'){
                $column = 'id';
                $order = 'desc';
            }
            if($filter=='old'){ 
                $column = 'id';
                $order = 'asc';
            }
            if($filter=='alfa'){
                $column = 'title';
                $order = 'asc';
            }

        }
        
        $videos = Video::where('title', 'LIKE', '%'.$search.'%')->orderBy($column,$order)->paginate(5);
        
        return view('video.search', array(
            'videos'=> $videos,
            'search' => $search
        ));
    }
}
