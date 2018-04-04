<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;


use App\Video;
use App\Comment;

class VideoController extends Controller
{
    public function createVideo()
    {
        return view('video.createVideo');
    }

    public function saveVideo(Request $request)
    {
        //validar form
        $validateData = $this->validate($request, [
            'title' => 'required|min:5',
            'description' => 'required',
            'video' => 'mimes:mp4'
        ]);


        $video = new Video();
        $user = \Auth::user();


        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');


        //Upload pic
        $image = $request->file('image');


        if ($image) {
            $image_path = time() . $image->getClientOriginalName();   //Asisnando el nombre el fichero(time(),
            //                                                      para que el nombre no sea igual a otro)
            Storage::disk('images')->put($image_path, File::get($image));
            $video->image = $image_path;
        }

        //SUbida del video

        $video_file = $request->file('video');

        if ($video_file) {
            $video_path = time() . $video_file->getClientOriginalName();
            Storage::disk('videos')->put($video_path, File::get($video_file));
            $video->video_path = $video_path;
        }


        $video->save();

        return redirect()->route('home')->with(array(
            'message' => 'El videos se ha subido correctamente!!'
        ));

    }

    public function getImage($filename)
    {

        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }


    public function getVideo($filename)
    {

        $file = Storage::disk('videos')->get($filename);
        return new Response($file, 200);
    }


    public function getVideoDetail($video_id)
    {

        $video = Video::find($video_id);
        return view('video.detail', array(
            'video' => $video
        ));
    }

    //Eliminar un video
    public function delete($video_id)
    {
        $user = \Auth::user();

        $video = Video::find($video_id);

        $comments = Comment::where('video_id', $video_id)->get();


        if ($user && $video->user_id == $user->id) {

            //Borrar comentarios
            if ($comments && count($comments) >= 1) {
                foreach ($comments as $comment) {
                    $comment->delete();
                }
            }


            //Eliminar fichero en disco fisico
            \Storage::disk('images')->delete($video->image);
            \Storage::disk('videos')->delete($video->video_path);

            //Eliminar video
            $video->delete();

            $mesage = array('message' => 'video eliminado correctamente!!');
        } else {
            $mesage = array('message' => 'video no ha sido eliminado!!');
        }


        return redirect()->route('home')->with($mesage);
    }


    public function edit($id)
    {

        $user = \Auth::user();
        $video = Video::findOrFail($id);


        if ($user && $video->user_id == $user->id) {


            return view('video.edit', array(
                'video' => $video,
            ));

        } else {
            return redirect('home');
        }


    }


    public function update($video_id, Request $request)
    {

        $validate = $this->validate($request, array(
            'title' => 'required|min:5',
            'description' => 'required',
            'video' => 'mimes:mp4'
        ));


        $video = Video::findOrFail($video_id);

        $user = \Auth::user();

        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');

        //Upload pic
        $image = $request->file('image');


        if ($image) {
            $image_path = time() . $image->getClientOriginalName();   //Asisnando el nombre el fichero(time(),
            //                                                      para que el nombre no sea igual a otro)
            \Storage::disk('images')->put($image_path, File::get($image));
            //Eliminar del disco el archivo antiguo
            \Storage::disk('images')->delete($video->image);
            $video->image = $image_path;
        }

        //Subida del video
        $video_file = $request->file('video');

        if ($video_file) {
            $video_path = time() . $video_file->getClientOriginalName();
            \Storage::disk('videos')->put($video_path, File::get($video_file));
            //Eliminar del disco el archivo antiguo
            \Storage::disk('videos')->delete($video->video_path);

            $video->video_path = $video_path;
        }


        $video->update();

        return redirect()->route('home')->with(array(
            'message' => 'el video ha sido actualizado correctamente'
        ));
    }

    public function search($search = null, $filter = null)
    {


        //Buscar video
        if (is_null($search)) {

            $search = \Request::get('search');

            if (is_null($search)){
                return redirect()->route('home');
            }
            
            return redirect()->route('videoSearch', array(
                'search' => $search
            ));
        }



        //ordenar video.
        if (is_null($filter) && \Request::get('filter') && !is_null($search)) {
            $filter = \Request::get('filter');

            return redirect()->route('videoSearch', array(
                'search' => $search,
                'filter' => $filter
            ));
        }


        $column = 'id';
        $order = 'desc';

        if (!is_null($filter)) {
            if ($filter == 'new') {
                $column = 'id';
                $order = 'desc';
            }
            if ($filter == 'old') {
                $column = 'id';
                $order = 'asc';
            }
            if ($filter == 'alfa') {
                $column = 'title';
                $order = 'asc';
            }

        }

        $videos = Video::where('title', 'LIKE', '%' . $search . '%')->orderBy($column, $order)->paginate(3);


        return view('video.search', array(
            'videos' => $videos,
            'search' => $search
        ));

    }
}
