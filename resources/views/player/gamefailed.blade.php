@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/magic-master/magic.css') }}">

<style>
  .nofin{
    display: none;
    color: #e61b1b;
  }
  .modal-failed{
      background-image: url('/dist/img/fondos/fondo4.jpg'); /* Ruta de la imagen de fondo */
      background-size: cover; /* Ajusta la imagen para cubrir todo el div */
      background-position: center; /* Centra la imagen */
    }
  .header-color{
     background-color: #131535;
    }
</style>

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
      Lo sentimos {{ Auth::user()->firstname }}
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">

     <!-- /.row -->

    <div class="col-md-12">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#activity" data-toggle="tab">GAME OVER</a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="activity">
            <!-- Post -->
            <div class="post">
              <div class="user-block">
                  <h1 class="nofin">RETO FALLIDO</h1>
                  <h3>Necesitas mas del 80% para superar la Prueba</h3>
                  <p>Intentalo de nuevo mas adelante</p>
              </div>
              <script type="application/javascript">
                setTimeout(function(){
                  $('.nofin').css("display","block").delay(500);
                  $('.nofin').addClass('magictime boingInUp');
                }, 1500);
              </script>
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

<!---reto fallido --->
<audio controls autoplay>
  <source src="https://commondatastorage.googleapis.com/codeskulptor-demos/riceracer_assets/music/win.ogg" type="audio/ogg">
</audio>
<div class="modal modal-info fade in" id="modal-info" style="display: block;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header header-color">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>        
        <h1 class="modal-title">RETO FALLIDO: {{ strtoupper( Auth::user()->firstname ) }}</h1>
      </div>
      <div class="modal-body modal-failed" style="height: 50%;">
       
      </div>
      <div class="modal-footer header-color">
        <a class="btn btn-success btn-lg" href="/playerchallenge/{{ $subcapitulo }}"> VOLVER </a>
      </div>
    </div>
    
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!--end reto fallido-->

<!-- /.content-wrapper -->
<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 1.1.2
  </div>
  <strong>Copyright &copy; 2018 <a href="#">Evolución</a>.</strong> All rights
  reserved.
</footer>


<!-- ./wrapper -->

@endsection
