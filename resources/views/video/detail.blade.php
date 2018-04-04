@extends('layouts.app')

@section('content')

    <div class="col-md-10 col-md-offset-2">
        <h2>{{$video->title}}</h2>
        <hr>

        <div class="col-md-8">
            {{--video--}}

            <video controls id="video-player">
                <source src="{{url('/video-file/' . $video->video_path)}}"></source>
                Tu navegador no es compatible con html5
            </video>
            {{--description--}}

            <div class="panel panel-default video-data">
                <div class="panel-heading">
                    <div class="panel-title">
                        Subido por <strong><a href=" {{url('/canal/' . $video->user->id)}}">{{$video->user->name . '  ' . $video->user->surname}}</a></strong>
                        hace {{ \FormatTime::LongTimeFilter($video->created_at) }}
                    </div>

                </div>
                <div class="panel-body">
                    {{$video->description}}
                </div>

            </div>
            {{--comentarios--}}

            @include('video.comments')

        </div>

    </div>

@endsection()