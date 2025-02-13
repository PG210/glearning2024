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
    <h1 style="font-size: 5rem; margin: 4% 0% 0% 0%;">
      Bienvenido {{ Auth::user()->firstname }} 
    </h1>
    <!--mensaje-->
   @if(isset($tem))
      @if($tem == 0)
           <div class="alert alert-warning alert-dismissible fade in" role="alert" style="padding-top:2px; padding-bottom:2px; border-radius:15px;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h3 class="text-center"> <strong>¡Felicidades!, Capítulo terminado de manera exitosa &#128522; </strong> </h3>
            </div>
      @endif
      @if($tem == 1)
         <div class="alert alert-dismissible fade in" role="alert" style="padding-top:2px; padding-bottom:2px; border-radius:15px; background-color:#1ED5F4;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h3 class="text-center"> <strong>Tienes tareas pendientes para finalizar el capítulo, apresúrate &#128515;</strong> </h3>
            </div>
        @endif
     @endif
     <!-- validar para continuar el capitulo validar que las tareas lleguen a cero-->
     @if(isset($tareaspendientes) && $tareaspendientes == 0 && $capsiguiente != $cap)
     <br>
     <div class="alert alert-dismissible fade in" role="alert" style="padding-top:2px; padding-bottom:2px; border-radius:15px; background-color:#101C5A;">
      <div class="row">
          <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
            <a href="/capitulos/{{$capsiguiente}}" style="white-space:normal; margin:5px;" class="btn btn-primary">
              <span style="font-weight:900;font-size:95%;"><i class="fa fa-arrow-circle-right"></i> Siguiente Capítulo: {{$capsiguiente}}</span>
            </a>
          </div>
        </div>
     </div>
    @endif
    <!--- en validar capitulo--->
    <!--end mensaje-->
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Capitulo {{ $capitulos->order }}</a></li>      
    </ol>
  </section>

  {{-- <popupinsignias-component></popupinsignias-component> --}}

  <!-- Main content -->
  <section class="content">

    <div class="row">
      <div class="col-md-3">
        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">

        <h2>{{ $capitulos->name }}</h2>
        <!-- <p>vista para todos los capitulos, los datos se cargan dinamicamente</p> -->
        <h3>{{ $capitulos->title }}</h3>
        <p>
          {{ $capitulos->description }}
        </p>
      </div>
        <!-- /.nav-tabs-custom -->
      </div>
      <!-- /.col -->
      <!-- About Me Box -->

      <div class="box box-primary">
        <?php
          //obtener relacion SUBCAPTULO_USER
          $users = App\User::find(Auth::user()->id);
          $userauthid = Auth::user()->id;
        ?>
        <div class="box-header with-border">
          <h3>Temas:</h3>
        </div>

        <?php
          $subcapitul = DB::select("call subchapterSecuence($capitulos->id, $userauthid)");  
          $subcapitulos = array_reverse($subcapitul);

          $lastsubcapitulo = DB::select("call lastSubchapter($capitulos->id, $userauthid)");   
                   
        ?>

        @foreach ($subcapitulos as $subcap)            
          <div class="box-body">

            @if($subcap->RETOS_SUBCAPITULO_REQUERIDO == $subcap-> RETOS_CAPITULO_COMPLETADOS)
              <!-- PlayerChaptersController@pasarchallenge --> 
              <div class="form-group">                
                <a type="button" style="font-size: 15px; background-color:#868686!important; border-color:#2d2d2d!important; border-radius: 14px; padding: 12px 15px; box-shadow: 0 5px #000;" class="btn-block btn-primary" href="#tareas" data-toggle="tab">
                    <img src="{{ asset('dist/img/checked.png') }}" style="margin: -1% 1% -3% 0%; width: 17%;">                  
                  {{ $subcap->name }} 
                </a>
              </div>
            @else                
              <div class="form-group"> 
                <a type="button" style="font-size:15px; border-radius: 14px; padding: 12px 15px; box-shadow: 0 5px #999;" class="btn-block btn-danger" href="#tareas" data-toggle="tab">
                 COMENZAR: {{ $subcap->name }} 
                </a>
              </div>                                  
            @endif

            <strong>Descripcion:</strong>
            <p style="color: #730028; font-size: 16px; font-weight: 600;">
                {{ $subcap->description }}                
            </p>                                                                                     
            <hr>
          </div>
          <!-- /.Subcapitulos del Reto -->
        @endforeach      

      </div>
    </div>
    <!-- /.row -->
    <div class="col-md-9">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            {{-- <li class="active">
              <h4>
                @if(!isset($v))
                  <a href="#activity" data-toggle="tab" style="color:black; padding: 1em;"> {{ $capitulos->name }} </a>
                @endif
              </h4>
            </li> --}}
            <li class="active">
              <h4>
                <a href="#tareas" data-toggle="tab" style="padding: 1em;">Retos del capítulo</a>
              </h4>
            </li>
        </ul>
        <div class="tab-content">
           <!--- item tareas -->
            <div class="tab-pane active"  id="tareas">
             <!--contenido-->
             <div style="height: 500px; overflow-y: scroll;">
             <br>
            <!---imprimir las tareas si ya registra una actividad-->   
              @php
                  $siguienteDesbloqueada = false;
              @endphp

              @foreach ($tareacap as $tarea)
                  @php
                      $completada = in_array($tarea->idt, $tareasCompletadas);
                  @endphp

                  <!---aqui informacion datos-->
                  <div class="post">
                      <div class="user-block" style="margin-left: 2em;">
                          <h4>{{ $tarea->name }}</h4>
                          @if ($completada)
                              <strong>                        
                                <img src="{{ asset('dist/img/checked.png') }}" style="margin: -1% 1% -3% 0%;">
                                 El reto,  ya ha sido completado!!!
                              </strong>
                          @elseif (!$siguienteDesbloqueada)
                              <a href="{{ route('player.challenge', $tarea->idt) }}">
                                <i class="fa fa-unlock blinking-lock" style="font-size:36px; margin: -1% 1% -3% 0%; color:#4b42bc;"></i>
                                <strong class="blinking-lock" >Desbloqueado - ¡Puedes realizar este reto!</strong> 
                              </a>
                              @php $siguienteDesbloqueada = true; @endphp
                          @else
                            <i class="fa fa-lock" style="font-size:36px; margin-left:10px;"></i>&nbsp;&nbsp;&nbsp;                    
                             <strong>Reto pendiente.</strong> 
                          @endif
                      </div>
                  </div>
                  <!--end información--->
              @endforeach
              <br>
             <!---end actividades-->
           </div>
             <!--end contenido-->
            </div>
        <!--end tareas-->
           <!--################################-->
           {{-- 
          <div class="tab-pane fade in active"  id="activity">

            <?php
              #if (empty($videohidden)) {
              #  $videodisplay = "visible";
              #} else {
              #  $videodisplay = "hidden";
              #  echo '<script>document.getElementById("videoIntro").pause();</script>';
              #}
            ?>            

            <div class="media">                
              <div class="media-body">
              @if (strpos($capitulos->videoIntro, 'http') !== false) 
                <iframe src="{{$capitulos->videoIntro}}" id="framevideos" class="{{ $videodisplay }}" frameborder="0" style="width:100%; height:420px;" allowfullscreen></iframe>
              @else 
                <video src="{{ asset('/storage/videos/' .$capitulos->videoIntro) }}" id="videoIntro" class="{{$videodisplay}}" 
                     style="width:100%; height:auto; object-fit: cover; "  controls  allowfullscreen></video>

              @endif
              
              </div>
            </div>

          </div>--}}


          <!-- /.tab-pane -->
          <div class="tab-pane" id="timeline">
            <!-- The timeline -->
            <ul class="timeline timeline-inverse">

              <!-- timeline item -->
              <li>
                <i class="fa fa-envelope bg-blue"></i>

                <div class="timeline-item">
                  @if(!empty($finish))
                    <h3 class="timeline-header"><a href="#">Recurso {{ $finish->name }}</a> {{ $finish->material }}</h3>
                  @endif
                  <div class="timeline-body">
                    Bienvenido a la Evolución
                  </div>
                </div>
              </li>
              <!-- END timeline item -->

              <li>
                <i class="fa fa-check-circle bg-gray"></i>
              </li>
            </ul>
          </div>
          <!-- /.tab-pane -->

          <div class="tab-pane" id="settings">
            <!-- RECOMPENSAS -->
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@include('layouts.footer')
<!-- ./wrapper -->

@endsection
