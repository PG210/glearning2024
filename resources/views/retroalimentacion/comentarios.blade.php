@extends('layouts.app')

@section('content')

 <!-- /.sidebar-menu -->
 </section>
  <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Bienvenido {{ Auth::user()->firstname }} 
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">

     <!-- /.row -->
     <div class="box box-default mt-3">
     <h1>Retroalimentación</h1>
        <div class="box-header with-border">
            <div class="box-tools pull-right">
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-12 table-responsive">
                  <table class="table table-hover">
                      <thead>
                          <tr>
                            <th><h4>Capítulo</h4></th>
                            <th><h4>Nombre de la Tarea</h4></th>
                            <th><h4>Tipo</h4></th>
                            <th><h4>Material</h4></th>
                            <th></th>
                          </tr>
                      </thead>
                      <tbody>
                         <!--aqui imprimir los retos del usuario-->
                         @foreach ($retos as $capituloKey => $tareasCapitulo)
                            <tr  style="background-color:#DEEAEC;">
                                <td colspan="4" style="font-size:16px;"><b>Capítulo {{ $capituloKey }}</b></td>
                                <td> 
                                @foreach($comcat as $com)
                                  @if($capituloKey == $com->capitulo_id)
                                       <a type="button" class="btn btn-info" data-toggle="modal" data-target="#comentario{{ $capituloKey }}">
                                         Retroalimentación
                                       </a>
                                        <!-- Modal -->
                                        <div class="modal fade" id="comentario{{ $capituloKey }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content" style="border-radius:20px;">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Informe de retroalimentación del capítulo {{ $capituloKey }} </h4>
                                            </div>
                                            <div class="modal-body">
                                               <!--forms-->
                                                <div class="form-group">
                                                  <label  class="control-label"><h4>Comentario:</h4></label>
                                                  <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$com->comentario}}</p> 
                                                </div>
                                               <!--end forms-->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">Salir</button>  
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                  @endif
                                @endforeach
                                </td>
                            </tr>
                            @foreach ($tareasCapitulo as $tarea)
                                <tr>
                                @if($tarea->idtipo == 7)
                                   <!--lecturas-->
                                    @foreach ($lecturas as $lec)
                                        @if($lec->id_challenge == $tarea->challenge_id)
                                        <td></td>
                                        <td>{{ $tarea->name }}</td>
                                        <td>{{ $tarea->tipo }} </td>
                                        <td>
                                           <a href="{{ asset('/storage/public/' . $tarea->material) }}"  download><i class="fa fa-download"></i> Descargar </a>
                                        </td>
                                        <!--nuevas comentarios-->
                                        <td>
                                          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#lecturas{{$tarea->challenge_id}}">
                                              Retroalimentación
                                          </button>
                                          <!-- Modal -->
                                          <div class="modal fade" id="lecturas{{$tarea->challenge_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog modal-lg" role="document">
                                                  <div class="modal-content" style="border-radius:20px;">
                                                      <div class="modal-header">
                                                          <h4 class="modal-title" id="exampleModalLabel">Informe de retroalimentación:</h4>
                                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                              <span aria-hidden="true">&times;</span>
                                                          </button>
                                                      </div>
                                                      <div class="modal-body">
                                                        <!--contenido-->
                                                        <div class="form-group">
                                                              <label class="control-label"><h4>Descripción de la actividad:</h4></label>
                                                              <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$lec->des}}</p>
                                                          </div>
                                                          <div class="form-group">
                                                              <label  class="control-label"><h4>Tu respuesta:</h4></label>
                                                              <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$lec->respuesta}}</p>
                                                          </div>
                                                          <div class="form-group">
                                                            <label  class="control-label"><h4>Comentario:</h4></label>
                                                            <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$lec->comentario}}</p> 
                                                          </div>
                                                        <!--end content-->
                                                      </div>
                                                      <div class="modal-footer"> 
                                                          <button type="button" class="btn btn-warning" data-dismiss="modal">Salir</button>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                        </td>
                                        <!--end comentarios-->
                                        @endif
                                    @endforeach
                                 <!--videos-->
                                @elseif($tarea->idtipo == 5)
                                    @foreach ($videos as $vid)
                                            @if($vid->id_challenge == $tarea->challenge_id)
                                            <td></td>
                                            <td>{{ $tarea->name }}</td>
                                            <td>{{ $tarea->tipo }}{{$tarea->urlvideo}} </td>
                                            <td>
                                              <a href="{{ asset('/storage/public/videos/' . $tarea->urlvideo) }}" target="_blank"><span class="glyphicon glyphicon-play" aria-hidden="true"></span> Ver </a>
                                            </td>
                                            <!--nuevas comentarios-->
                                            <td>
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#videos{{$tarea->challenge_id}}">
                                               Retroalimentación
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="videos{{$tarea->challenge_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content" style="border-radius:20px;">
                                                        <div class="modal-header" >
                                                            <h4 class="modal-title" id="exampleModalLabel">Informe de retroalimentación:</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                          <!--contenido-->
                                                          <div class="form-group">
                                                                <label  class="control-label"><h4>Descripción de la actividad:</h4></label>
                                                                <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$vid->des}}</p>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label"><h4>Tu respuesta:</h4></label>
                                                                <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$vid->respuesta}}</p>
                                                            </div>
                                                            <div class="form-group">
                                                                 <label  class="control-label"><h4>Comentario:</h4></label>
                                                                  <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$vid->comentario}}</p> 
                                                            </div>
                                                          <!--end content-->
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </td>
                                            <!--end comentarios-->
                                            @endif
                                    @endforeach
                                <!--salidas hacer-->
                                @elseif($tarea->idtipo == 8)
                                    @foreach ($salidas as $sal)
                                                @if($sal->id_challenge == $tarea->challenge_id)
                                                <td></td>
                                                <td>{{ $tarea->name }}</td>
                                                <td>{{ $tarea->tipo }} </td>
                                                <td></td>
                                                <!--nuevas comentarios-->
                                                <td>
                                                <a type="button" class="btn btn-info" data-toggle="modal" data-target="#salidas{{$tarea->challenge_id}}">
                                                    Retroalimentación
                                                </a>
                                                <!-- Modal -->
                                                <div class="modal fade" id="salidas{{$tarea->challenge_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content" style="border-radius:20px;">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="exampleModalLabel">Informe de retroalimentación:</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                          
                                                            <div class="modal-body">
                                                              <!--contenido-->
                                                              <div class="form-group">
                                                                    <label class="control-label"><h4>Descripción de la actividad:</h4></label>
                                                                    <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$sal->des}}</p>
                                                                </div>
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
                                                                        <a href="{{$sal->video}}" target="_blank" class="btn btn-info">Ver video</a>
                                                                        @endif
                                                                        </div>
                                                                    </div>
                                                                    <!--=====================-->
                                                                <div class="form-group">
                                                                  <label class="control-label"><h4>Comentario:</h4></label>
                                                                  <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$sal->comentario}}</p> 
                                                                </div>
                                                              <!--end content-->
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-warning" data-dismiss="modal">Salir</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </td>
                                                <!--end comentarios-->
                                                @endif
                                        @endforeach
                                <!--subir foto-->
                                @elseif($tarea->idtipo == 6)
                                    @foreach ($pictures as $q)
                                                @if($q->id_challenge == $tarea->challenge_id)
                                                <td></td>
                                                <td>{{ $tarea->name }}</td>
                                                <td>{{ $tarea->tipo }} </td>
                                                <td></td>
                                                <!--nuevas comentarios-->
                                                <td>
                                                   <!-- Button trigger modal -->
                                                    <a type="button" class="btn btn-info" data-toggle="modal" data-target="#foto{{$tarea->challenge_id}}">
                                                      Retroalimentación
                                                    </a>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="foto{{$tarea->challenge_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                      <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content" style="border-radius:20px;">
                                                          <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">Informe de retroalimentación</h4>
                                                          </div>
                                                          <div class="modal-body">
                                                            <!---contenido del modal-->
                                                            <div class="form-group">
                                                                <label class="control-label"><h4>Descripción de la actividad:</h4></label>
                                                                <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$q->des}}</p>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label"><h4>Tu respuesta:</h4></label>
                                                                <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$q->respuesta}}</p>
                                                            </div>
                                                         <!--===================-->
                                                              <div class="row">
                                                                      <div class="col-xs-8 col-sm-6">
                                                                      <img src="{{ asset('/storage/gameoutdoor/' . $q->img) }}"  class="img-responsive" alt="Responsive image">
                                                                      </div>
                                                                      <div class="col-xs-4 col-sm-6">
                                                                      @if(!empty($q->video))
                                                                      <a href="{{$q->video}}" target="_blank" class="btn btn-info">Ver video</a>
                                                                      @endif
                                                                      </div>
                                                              </div>
                                                                  <!--=====================-->
                                                              <div class="form-group">
                                                                  <label class="control-label"><h4>Comentario:</h4></label>
                                                                  <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$q->comentario}}</p>                                                              
                                                              </div>
                                                            <!--end contenido del modal-->
                                                             </div>
                                                          <div class="modal-footer">
                                                            <button type="button" class="btn btn-warning" data-dismiss="modal">Salir</button>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                </td>
                                                <!--end comentarios-->
                                                @endif
                                    @endforeach
                                <!--para juegos de unity-->
                                @else
                                    @if($tarea->comentario != Null)
                                        <td></td>
                                        <td>{{ $tarea->name }}</td>
                                        <td>{{ $tarea->tipo }} </td>
                                        <td></td>
                                        <!--nuevas comentarios-->
                                        <td>
                                          <!-- Button trigger modal -->
                                            <a type="button" class="btn btn-info" data-toggle="modal" data-target="#juegos{{$tarea->challenge_id}}">
                                              Retroalimentación
                                            </a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="juegos{{$tarea->challenge_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                              <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content" style="border-radius:20px;">
                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Informe de retroalimentación</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                    <!---contenido del modal-->
                                                        <div class="form-group">
                                                          <label  class="control-label"><h4>Descripción de la actividad:</h4></label>
                                                          <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{ $tarea->des }}</p>
                                                        </div>
                                                        <div class="form-group">
                                                          <label class="control-label"><h4>Tu respuesta:</h4></label>
                                                          <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{ $tarea->respuesta }}</p>
                                                        </div>
                                                        <div class="form-group">
                                                          <label  class="control-label"><h4>Comentario:</h4></label>
                                                          <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$tarea->comentario}}</p>
                                                        </div>
                                                    <!--end contenido del modal-->
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-warning" data-dismiss="modal">Salir</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                        </td>
                                        <!--end comentarios-->
                                    @endif
                                <!--=============================-->
                                @endif
                                </tr>
                            @endforeach
                        @endforeach
                         <!--end imprimir retos-->
                      </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 0.1
  </div>
  <strong>Copyright &copy; 2018 <a href="#">Evolución</a>.</strong> All rights
  reserved.
</footer>
<!-- ./wrapper -->


@endsection
