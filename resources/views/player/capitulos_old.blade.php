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
    <!--end mensaje-->
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Capitulo {{ $capitulos->order }}</a></li>      
    </ol>
  </section>
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
    </div>
    <!-- /.row -->
    <div class="col-md-9">
      <div class="nav-tabs-custom">
        <div class="tab-content">
           <!--- item tareas -->
            <div class="tab-pane fade" id="tareas">
             <!--contenido-->
             <div style="height: 500px; overflow-y: scroll;">
             <br>
           
           </div>
             <!--end contenido-->
            </div>
        <!--end tareas-->
           <!--################################-->
          <div class="tab-pane fade in active"  id="activity">         

            <div class="media">                
              <div class="media-body">
               <!--- inicar capitulos --> 
               <iframe src="{{ asset('capsulas/capsula1/story.html') }}" width="100%" height="500px"></iframe>
              <!---en iniciar capitulos-->
              </div>
            </div>
          </div>
        
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
<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 1.1.2
  </div>
  <strong>Copyright &copy; 2018 <a href="#">Evolución</a>.</strong> All rights
  reserved.
</footer>


<!-- ./wrapper -->

@endsection
