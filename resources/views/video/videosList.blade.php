<div id="videos-list">
    @if(count($videos) >= 1)

        @foreach($videos as $video)
            <div class="video-item col-md-10 pull-left panel panel-default">

                <div class="panel-body">
                    {{--imagen del video--}}
                    @if(Storage::disk('images')->has($video->image))
                        <div class="video-image-thumb col-md-3 pull-left">
                            <div class="video-image-mask">
                                <img class="video-image" src="{{url('/miniatura/' . $video->image) }}"
                                     alt="">
                            </div>
                        </div>
                    @endif()


                    <div class="data">
                        <h4 class="video-title">
                            <a href="{{url('/video/' . $video->id )}}">
                                {{$video->title}}
                            </a>
                        </h4>
                        <p>{{$video->user->name . ' - ' . $video->user->surname}}</p>


                    </div>

                    {{--BOTONES DE ACCIÖN--}}
                    <a href="{{url('/video/' . $video->id )}}" class="btn btn-success">Ver</a>
                    {{--Verificar si el usuario esta logeado--}}
                    @if(Auth::check() && Auth::user()->id == $video->user->id)
                        <a href="{{url('/editar-video/' . $video->id)}}" class="btn btn-warning">Editar</a>
                        <!-- Botón en HTML (lanza el modal en Bootstrap) -->
                        <a href="#victorModal{{$video->id}}" role="button" class="btn btn-sm btn-primary"
                           data-toggle="modal">
                            Eliminar </a>

                        <!-- Modal / Ventana / Overlay en HTML -->
                        <div id="victorModal{{$video->id}}" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">
                                            &times;
                                        </button>
                                        <h4 class="modal-title">¿Estás seguro?</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Seguro que quieres borrar el videoo?</p>
                                        <p class="text-warning">
                                            <small>{{$video->title}}</small>
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                            Cancelar
                                        </button>
                                        <a href="{{url('/delete-video/' . $video->id)}}" type="button"
                                           class="btn btn-danger">Eliminar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif()


                </div>

            </div>
        @endforeach()
    @else
        <div class="alert alert-warning">
            no hay videos actualmente
        </div>
    @endif

    <div class="clearfix"></div>
    {{$videos->links()}}

</div>