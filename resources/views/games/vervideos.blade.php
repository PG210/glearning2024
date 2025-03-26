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
  @if ($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif
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
            <!-- Post -->
            <div class="post">
              <div class="user-block">
            <h1>COMENZANDO EL RETO - Ver Video</h1>
            <div class="container-fluid">     
              <blockquote>
                <p style="color: #730028; font-weight: 600; text-align: justify;">
                {!! $retos->description !!}
                </p>
              </blockquote>
            </div>  
            <tiempos-component tiempoasignado="{{ $retos->time }}"></tiempos-component>
            <form method="POST" enctype="multipart/form-data" action="{{ route('gamesplay.seevideos', 5) }}">
                @csrf
                <input type="hidden" name="usuario" value="{{ Auth::user()->id }}">
                <input type="hidden" name="reto" value="{{ $retos->id }}">
                
                
                <div class="row" style="margin:4% 0% 0% 0%;text-align: -webkit-center;">
                  <div class="col-md-12">
                    <div class="form-group">
                         <div class="media">
                         @if (strpos($retos->urlvideo, 'http') !== false) 
                            <iframe width="600" height="315" src="{{ $retos->urlvideo }}" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                         @else 
                           <div class="media-body"  style="padding:0% 10% 0% 10%;text-align: -webkit-center;" ><video src="{{ asset('/storage/public/videos/' .$retos->urlvideo) }}" id="videoIntro" 
                                style="width:100%; height:auto; object-fit: cover; "  controls  allowfullscreen></video></div>
                         @endif
                         </div>
                      {{--
                     <div class="visible-xs">
                      @if (strpos($retos->urlvideo, 'http') !== false) 
                      <div class="embed-responsive embed-responsive-16by9">
                          <video class="embed-responsive-item" controls>
                              <source src="{{ $retos->urlvideo }}" type="video/mp4">
                          </video>
                      </div>
                     @else 
                      <div class="embed-responsive embed-responsive-16by9">
                          <video class="embed-responsive-item" controls>
                              <source src="{{ asset('/storage/public/videos/' .$retos->urlvideo) }}" type="video/mp4">
                          </video>
                      </div>
                      @endif
                      </div>
                         --}}
                    </div>
                    <div class="form-group">
                        <label for="evidence">Respuesta - Minimo 120 Caracteres</label>
                        <textarea class="form-control{{ $errors->has('evidence') ? ' is-invalid' : '' }}" rows="5" name="evidence" id="evidence" spellcheck="true" placeholder="A continuación escribe tus respuestas a las instrucciones planteadas en el Reto"required >{{ old('evidence') }}</textarea>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary">Terminar</button>
            </form>

              </div>
              <!-- /.user-block -->
            </div>
            <!-- /.post -->
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="timeline">
            <!-- The timeline -->
            <ul class="timeline timeline-inverse">
              <!-- timeline time label -->
              <!-- <li class="time-label">
                    <span class="bg-red">
                      12 Dic. 2018 (Fecha actual desde el servidor)
                    </span>
              </li> -->
              <!-- /.timeline-label -->
              <!-- timeline item -->
              <li>
                <i class="fa fa-envelope bg-blue"></i>

                <div class="timeline-item">
                  <!-- <span class="time"><i class="fa fa-clock-o"></i> 12:05 (Hora PC)</span> -->

                  <h3 class="timeline-header"><a href="#">Recurso Reto 1</a> </h3>

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
