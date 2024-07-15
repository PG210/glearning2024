
@extends('layouts.admin')

@section('titulos')
<section class="content-header">
    <ol class="breadcrumb">
    <li><a href="{{ url('/backdoor') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li><a href="{{ url('/reportcompletos') }}"><i class="fa fa-dashboard"></i> Retos Completos</a></li>
    <li class="active">Completos</li>
    </ol>
</section>
@endsection

@section('usuarios')

<style>
     .scrollable-table {
            width: 100%;
            max-height: 500px; /* Ajusta la altura máxima según tus necesidades */
            overflow-y: auto;
        }
</style>

<div class="box box-default" style="margin-top: 5%;">
    <div class="box-header with-border">
        <div class="box-tools pull-right">
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="text-right">
                    <a href="/reportcompletos"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Volver</a>
                </div>
                <h1>RETOS COMPLETOS</h1>
                <h3>Usuario: {{$usu->firstname}} {{$usu->lastname}}</h3>
                <input type="text" id="searchInput" placeholder="Buscar...">
                <br>
                <div class="box-body table-responsive scrollable-table">
                    <table class="table table-hover" id="dataTable">
                        <thead>
                        <tr>
                            <th><h4>Capítulo</h4></th>
                            <th><h4>Nombre de la Tarea</h4></th>
                            <th><h4>Tipo</h4></th>
                            <th><h4>Archivo</h4></th>
                            <th><h4>Evidencia</h4></th>
                            <th><h4>Estado</h4></th>
                            <th></th>
                            <!-- Agrega más columnas según tus necesidades -->
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($capitulos as $capituloKey => $tareasCapitulo)
                            <tr  style="background-color:#DEEAEC;">
                                <td colspan="4" style="font-size:16px;"><b>Capítulo {{ $capituloKey }}</b></td>
                                <td>
                                    <!--modal de comentario-->
                                    <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#comentario{{ $loop->iteration }}">
                                         Retroalimentación
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="comentario{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content" style="border-radius:20px;">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Agregar retroalimentación al capítulo {{ $capituloKey }} </h4>
                                            </div>
                                            <form action="{{route('saveCapitulo')}}" method="POST">
                                            @csrf()
                                            <div class="modal-body">
                                               <!--forms-->
                                                <div class="form-group">
                                                    <label class="control-label">Comentar:</label>
                                                    <textarea class="form-control" id="comenCapitulo" name="comenCapitulo" rows="5">@foreach($comentar as $com) @if($capituloKey == $com->capitulo_id){{$com->comentario}} @endif @endforeach </textarea>
                                                    <input value="{{ $capituloKey }}" id="idcap" name="idcap" hidden>
                                                    <input value="{{$user}}" id="usu" name="usu" hidden>
                                                </div>
                                               <!--end forms-->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-info">Guardar</button>
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">Salir</button>  
                                            </div>
                                            </form>
                                            </div>
                                        </div>
                                        </div>
                                    <!--end modal comentario-->
                                  
                                </td>
                               <!--aqui valida el estado de los capitulos-->
                                @foreach($comentar as $com) 
                                  @if($capituloKey == $com->capitulo_id)
                                   @if(!empty($com->comentario))
                                   <td><span style="background-color:#7FFFA0;">Revisado</span> </td>
                                    @else
                                    <td> <span style="background-color:#FFF93A;">Pendiente</span> </td>
                                   @endif 
                                  @endif 
                                @endforeach 
                                <!--end estado-->
                                <td></td>
                            </tr>
                            @foreach ($tareasCapitulo as $tarea)
                                <tr>
                                    <td></td>
                                    <td>{{ $tarea->name }}</td>
                                    <td>{{ $tarea->tipo }}</td>
                                    <td>
                                     @if($tarea->idtipo == 5)
                                      <a href="{{ asset('/storage/public/videos/' .$tarea->urlvideo) }}" target="_blank"><span class="glyphicon glyphicon-play" aria-hidden="true"></span> Ver </a>
                                     @elseif($tarea->idtipo == 7)
                                      <a href="{{ asset('/storage/public/' .$tarea->material) }}" target="_blank"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Leer </a>
                                     @endif
                                    </td>
                                    <!--lecturas-->
                                    @foreach ($lecturas as $lec)
                                     @if($lec->id_challenge == $tarea->challenge_id)
                                      <td>
                                        <!--aqui un modal-->
                                        <!-- Botón que activa el modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#lecturas{{$tarea->challenge_id}}">
                                            Retroalimentación
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="lecturas{{$tarea->challenge_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content" style="border-radius:20px;">
                                                    <div class="modal-header" style="border-radius:20px;">
                                                        <h4 class="modal-title" id="exampleModalLabel">Agregar retroalimentación:</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{route('comenLecturas')}}" method="post">
                                                     @csrf()
                                                    <div class="modal-body">
                                                       <!--contenido-->
                                                        <div class="form-group">
                                                            <label class="control-label"><h4>Respuesta:</h4></label>
                                                            <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$lec->respuesta}}</p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><h4>Comentario:</h4></label>
                                                            <textarea class="form-control" id="comlectura" name="comlectura">{{$lec->comentario}}</textarea>
                                                            <input value="{{$user}}" name="idusu" hidden>
                                                            <input value="{{$lec->idlectura}}" name="idlectura" hidden>
                                                        </div>
                                                       <!--end content-->
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-info">Guardar</button>
                                                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end modal-->
                                      </td>
                                      <!--validar el estado de revision-->
                                      @if(!empty($lec->comentario))
                                         <td><span style="background-color:#7FFFA0;">Revisado</span></td>
                                      @else
                                         <td><span style="background-color:#FFF93A;">Pendiente</span></td>
                                      @endif
                                      <td>
                                        <!--modal de confirmacion-->
                                        <!-- Button trigger modal -->
                                        <a type="button" data-toggle="modal" data-target="#eliminarLec{{$tarea->challenge_id}}">
                                         <span class="glyphicon glyphicon-trash" aria-hidden="true" style="font-size:18px; color:red;"></span>
                                        </a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="eliminarLec{{$tarea->challenge_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content" style="border-radius:20px;">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Confirmar</h4>
                                            </div>
                                            <div class="modal-body">
                                               <h4> ¿Relmente desea eliminar esta tarea? </h4>
                                               <p>Nota: Si elimina esta tarea desaparecerá del registro de la base de datos.</p>
                                            </div>
                                            <div class="modal-footer">
                                               <a href="/eliminar/tarea/{{$tarea->idretofin}}" type="button" class="btn btn-info">Si</a>
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">No</button>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <!--end modal -->
                                      </td>
                                      <!--end validar revision-->
                                     @endif
                                    @endforeach
                                    <!--end lecturas-->
                                    <!--videos-->
                                    @foreach ($videos as $vid)
                                     @if($vid->id_challenge == $tarea->challenge_id)
                                      <td>
                                        <!--aqui un modal-->
                                        <!-- Botón que activa el modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#videos{{$tarea->challenge_id}}">
                                            Retroalimentación
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="videos{{$tarea->challenge_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content" style="border-radius:20px;">
                                                    <div class="modal-header" style="border-radius:20px;">
                                                        <h4 class="modal-title" id="exampleModalLabel">Agregar retroalimentación:</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="post" action="{{route('comentarioVideos')}}">
                                                    @csrf()
                                                    <div class="modal-body">
                                                       <!--contenido-->
                                                        <div class="form-group">
                                                            <label class="control-label"><h4>Respuesta:</h4></label>
                                                            <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$vid->respuesta}}</p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label  class="control-label"><h4>Comentario:</h4></label>
                                                            <textarea class="form-control" id="comentariovideo" name="comentariovideo">{{$vid->comentario}}</textarea>
                                                            <input value="{{$tarea->challenge_id}}" name="idchallengue" hidden>
                                                            <input value="{{$user}}" name="idusu" hidden>
                                                            <input value="{{$vid->idvideo}}" name="idvideo" hidden>
                                                        </div>
                                                       <!--end content-->
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-info">Guardar</button>
                                                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end modal-->
                                      </td>
                                      <!--validar el estado de revision-->
                                      @if(!empty($vid->comentario))
                                         <td><span style="background-color:#7FFFA0;">Revisado</span></td>
                                      @else
                                         <td><span style="background-color:#FFF93A;">Pendiente</span></td>
                                      @endif
                                      <td>
                                        <!--modal de confirmacion-->
                                        <!-- Button trigger modal -->
                                        <a type="button" data-toggle="modal" data-target="#eliminarVid{{$tarea->challenge_id}}">
                                         <span class="glyphicon glyphicon-trash" aria-hidden="true" style="font-size:18px; color:red;"></span>
                                        </a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="eliminarVid{{$tarea->challenge_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content" style="border-radius:20px;">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Confirmar</h4>
                                            </div>
                                            <div class="modal-body">
                                               <h4> ¿Relmente desea eliminar esta tarea? </h4>
                                               <p>Nota: Si elimina esta tarea desaparecerá del registro de la base de datos.</p>
                                            </div>
                                            <div class="modal-footer">
                                               <a href="/eliminar/tarea/{{$tarea->idretofin}}" type="button" class="btn btn-info">Si</a>
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">No</button>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <!--end modal -->
                                      </td>
                                      <!--end validar revision-->
                                     @endif
                                    @endforeach
                                    <!--end videos-->
                                    <!--salidas-->
                                    @foreach ($salidas as $sal)
                                     @if($sal->id_challenge == $tarea->challenge_id)
                                      <td>
                                        <!--aqui un modal-->
                                        <!-- Botón que activa el modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#salidas{{$tarea->challenge_id}}">
                                            Retroalimentación
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="salidas{{$tarea->challenge_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content" style="border-radius:20px;">
                                                    <div class="modal-header" style="border-radius:20px;">
                                                        <h4 class="modal-title" id="exampleModalLabel">Agregar retroalimentación:</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{route('comenSalidas')}}" method="post">
                                                     @csrf()
                                                    <div class="modal-body">
                                                       <!--contenido-->
                                                        <div class="form-group">
                                                            <label class="control-label"><h4>Respuesta:</h4></label>
                                                            <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$sal->respuesta}}</p>
                                                        </div>
                                                         <!--===================-->
                                                            <div class="row">
                                                                <div class="col-xs-8 col-sm-6">
                                                                <img src="{{ asset('/storage/gameoutdoor/' .$sal->img) }}"  class="img-responsive" alt="Responsive image">
                                                                </div>
                                                                <div class="col-xs-4 col-sm-6">
                                                                @if(!empty($sal->video))
                                                                <a href="{{$sal->video}}" target="_blank"><span class="glyphicon glyphicon-play" aria-hidden="true"></span> Ver video</a>
                                                                @endif
                                                                </div>
                                                            </div>
                                                            <!--=====================-->
                                                        <div class="form-group">
                                                            <label class="control-label"><h4>Comentario:</h4></label>
                                                            <textarea class="form-control" id="comensal" name="comensal">{{$sal->comentario}}</textarea>
                                                            <input value="{{$user}}" name="idusu" hidden>
                                                            <input value="{{$sal->idout}}" name="idsal" hidden>
                                                        </div>
                                                       <!--end content-->
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-info">Guardar</button>
                                                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end modal-->
                                      </td>
                                       <!--validar el estado de revision-->
                                       @if(!empty($sal->comentario))
                                         <td><span style="background-color:#7FFFA0;">Revisado</span></td>
                                      @else
                                         <td><span style="background-color:#FFF93A;">Pendiente</span></td>
                                      @endif
                                      <td>
                                        <!--modal de confirmacion-->
                                        <!-- Button trigger modal -->
                                        <a type="button" data-toggle="modal" data-target="#eliminarSalidas{{$tarea->challenge_id}}">
                                         <span class="glyphicon glyphicon-trash" aria-hidden="true" style="font-size:18px; color:red;"></span>
                                        </a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="eliminarSalidas{{$tarea->challenge_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content" style="border-radius:20px;">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Confirmar</h4>
                                            </div>
                                            <div class="modal-body">
                                               <h4> ¿Relmente desea eliminar esta tarea? </h4>
                                               <p>Nota: Si elimina esta tarea desaparecerá del registro de la base de datos.</p>
                                            </div>
                                            <div class="modal-footer">
                                               <a href="/eliminar/tarea/{{$tarea->idretofin}}" type="button" class="btn btn-info">Si</a>
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">No</button>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <!--end modal -->
                                      </td>
                                      <!--end validar revision-->
                                     @endif
                                    @endforeach
                                    <!--sopa de letras-->
                                    @foreach ($sopa as $sop)
                                     @if($sop->challenge_id == $tarea->challenge_id)
                                      <td>
                                        <!--aqui un modal-->
                                        <!-- Botón que activa el modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sopas{{$tarea->challenge_id}}">
                                           Retroalimentación
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="sopas{{$tarea->challenge_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content" style="border-radius:20px;">
                                                    <div class="modal-header" style="border-radius:20px;">
                                                        <h4 class="modal-title" id="exampleModalLabel">Agregar retroalimentación:</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form  action="{{route('comJuegos')}}" method="post">
                                                     @csrf()
                                                    <div class="modal-body">
                                                       <!--contenido-->
                                                        <div class="form-group">
                                                            <label class="control-label"><h4>Descripción:</h4></label>
                                                            <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$sop->des}}</p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><h4>Respuesta:</h4></label>
                                                            <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$sop->respuesta}}</p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><h4>Comentario:</h4></label>
                                                            <textarea class="form-control" id="comentario" name="comentario">{{$sop->comentario}}</textarea>
                                                            <input value="{{$user}}" name="idusu" hidden>
                                                            <input value="{{$sop->challenge_id}}" name="challenge_id" hidden>
                                                        </div>
                                                       <!--end content-->
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-info">Guardar</button>
                                                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                   </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end modal-->
                                      </td>
                                       <!--validar el estado de revision-->
                                        @if(!empty($sop->comentario))
                                            <td><span style="background-color:#7FFFA0;">Revisado</span></td>
                                        @else
                                            <td><span style="background-color:#FFF93A;">Pendiente</span></td>
                                        @endif
                                        <td>
                                        <!--modal de confirmacion-->
                                        <!-- Button trigger modal -->
                                        <a type="button" data-toggle="modal" data-target="#eliminarSopa{{$tarea->challenge_id}}">
                                         <span class="glyphicon glyphicon-trash" aria-hidden="true" style="font-size:18px; color:red;"></span>
                                        </a>
                                        <!-- Modal -->
                                        <div class="modal fade" id="eliminarSopa{{$tarea->challenge_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content" style="border-radius:20px;">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Confirmar</h4>
                                            </div>
                                            <div class="modal-body">
                                               <h4> ¿Relmente desea eliminar esta tarea? </h4>
                                               <p>Nota: Si elimina esta tarea desaparecerá del registro de la base de datos.</p>
                                            </div>
                                            <div class="modal-footer">
                                               <a href="/eliminar/tarea/{{$tarea->idretofin}}" type="button" class="btn btn-info">Si</a>
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">No</button>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <!--end modal -->
                                      </td>
                                        <!--end validar revision-->
                                     @endif
                                    @endforeach
                                    <!--ahorcado-->
                                    @foreach ($ahorcado as $ah)
                                     @if($ah->challenge_id == $tarea->challenge_id)
                                      <td>
                                        <!--aqui un modal-->
                                        <!-- Botón que activa el modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ahorcado{{$tarea->challenge_id}}">
                                            Retroalimentación
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="ahorcado{{$tarea->challenge_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content" style="border-radius:20px;">
                                                    <div class="modal-header" style="border-radius:20px;">
                                                        <h4 class="modal-title" id="exampleModalLabel">Agregar retroalimentación:</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form  action="{{route('comJuegos')}}" method="post">
                                                     @csrf()
                                                    <div class="modal-body">
                                                       <!--contenido-->
                                                        <div class="form-group">
                                                            <label class="control-label"><h4>Descripción:</h4></label>
                                                            <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$ah->des}}</p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><h4>Respuesta:</h4></label>
                                                            <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$ah->respuesta}}</p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><h4>Comentario:</h4></label>
                                                            <textarea class="form-control" id="comentario" name="comentario">{{$ah->comentario}}</textarea>
                                                            <input value="{{$user}}" name="idusu" hidden>
                                                            <input value="{{$ah->challenge_id}}" name="challenge_id" hidden>
                                                        </div>
                                                       <!--end content-->
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-info">Guardar</button>
                                                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end modal-->
                                      </td>
                                       <!--validar el estado de revision-->
                                      @if(!empty($ah->comentario))
                                         <td><span style="background-color:#7FFFA0;">Revisado</span></td>
                                      @else
                                         <td><span style="background-color:#FFF93A;">Pendiente</span></td>
                                      @endif
                                      <td>
                                        <!--modal de confirmacion-->
                                        <!-- Button trigger modal -->
                                        <a type="button" data-toggle="modal" data-target="#eliminarAhorcado{{$tarea->challenge_id}}">
                                         <span class="glyphicon glyphicon-trash" aria-hidden="true" style="font-size:18px; color:red;"></span>
                                        </a>
                                        <!-- Modal -->
                                        <div class="modal fade" id="eliminarAhorcado{{$tarea->challenge_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content" style="border-radius:20px;">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Confirmar</h4>
                                            </div>
                                            <div class="modal-body">
                                               <h4> ¿Relmente desea eliminar esta tarea? </h4>
                                               <p>Nota: Si elimina esta tarea desaparecerá del registro de la base de datos.</p>
                                            </div>
                                            <div class="modal-footer">
                                               <a href="/eliminar/tarea/{{$tarea->idretofin}}" type="button" class="btn btn-info">Si</a>
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">No</button>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <!--end modal -->
                                      </td>
                                      <!--end validar revision-->
                                     @endif
                                    @endforeach
                                    <!--pictures-->
                                    @foreach ($pictures as $q)
                                     @if($q->id_challenge == $tarea->challenge_id)
                                      <td>
                                        <!--aqui un modal-->
                                        <!-- Botón que activa el modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pictures{{$tarea->challenge_id}}">
                                            Retroalimentación
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="pictures{{$tarea->challenge_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content" style="border-radius:20px;">
                                                    <div class="modal-header" style="border-radius:20px;">
                                                        <h4 class="modal-title" id="exampleModalLabel">Agregar retroalimentación:</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{route('comenPicture')}}" method="post">
                                                     @csrf()
                                                    <div class="modal-body">
                                                       <!--contenido-->
                                                        <div class="form-group">
                                                            <label class="control-label"><h4>Descripción:</h4></label>
                                                            <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$q->des}}</p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><h4>Respuesta:</h4></label>
                                                            <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$q->respuesta}}</p>
                                                        </div>
                                                         <!--===================-->
                                                         <div class="row">
                                                                <div class="col-xs-8 col-sm-6">
                                                                <img src="{{ asset('/storage/gamefoto/' .$q->img) }}"   class="img-responsive" alt="Responsive image">
                                                                </div>
                                                                <div class="col-xs-4 col-sm-6">
                                                                @if(!empty($q->video))
                                                                <a href="{{$q->video}}" target="_blank"><span class="glyphicon glyphicon-play" aria-hidden="true"></span>Ver video</a>
                                                                @endif
                                                                </div>
                                                            </div>
                                                            <!--=====================-->
                                                        <div class="form-group">
                                                            <label class="control-label"><h4>Comentario:</h4></label>
                                                            <textarea class="form-control" id="comenpicture" name="comenpicture">{{$q->comentario}}</textarea>
                                                            <input value="{{$user}}" name="idusu" hidden>
                                                            <input value="{{$q->id_challenge}}" name="idpicture" hidden>
                                                        </div>
                                                       <!--end content-->
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-info">Guardar</button>
                                                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end modal-->
                                      </td>
                                       <!--validar el estado de revision-->
                                      @if(!empty($q->comentario))
                                         <td><span style="background-color:#7FFFA0;">Revisado</span></td>
                                      @else
                                         <td><span style="background-color:#FFF93A;">Pendiente</span></td>
                                      @endif
                                      <td>
                                        <!--modal de confirmacion-->
                                        <!-- Button trigger modal -->
                                        <a type="button" data-toggle="modal" data-target="#eliminarPictures{{$tarea->challenge_id}}">
                                         <span class="glyphicon glyphicon-trash" aria-hidden="true" style="font-size:18px; color:red;"></span>
                                        </a>
                                        <!-- Modal -->
                                        <div class="modal fade" id="eliminarPictures{{$tarea->challenge_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content" style="border-radius:20px;">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Confirmar</h4>
                                            </div>
                                            <div class="modal-body">
                                               <h4> ¿Relmente desea eliminar esta tarea? </h4>
                                               <p>Nota: Si elimina esta tarea desaparecerá del registro de la base de datos.</p>
                                            </div>
                                            <div class="modal-footer">
                                               <a href="/eliminar/tarea/{{$tarea->idretofin}}" type="button" class="btn btn-info">Si</a>
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">No</button>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <!--end modal -->
                                      </td>
                                      <!--end validar revision-->
                                     @endif
                                    @endforeach
                                    <!-- Puedes agregar más columnas según tus necesidades -->
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                    </table>                    
                </div>
                        
            </div>
            <!-- /.col -->                                
        </div>
    </div>
    <!-- /.box-body -->
</div>

<!--======================================-->
<!-- Place the first <script> tag in your HTML's <head> -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
   $(document).ready(function () {
      $("#searchInput").on("keyup", function () {
         var value = $(this).val().toLowerCase();
         $("#dataTable tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
         });
      });
   });
</script>


@endsection

