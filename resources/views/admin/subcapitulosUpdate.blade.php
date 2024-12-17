@extends('layouts.admin')


@section('titulos')
<section class="content-header">
      <h1>
        EDITAR TEMA        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/backdoor') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li><a href="{{ url('/capitulos') }}"> Capitulos</a></li>
        <li class="active">Editar Tema</li>
      </ol>
    </section>
@endsection


@section('subcapitulosCreate')

<h2>Editar Tema</h2>


<div class="box box-default">
  <form method="POST" action="{{ route('subcapitulos.update', $subcapitulo->id) }}">
    @csrf

    @method('PUT')
    <input type="hidden" name="chapter_id" value="{{ $subcapitulo->chapter_id }}">
    
    <div class="box-header with-border">      
      <div class="box-tools pull-right">    
      </div>  
    </div>
    <!-- /.box-header -->
    <div class="box-body">    
      <div class="row">
        <div class="col-md-12">              
          <div class="col-md-3">                              
            <div class="form-group">            
              <label for="name">Nombre</label>             
              <input type="text" class="form-control" name="name" id="name" value="{{$subcapitulo->name}}" placeholder="Nombre">             
            </div>            
          </div>             
            <!-- /.form-group -->
              
            <div class="col-md-3">                
                <div class="form-group">
                  <label for="order">Orden</label>
                  <input type="text" class="form-control" name="order" id="order" value="{{$subcapitulo->order}}" placeholder="Orden">
                </div> 
              </div>      
              
              <!-- ASIGNAR COMPETENCIAS -->
              <?php
                $competencias = DB::table('competences')->get();
              ?>
              
              <div class="col-md-4">
                <label for="competencias">Asignar Competencia al Tema</label>
                <select class="form-control" name="competencias" id="competencias">
                  <option> Selecciona la competencia </option>
                    @foreach ($competencias as $item)
                      <option value="{{ $item->id }}" {{ ($item->id == $subcapitulo->competence_id) ? 'selected' : '' }}> {{ $item->name }} </option>
                    @endforeach    
                </select>
              </div>

              
            </div>
            <!-- /.col -->            
            <div class="col-md-12">              
              <div class="col-md-3">
                
                <div class="form-group">
                    <label for="title">Titulo</label>
                    <input type="text" class="form-control" name="title" id="title" value="{{$subcapitulo->title}}" placeholder="Titulo">
                  </div>            
              </div>
              <!-- /.form-group -->
              
              <div class="col-md-3">                  
                <div class="form-group">
                    <label for="time">Tiempo (Minutos)</label>
                    <input type="text" class="form-control" name="time" id="time" value="{{$subcapitulo->time}}" placeholder="Tiempo">
                  </div>
                  <!-- /.form-group -->
                </div>
            </div>
          
            <!-- /.col -->

          <hr>
            
          <div class="col-md-10" >                
            <div class="form-group">
              <label for="description">Descripción</label>
              <textarea class="form-control" rows="5" name="description" id="description" placeholder="Descripcion">{{$subcapitulo->description}}</textarea>
            </div>
          </div>
        </div>
            
        <div class="col-md-8" >                  
          <div class="btn-group">
              <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </div>
          <!-- /.row -->
      </div>
      <!-- /.box-body -->
    </form>
<script>

  $(document).ready(function() {
    $('#example').DataTable( {
        "language": {
            "lengthMenu": "Mostrar _MENU_ Filas",
            "zeroRecords": "No se encontraron registros - sorry",
            "info": "Mostrar pagina _PAGE_ of _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(Filtre por maximo _MAX_ total records)"
        },
        "paging": false
    });
});

  </script>
</div>
@endsection