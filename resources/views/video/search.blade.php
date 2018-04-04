@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row">


            <div class="container">
                <div class="col-md-4">
                    <h2>Busqueda: {{$search}}</h2>
                </div>
                <div class="col-md-8">
                    <form class="col-md-3 pull-right" action="{{url('/buscar/' .  $search)}}">

                        <label for="filter">Ordenar</label>

                        <select name="filter" class="form-control" id="">
                            <option value="new">Mas nuevo primero</option>
                            <option value="old">Mas antiguo primero</option>
                            <option value="alfa">De la A a la Z</option>
                        </select>

                        <input type="submit" value="Ordenar" class="btn-filter btn btn-sm btn-primary"/>

                    </form>

                </div>
                <div class="clearfix"></div>
                @include('video.videosList')
            </div>


        </div>
    </div>
@endsection

