@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">


            <div class="container">
                {{--mostrar un mensaje cuando se haya creado un video--}}
                @if(session('message'))
                    <div class="alert alert-success">
                        {{session('message')}}
                    </div>
                @endif()

            </div>

            @include('video.videosList')

        </div>


    </div>
@endsection
