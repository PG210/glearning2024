@extends('layouts.admin')

@section('titulos')
<section class="content-header">
    <ol class="breadcrumb">
    <li><a href="{{ url('/backdoor') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>    
    <li class="active">Reconocimientos</li>
    </ol>
</section>
@endsection


@section('awards')

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
                        <h1>Reconocimientos</h1>

                        <div class="row">
                            <div class="col-md-3" >
                                <a href="{{ route('reconocimientos.create') }}" class="btn btn-block btn-primary btn-md">Agregar Nuevo</a>
                            </div>
                             <div class="col-md-3" >
                               <a href="{{ route('gruporeconocimiento.index') }}" class="btn btn-warning"><span>Agregar Grupo</span></a>
                             </div>
                        </div>
                        <div class="box-body table-responsive no-padding">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Imagen</th>
                                        <th>Descripci�n</th>
                                        <th>Puntos S</th>
                                        <th>Puntos I</th>
                                        <th>Puntos G</th>
                                        <th>Genero</th>
                                        <th>Grupo</th>
                                        <th>Información</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reconocimientos as $reconocimiento)
                                        <tr>
                                            <td>{{$reconocimiento->id}}</td>
                                            <td>{{ $reconocimiento->name }} </td>
                                            <td><img src="{{ asset($reconocimiento->imagen)}}" width="60px"></td>
                                            <td>{{ $reconocimiento->description }} </td>
                                            <td>{{ $reconocimiento->s_point }} </td>
                                            <td>{{ $reconocimiento->i_point }} </td>
                                            <td>{{ $reconocimiento->g_point }} </td>
                                           <td>{{ $reconocimiento->sexo }} </td>
                                            <td>{{ $reconocimiento->nombre }} </td>
                                             <td>{{ $reconocimiento->descrip }} </td> 
                                            <td class="btn-group" style="display:inline-block;">                   
                                                <a href="{{ route('reconocimientos.edit', $reconocimiento->id) }}" class="btn btn-default"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                <form action="{{ route('reconocimientos.destroy', $reconocimiento->id ) }} " method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-default">
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
