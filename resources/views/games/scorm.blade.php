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

    <div class="col-md-12">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active">
            <h4>
             <a href="#activity" data-toggle="tab" style="padding: 1em;">Reto</a>
            </h4>
          </li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="activity">

          @if(session('mensaje'))
            <div class="alert alert-danger">
                {{ session('mensaje') }}
            </div>
          @endif
            <!-- Post -->
            <div class="post">
              <div class="user-block">
            <h1>COMENZANDO EL RETO </h1>            
            <div class="container-fluid">     
              <blockquote>
                <p style="color: #730028; font-weight: 600; text-align: justify;">
                {!! $retos->description !!}
                </p>
              </blockquote>
            </div>  
            <tiempos-component tiempoasignado="{{ $retos->time }}"></tiempos-component>

                <div class="row" style="margin:4% 0% 0% 0%;text-align: -webkit-center;">
                  <div class="col-md-12">
                  <!---iframe scorm --->
                  <div class="col-md-12 col-sm-8 col-xs-12">
                        <div class="info-box">
                            <div class="panel-group">
                            <div class="panel panel-default" style="box-shadow: 0px 5px 6px 0px #670024;border-color: #ea0d5b;">
                                <div class="panel-heading" style="background-color: #ea0d5b; color: #fff;text-align: center;">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" href="#collapse1">Ver Material: {{ $retos->name }} </a>
                                </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <iframe src="{{ asset('capsulas/' . $retos->material) }}" width="100%" height="500px"></iframe>
                                  </div>
                                </div>
                            </div>
                            </div>
                        </div>
                      </div>
                   </div>
                  <!--end scorm -->
                  </div>
                </div>
                <!--- modal -->
                <!-- Small modal -->
                <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalscorm">
                      Terminar  
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="myModalscorm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document" >
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Para avanzar al siguiente reto, por favor ingrese el código que obtuvo al finalizar la actividad. Luego, haga clic en "Siguiente" para continuar.</h4>
                        </div>
                        <form method="POST" action="{{ route('gamesplay.scorm') }}">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="usuario" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="reto" value="{{ $retos->id }}">
                            <input type="hidden" name="idtipo" value="{{ $retos->challenge_type_id }}">
                            <!--input code-->
                            <label for="basic-url">Ingrese el código</label>
                                <div class="input-group">
                                <span class="input-group-addon" id="basic-addon3"> <span class="glyphicon glyphicon-lock" aria-hidden="true"></span> </span>
                                <input type="text" class="form-control" id="basic-url" name="codigo" aria-describedby="basic-addon3" required>
                            </div>
                            <!--input code-->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Salir</button>
                            <button type="submit" class="btn btn-primary">Siguiente</button>
                        </div>
                        </form>
                        </div>
                    </div>
                    </div>
                <!---end modal-->
                
              </div>
              <!-- /.user-block -->
            </div>
            <!-- /.post -->
          </div>
         
        </div>
        <!-- /.tab-content -->
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->

  </section>
  <!-- /.content -->
</div>
{{-- 
<script>
  var valor = @json($idavat);
  window.valor=valor;
</script>
<script src="{{ asset('capsulas/Pruebazip/story_content/user.js') }}"></script>
--}}
<!-- /.content-wrapper -->
@include('layouts.footer')
<!-- ./wrapper -->
@endsection
