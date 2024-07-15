@extends('layouts.admin')

@section('titulos')
<section class="content-header">
    <ol class="breadcrumb">
    <li><a href="{{ url('/backdoor') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>    
    <li><a href="{{ url('/reconocimientos') }}"><i class="fa fa-dashboard"></i> Reconocimientos</a></li>    
    <li class="active">Editar-Reconocimientos</li>
    </ol>
</section>
@endsection


@section('awardEdit')

<div class="box box-default" style="margin-top: 5%;">
    <div class="box-header with-border">
        <div class="box-tools pull-right">
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <h2>EDITAR RECONOCIMIENTO</h2>
                <br><br>
                <div class="row">
                    <div class="col-md-2" >
                    </div>
                </div>

                <!-- TRAER LA INFO ACTUAL PARA EDITAR -->

                <form method="POST" enctype="multipart/form-data" action="{{ route('reconocimientos.update', $recompensas->id) }}">
                  @csrf
                  @method('PUT')

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="name">Nombre</label>
                      <input type="text" class="form-control" name="name" id="name" value="{{$recompensas->name}}" placeholder="Nombre">
                    </div>
                  </div>
                  <div class="col-md-7">
                    <div class="form-group">
                      <label for="imagen">Imagen Recompensa</label>
                      <div class="form-inline">    
                          <img src="{{ asset($recompensas->imagen)}}" width="100px">
                        <input type="file" class="form-control" name="imagen" id="imagen">
                        <input type="hidden" name="imagennoupdate" value="{{$recompensas->imagen}}">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12"></div>

                  <div class="col-md-3">                    
                      <div class="form-group">
                          <label for="spoints">PUNTAJE S</label>
                          <input type="text" class="form-control" name="spoints" value="{{$recompensas->s_point}}" id="spoints" placeholder="spoints">                       
                      </div>
                  </div>
                  <div class="col-md-3">      
                      <div class="form-group">
                          <label for="ipoints">Puntaje I</label>
                          <input type="text" class="form-control" name="ipoints" value="{{$recompensas->i_point}}" id="ipoints" placeholder="ipoints">
                        
                      </div>
                  </div>
                  <div class="col-md-3">            
                      <div class="form-group">
                          <label for="gpoints">Puntaje G</label>
                          <input type="text" class="form-control" name="gpoints" value="{{$recompensas->g_point}}" id="gpoints" placeholder="gpoints">
                      </div>
                  </div>

                  <div class="col-md-9">
                    <div class="form-group">
                      <label for="descripcion">Descripcion</label>
                      <textarea rows="4" cols="50" class="form-control" name="desc" id="descripcion" placeholder="Descripcion">{{$recompensas->description}}</textarea>
                    </div>
                  </div>
                   <!--actualizar -->
                  <div class="col-md-9">
                  <div class="form-group">
                    <label for="descripcion">Elegir grupo</label>
                      <select class="form-control" id="tipo" name="tipo">
                          <option value="{{$recompensas->id_grupo}}">{{$recompensas->nombre}}</option>
                          @foreach($grup as $gr)
                          @if($gr->id != $recompensas->id_grupo)
                          <option value="{{$gr->id}}">{{$gr->nombre}}</option>
                          @endif
                          @endforeach
                      </select>
                    </div> 
                  </div>
                  <!--end actualizar-->
                    <!--actualizar avatar-->
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="avatar">Imagen Avatar</label>
                      <div class="form-inline">    
                          <img src="{{ asset($recompensas->avatarchange)}}" width="100px">
                          <input type="file" class="form-control" name="avatar" id="avatar"
                      </div>
                    </div>
                  </div>
                  <!---end avatar-->
                  <div class="col-md-12">
                    <button type="submit" class="btn btn-success mb-3">Actualizar</button>
                  </div>
                </form>                       
            </div>
            <!-- /.col -->                                
        </div>
    </div>
    <!-- /.box-body -->
</div>



@endsection
