@extends('layouts.admin')

<style>
    .modal-body-scroll {
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }
</style>
<!--codigo para datatables-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!--end datatables-->
@section('titulos')
<section class="content-header">
    <ol class="breadcrumb">
    <li><a href="{{ url('/backdoor') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li class="active">Usuarios</li>
    </ol>
</section>
@endsection


@section('usuarios')

@if($status)
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{$status}}
    </div>
@else

@endif

<h1>USUARIOS</h1>
@if(Session::has('grup'))
<br>
    <div class="alert alert-warning alert-dismissible fade in" role="alert" style="border-radius:15px;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong>{{Session('grup')}}</strong> 
    </div>
    @endif
<!--botones de agregar usuarios y carga masiva-->
<div class="d-grid gap-2 d-md-block">
    <div class="col-md-2" >
   <!-- <a href="{{ route('usuario.create') }}" class="btn btn-block btn-primary btn-md">Agregar Usuario</a>-->
   <a href="{{ route('usureg_admin') }}" class="btn btn-block btn-md btn-warning">Agregar Usuarios</a>
    </div>  
    <div class="col-md-2" >
    <a href="{{route('cargamasiva')}}" class="btn btn-block btn-primary btn-md">Carga Masiva</a>
    </div> 
    <div class="col-md-2" >
    <!---modal para desactivar grupos-->
    <button type="button" class=" btn btn-block btn-md" data-toggle="modal" data-target="#descat" style="background-color:#ff3b30; color:white; border-color: #af1249; border-width: 0 0 5px;">
        Desactivar
    </button>
    <div class="modal fade" id="descat" role="dialog">
        <div class="modal-dialog ">
            <div class="modal-content" style="border-radius:20px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Desactivar usuarios por grupo.</h4>
                </div>
                <div class="modal-body modal-body-scroll">
                    <p>Usted puede restringir el ingreso de todos los usuarios pertenecientes a un grupo.</p>
                     <!--tabla-->
                     <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Grupo</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($grupos as $gr)
                                <tr>
                                    <td>{{$gr->descrip}}</td>
                                    @if($gr->estado_grup == 1)
                                    <td>
                                        <a href="/activar/grupo/{{$gr->id}}" class="btn btn-success">Activado</a>
                                    </td>
                                    @else
                                    <td>
                                        <a href="/activar/grupo/{{$gr->id}}" class="btn btn-info">Desactivado</a>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                                <!-- Agrega más filas según sea necesario -->
                            </tbody>
                        </table>
                    </div>
                     <!--end tabla-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
            
        </div>
    </div>
    <!--end modal para descativar grupos-->
    </div>
  
</div>
<br>
<!--end botones-->

<div class="box box-default" style="margin-top: 5%;">
    <div class="box-header with-border">
        <div class="box-tools pull-right">
        </div>
    </div>

    <!--Mensaje de eliminar usuarios-->
    <div class="container-fluid">
    @if(Session::has('eliminado'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>{{session('eliminado')}}</strong> 
    </div>
    @endif
    </div>
    <!--mensaje de eliminar usuarios-->
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">

                <div class="box-body">
                    <div class="table-responsive" style="padding:1rem;">
                    <table class="table table-hover" id="tablaDatos">
                        <thead>
                            <tr>
                                <th>Nombres</th>
                                <th>Nombre_Usuario</th>
                                <th>Estado</th>
                                <th>Grupo</th>
                                <th>Nivel</th>
                                <th>S</th>
                                <th>G</th>
                                <th>I</th>
                                <th class="text-center">Opciones</th>     
                            </tr>
                        </thead>
                        <tbody id="tablaocu">
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                                    <td>{{ $user->username }} </td>
                                    @if($user->estado != 0)
                                    <td>Activo</td>
                                    @else
                                    <td><span  style="background-color:yellow;">Inactivo</span></td>
                                    @endif
                                    {{-- buscar el nivel del jugador --}}
                                    <?php
                                        $useravatar = App\User::find($user->id);

                                        $calculonivel = $useravatar->s_point / 100;
                                        // $nivel = number_format($calculonivel, 1);

                                        $nivel = explode(".", $calculonivel);

                                        $spointceiled = ceil($useravatar->s_point);
                                        $nivelbarra = $spointceiled % 100;
                                        $nivelbarra = ceil($nivelbarra);

                                        if ($nivelbarra == 0 && $useravatar->s_point == 0) {
                                            $nivelbarra = 0;
                                            $nivel = explode(".", $calculonivel);

                                        }elseif ($nivelbarra == 0) {
                                            $nivelbarra = 100;
                                            $nivel = explode(".", $calculonivel);
                                        }
                                    ?>
                                    <td>{{ $user->descrip }} </td>
                                    <td>{{ $nivel[0] }} </td>
                                 
                                    <td>{{ number_format($user->s_point,0, '.', '') }} </td>
                                    <td>{{ $user->g_point }} </td>
                                    <td>{{ $user->i_point }} </td>
                                    <td>  
                                    
                                    <div class="row">
                                        <div class="col-lg-4">
                                          <a type="button" href="/home/perfil/admin/{{$user->id}}" class="btn btn-success btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        </div>
                                        @if($user->username != "admin")
                                            <!--desactivar usuario -->
                                        <div class="col-lg-4">
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#deshabilitar{{$user->id}}">
                                                <i class="fa fa-user-times" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                        <!--eliminar usuario-->
                                        <div class="col-lg-4">
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#eliminar{{$user->id}}">
                                                <span class="fa fa-fw fa-trash-o" aria-hidden="true"></span>
                                            </button>
                                        </div>
                                        <!--end eliminar usuario-->
                                        @endif
                                      </div>  
                                        <!-- Modal -->
                                        <div class="modal fade" id="deshabilitar{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content" style="border-radius:20px;">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel">Deshabilitar/Habilitar Usuario: {{ $user->username }}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Al deshabilitar un usuario, este no puede ingresar a la plataforma, pero toda su información sera conservada.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                                                <a href="/deshabilitar/usuario/{{$user->id}}" type="button" class="btn btn-primary">Continuar</a>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        <!--end desactivar-->
                                         <!-- Modal eliminar -->
                                         <div class="modal fade" id="eliminar{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content" style="border-radius:20px;">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel">Eliminar Usuario: {{ $user->username }}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Al eliminar un usuario, este no puede ingresar a la plataforma y toda su información sera eliminada de la base de datos.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                                                <a href="/eliminar/usuario/{{$user->id}}" type="button" class="btn btn-primary">Continuar</a>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        
                                        <!--end modal eliminar-->
                                    </td>
    
                                </tr>
                            @endforeach
                        </tbody>
                         <!--aqui tabla para mostrar-->
                        <tbody id="tablamostrar"></tbody>
                        <!--aqui modal deshabilitar javascript-->
                        <div class="modal fade" id="deshabilitars" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content" style="border-radius:20px;">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">Deshabilitar/Habilitar Usuario: </h4>
                                </div>
                                <div class="modal-body">
                                    <p>Al deshabilitar un usuario, este no puede ingresar a la plataforma, pero toda su información sera conservada.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                                    <a href="/deshabilitar/usuario/" id="userLink" type="button" class="btn btn-primary">Continuar</a>
                                </div>
                                </div>
                            </div>
                            </div>
                            <!--end modal deshabilitar javascript-->
                       <!--aqui modal eliminar javascript-->
                        <div class="modal fade" id="eliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content" style="border-radius:20px;">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">Eliminar Usuario: </h4>
                                </div>
                                <div class="modal-body">
                                    <p>Al eliminar un usuario, este no puede ingresar a la plataforma y toda su información sera eliminada de la base de datos.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
                                    <a href="/eliminar/usuario/" id="userLinkelim" type="button" class="btn btn-primary">Continuar</a>
                                </div>
                                </div>
                            </div>
                            </div>
                            <!--end modal desh javascript-->
                        <!--end tabla para mostrar-->
                    </table>
                    </div>
                </div>                  
            </div>
            <!-- /.col -->                                
        </div>
    </div>
    <!-- /.box-body -->
</div>
<script>
    $(document).ready(function() {
      // Inicializa la DataTable
      var table = $('#tablaDatos').DataTable({
        "language": {
          "search": "Buscar en tabla:"
        }
      });

      // Evento de entrada para el campo de búsqueda
      $('#searchInput').on('input', function() {
        table.search($(this).val()).draw();
      });
    });
  </script>

@endsection