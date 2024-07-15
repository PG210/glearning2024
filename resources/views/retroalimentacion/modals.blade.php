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

    <div class="row">
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">

        <h2>Retroalimentación</h2>
        <h3>Mensaje</h3>
        <p style="text-align:justify;">
         Cada comentario es una oportunidad de pulir nuestras habilidades, aprender y avanzar hacia la mejor versión de nosotros mismos. Aceptemos con gratitud las sugerencias, ya que son puentes hacia el éxito y la mejora continua.
         <br>
          ¡Adelante, construyamos juntos un camino de desarrollo y logros!
        </p>
      </div>
      </div>
    </div>
    <!-- /.row -->
   <div class="col-md-9">
      <div class="nav-tabs-custom">
        <div class="tab-content">
         <!--=========================================-->
         <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            @foreach($com as $c)
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#acordeon{{$c->id}}" aria-expanded="true" aria-controls="collapseOne">
                      Capítulo {{$c->capitulo_id}}
                    </a>
              </h4>
                </div>
                <div id="acordeon{{$c->id}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                  {{$c->comentario}}
                </div>
                </div>
            </div>
           @endforeach
            </div>
         <!---====================================-->
        </div>
        <!--============================================-->
        <!-- /.tab-content -->
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
    </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 1.1.2
  </div>
  <strong>Copyright &copy; 2024 <a href="#">Evolución</a>.</strong> All rights
  reserved.
</footer>


<!-- ./wrapper -->

@endsection
 









