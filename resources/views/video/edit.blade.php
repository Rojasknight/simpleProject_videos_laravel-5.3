@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <h2>Editar {{$video->title}}</h2>

            <hr>

            <form action="{{url('/update-video/' . $video->id)}}" method="post" enctype="multipart/form-data" class="col-lg-7">


                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach()
                        </ul>

                    </div>

                @endif()

                {{--Campo para evitar ataques csrf--}}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">


                <div class="form-group">
                    <label for="title">Titulo</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{$video->title}}">
                </div>

                <div class="form-group">
                    <label for="description">Descripción</label>

                    <textarea type="text" class="form-control" id="description"
                              name="description">{{$video->description}}</textarea>
                </div>

                <div class="form-group">
                    <label for="image">Miniatura</label>
                    {{--imagen del video--}}
                    @if(Storage::disk('images')->has($video->image))
                        <div class="video-image-thumb">
                            <div class="video-image-mask">
                                <img class="video-image" src="{{url('/miniatura/' . $video->image) }}" alt="">
                            </div>
                        </div>
                    @endif()

                    <input type="file" class="form-control" id="image" name="image">
                </div>

                <div class="form-group">

                    <label for="video">Archivo de Video</label>
                    {{--video a editar--}}

                    <video controls id="video-player">
                        <source src="{{url('/video-file/' . $video->video_path)}}"></source>
                        Tu navegador no es compatible con html5
                    </video>

                    <input type="file" class="form-control" id="video" name="video">
                </div>

                <button type="submit" class="btn btn-success">
                    Modificar Video
                </button>

            </form>
        </div>
    </div>


@endsection