@extends('layouts.admin')


@section('titulos')
<section class="content-header">
    <ol class="breadcrumb">
    <li><a href="{{ url('/backdoor') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li class="active">Insignias</li>
    </ol>
</section>
@endsection


@section('insignias')

@if($status)
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{$status}}
  </div>
@else

@endif

<div class="box box-default" style="margin-top: 5%;">
    <div class="box-header with-border">
        <div class="box-tools pull-right">
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                            
            <h1>Insignias</h1>

            <div class="row">
                <div class="col-md-2" >
                    <a href="{{ route('insignias.create') }}" class="btn btn-block btn-primary btn-md">Nueva insignia</a>
                </div>
                <div class="col-md-2" >
                     <a href="{{route('formuinsigcap')}}" class="btn btn-block btn-success btn-md">Insignia Capitulo</a>
                </div>
              <!---CREAR CATEGORIAS-->
                <div class="col-md-2" >
                    <a href="{{route('formuCategory')}}" class="btn btn-block btn-warning btn-md">Categorias</a>
                </div>
                <!--END CATEGORIAS-->
            </div>
            <div class="box-body table-responsive no-padding">

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Imagen</th>
                            <th>Descripcion</th>
                            <th>Puntos S</th>
                            <th>Puntos I</th>
                            <th>Puntos G</th>
                            <th>Categoría</th>
                            <th>Nivel</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($insignias as $insignia)
                            <tr>
                                <td>{{ $insignia->name }} </td>
                                <td><img src="{{ asset($insignia->imagen)}}" width="60px"></td>               
                                <td>{{ $insignia->description }} </td>
                                <td>{{ $insignia->s_point }} </td>
                                <td>{{ $insignia->i_point }} </td>
                                <td>{{ $insignia->g_point }} </td>
                                <td>{{ $insignia->nomcat}} </td>
                                <td>{{ $insignia->nomnivel}} </td>
                                <td>
                                    <a href="{{ route('insignias.edit', $insignia->id) }}" class="btn btn-default"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <form action="{{ route('insignias.destroy', $insignia->id ) }} " method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-default" aria-label="Left Align">
                                            <span class="fa fa-fw fa-trash-o" aria-hidden="true"></span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
    
                    </tbody>
                </table>            
            </div>
            </div>
            <!-- /.col -->                                
        </div>
    </div>
    <!-- /.box-body -->
</div>

@endsection
