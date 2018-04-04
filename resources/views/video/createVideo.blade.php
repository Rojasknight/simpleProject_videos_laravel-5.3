@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row">
            <h2>Crear un Nuevo Video</h2>

            <hr>

            <form action="{{ route('saveVideo') }}" method="post" enctype="multipart/form-data" class="col-lg-7">


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
                    <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}">
                </div>

                <div class="form-group">
                    <label for="description">Descripción</label>

                    <textarea type="text" class="form-control" id="description"
                              name="description">{{old('title')}}</textarea>
                </div>

                <div class="form-group">
                    <label for="image">Miniatura</label>

                    <input type="file" class="form-control" id="image" name="image">
                </div>

                <div class="form-group">
                    <label for="video">Archivo de Video</label>

                    <input type="file" class="form-control" id="video" name="video">
                </div>

                <button type="submit" class="btn btn-success">
                    Crear Video
                </button>

            </form>
        </div>
    </div>


@endsection()