@extends('layouts.app')

@section('content')

 <!-- /.sidebar-menu -->
 </section>
  <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content">

     <!-- /.row -->
     <div class="box box-default mt-3">
      <div class="row">
        <div class="col-lg-4">
            <br>
           <h4>
           <a href="/informe/comentarios" style="margin:2rem;">Ver todo</a>
           </h4> 
        </div>
        <div class="col-lg-4">
            <h1>Retroalimentación</h1>
        </div>
        <div class="col-lg-4">
          
        </div>
      </div>
     <hr>
     <!---mensaje-->
        <!-- /.box-header -->
        <div class="box-body">
            <div class="row">
                <div class="col-md-12 table-responsive">
                  <!-----start information--->
                   <div class="modal-body">
                      <!--contenido-->
                       <div class="form-group">
                            <label class="control-label"><h4>Descripción de la actividad:</h4></label>
                            <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$info[0]->name}}</p>
                            <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$info[0]->descrip}}</p>
                        </div>
                        <div class="form-group">
                            <label class="control-label"><h4>Respuesta:</h4></label>
                            <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$info[0]->evidence}}</p>
                        </div>
                        <!--===================-->
                            <div class="row">
                                <div class="col-xs-8 col-sm-6">
                                  @if(!empty($info[0]->imagen))
                                      <img src="{{ asset('/imgoutdoor/' . $info[0]->imagen) }}" class="img-responsive" alt="Responsive image" width="50%">
                                  @endif
                                 <!---aqui imagen-->
                                </div>
                            </div>
                            <!--=====================-->
                        <div class="form-group">
                          <label class="control-label"><h4>Comentario:</h4></label>
                          <p style="font-size:16px; line-height: 1.8; text-align:justify;">{{$info[0]->comentario}}</p> 
                        </div>
                      <!--end content-->
                    </div>
                  <!--- end information-->
                </div>
            </div>
        </div>
    </div>
    <!-- /.col -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@include('layouts.footer')
<!-- ./wrapper -->


@endsection
