@extends('layouts.admin')

@section('titulos')
<section class="content-header">
    <ol class="breadcrumb">
    <li><a href="{{ url('/backdoor') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li class="active">Completos</li>
    </ol>
</section>
@endsection


@section('usuarios')
<style>
  .scrollable-container {
      width: auto;
      height: 400px;
      border: 1px solid #ccc;
      overflow-y: scroll; /* Agregar scroll vertical */
    }
</style>
<div class="box box-default" style="margin-top: 5%;">
    <div class="box-header with-border">
        <div class="box-tools pull-right">
        </div>
    </div>
    <!-- /.box-header -->
      <div class="d-grid gap-2 d-md-block">
                <div class="col-md-4" >
                   <!---modal--->
                    <!-- Botón para abrir el modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#reportes">Reportes</button>
                    <div id="reportes" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <!-- Contenido del modal -->
                        <div class="modal-content"  style="border-radius:20px;">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Generar reporte de respuestas por grupo</h4>
                          </div>
                          <form method="POST" action="{{route('generatequest')}}">
                            @csrf
                          <div class="modal-body scrollable-container">
                            <!--tabla--->
                            <div class="table-responsive">
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>Grupo</th>
                                    <th>Descargar archivo</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @foreach($grup as $gmodal)
                                    <tr>
                                      <td> <input type="checkbox" id="ck{{$gmodal->id}}" name="idarchivo[]" value="{{$gmodal->id}}"></td>
                                      <td> <span>{{$gmodal->descrip}}</span></td>
                                    </tr>
                                  @endforeach
                                </tbody>
                              </table>
                            </div>
                            <!--end tabla-->
                           </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                             <button type="submit" class="btn btn-primary">Generar</button>
                          </div>
                          </form>
                        </div>

                      </div>
                    </div>
                  <!--end modal-->
                  <!--modal del filtrar-->
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#filtrar">Filtrar</button>
                    <!-- Modal -->
                    <div id="filtrar" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <!-- Contenido del modal -->
                        <div class="modal-content"  style="border-radius:20px;">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Filtrar Por Grupos</h4>
                          </div>
                          <form method="POST" action="{{route('valFormu')}}">
                          <div class="modal-body scrollable-container">
                           <!--filtro-->
                                  @csrf
                                  <div class="form-row">
                                    <div class="col-md-12">
                                      <!--end seleccionar campos-->
                                    <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                      <thead>
                                        <tr>
                                          <th>Elegir</th>
                                          <th>Nombre</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                          @foreach($grup as $g)
                                            <tr>
                                              <td> <input type="checkbox" id="check_{{$g->id}}" name="idfiltro[]" value="{{$g->id}}"></td>
                                              <td> <span>{{$g->descrip}}</span></td>
                                            </tr>
                                          @endforeach
                                        <!-- Agrega más filas según tus datos -->
                                      </tbody>
                                    </table>
                                  </div>
                                  <!--end table-->
                                    </div>
                                </div>
                            <!--end filtrar-->
                           <br>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                             <a href="/reportcompletos" class="btn btn-primary float-right" type="submit">Deshacer</a>
                            <button class="btn btn-success float-right" type="submit">Filtrar</button>
                          </div>
                          </form>
                        </div>

                      </div>
                    </div>
                  <!--end modal--> 
                  <!--end filtrar-->
                  <!--bton de filtro-->
                    <a href="{{route('porcentaje')}}" type="button" class="btn btn-warning">Porcentajes</a>
                  <!--end boton -->
               </div>  
                <div class="col-md-4" >
                </div> 
                <div class="col-md-4" >
                <!--buscar-->
                <form action="{{route('consultarter')}}" method="POST">
                 @csrf
                    <div class="form-row">
                        <div class="col-md-8">
                        <input type="text" class="form-control" placeholder="Correo, Nombre, Apellido" id="dato" name="dato" required>
                        </div>
                        <div class="col-md-4">
                        <button class="btn btn-success float-right" type="submit">Buscar</button>
                        </div>
                    </div>
                    </form>
                <!--end buscar-->
                </div>
            </div>
     <!--end cabecera-->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <h1>RETOS COMPLETOS</h1>
                <div class="box-body table-responsive" style="height:500px; overflow-y: scroll;">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Nombre de Usuario</th>
                                <th>Grupo</th>
                                <th>Estado</th>
                                <th>Nivel</th>
                                <th>Porcentaje </th>
                                <th>Puntos S</th>
                                <th>puntos I</th>
                                <th>Puntos G</th>
                                <th>Retos</th>
                            </tr>
                        </thead>
                        <tbody id="tablaocu">
                            <!--informacion de la table-->
                             @if(isset($usuarios))
                               @foreach($usuarios as $user)  
                                <tr>      
                                    <td>{{ $user->firstname }} {{ $user->lastname }} </td>                
                                    <td>{{ $user->username }} </td>
                                    <td>{{$user->descrip}}</td>
                                    @if($user->estado == 0)
                                    <td><span style="background-color:yellow">Inactivo</span></td>
                                    @else
                                    <td>Activo</td>
                                    @endif
                                    <td>{{$niveles[$user->id] ?? 0}}</td>
                                    <td>
                                    <div class="panel-group" id="accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                        <h5 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$user->id}}">Ver mas ...</a>
                                        </h5>
                                        </div>
                                        <div id="collapse{{$user->id}}" class="panel-collapse collapse">
                                        <div class="panel-body">
                                     <!--porcentajes-->
                                           @foreach($bus as $b)
                                                @if($b['usuario'] == $user->id )
                                                <?php
                                                 $por = ($b['tcom']*100)/$b['ttotal'];
                                                 $red = round($por, 1);
                                                ?>
                                             <span>Cap:</span> {{$b['capitulo']}} => {{$red}} <br>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" aria-valuenow="<?= $red ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $red ?>%; background-color:#25c5ab; color:black;">
                                                        <?= $red ?>%
                                                    </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                           <!--end porcntajes-->
                                          </div>
                                        </div>
                                       </div>
                                    </div>
                                    </td>
                                    <td>{{ round($user->s_point, 2) }} </td>
                                    <td>{{ $user->i_point }} </td>
                                    <td>{{ $user->g_point }} </td>
                                    <td><a type="button" class="btn btn-warning" href="{{ route('reportcompletos.show', $user->id) }}">
                                          Completados</a></td>
                                </tr>
                            @endforeach
                            <!--end info de la tabla-->
                            @endif
                            @if(isset($resultado))
                             @foreach ($resultado as $nivel1)
                                      @foreach ($nivel1 as $res) 
                                          <tr>      
                                           <td>{{ $res->firstname }} {{ $res->lastname }} </td> 
                                           <td>{{ $res->username }} </td>
                                            <td>{{ $res->descrip}}</td>
                                             @if($res->estado == 0)
                                            <td><span style="background-color:yellow">Inactivo</span></td>
                                            @else
                                            <td>Activo</td>
                                            @endif
                                            <td>{{ $niveles[$res->id] ?? 0}}</td>
                                            <!--aqui validar que ya completamos-->
                                            <td>
                                            <div class="panel-group" id="accordion">
                                              <div class="panel panel-default">
                                                  <div class="panel-heading">
                                                  <h5 class="panel-title">
                                                      <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$res->id}}">Ver mas ...</a>
                                                  </h5>
                                                  </div>
                                                  <div id="collapse{{$res->id}}" class="panel-collapse collapse">
                                                  <div class="panel-body">
                                                    <!--porcentajes-->
                                                 @foreach($bus as $b)
                                                          @if($b['usuario'] == $res->id )
                                                          <?php
                                                          $por = ($b['tcom']*100)/$b['ttotal'];
                                                          $red = round($por, 1);
                                                          ?>
                                                          <span>Cap:</span> {{$b['capitulo']}} => {{$red}} <br>
                                                          <div class="progress">
                                                              <div class="progress-bar" role="progressbar" aria-valuenow="<?= $red ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $red ?>%; background-color:#25c5ab; color:black;">
                                                                  <?= $red ?>%
                                                              </div>
                                                              </div>
                                                          @endif
                                                      @endforeach
                                                    <!--end porcntajes-->
                                                    </div>
                                                  </div>
                                              </div>
                                              </div>
                                              </td>
                                            <!-- aqui finaliza validacion-->
                                            <td>{{ round($res->s_point, 2) }} </td>
                                            <td>{{ $res->i_point }} </td>
                                            <td>{{ $res->g_point }} </td>
                                            <td><a type="button" class="btn btn-warning" href="{{ route('reportcompletos.show', $res->id) }}">
                                                  Completados</a>
                                            </td>
                                          </tr>
                                       @endforeach
                                   @endforeach
                            @endif
                        </tbody>
                         <tbody id="tablamostrar"></tbody>
                    </table>
                     <!---links-->
                      
                     <!--end links-->
                </div>
            </div>
            <!-- /.col -->
            {{--
           <div class="col-2">
              <a href="{{route('creartxt')}}" type="button" class="btn btn-success">Generar</a>
              <a href="/informe/archivo.txt" type="button" class="btn btn-primary" download>Download</a>
            </div> --}} 

                                
        </div>
    </div>
    <!-- /.box-body -->
</div>
<script>
  /*tomamos la información del formulario y la enviamos a la ruta y de la ruta al controlador*/
  $('#buscar').submit(function(e){
    e.preventDefault();
    var dato=$('#dato').val();
    console.log(dato);
    var _token = $('input[name=_token]').val();
    $.ajax({
      url:"{{route('buscar_usuario')}}",
      type: "POST",
      data:{
        dato:dato,
        _token:_token,
      }
      }).done(function(response){
       var arreglo = JSON.parse(response);
       var conta=0;
       if(arreglo.length!=0){
         $("#tablaocu").hide();
         $("#tablamostrar").empty();
        //aqui imprime los datos 
             var calculonivel = Math.round(arreglo[0].s_point)/100;
             var cniv = calculonivel.toString();
             var nivel = cniv.split(".");
                var valor = '<tr>' +
                '<td>' + arreglo[0].firstname + ' ' + arreglo[0].lastname + '</td>' +
                '<td>' + arreglo[0].username + '</td>' +
                '<td>' + arreglo[0].email + '</td>' +
                '<td>' + arreglo[0].descrip + '</td>' + 
                '<td>' + nivel[0] + ' </td>' +
                '<td>' + Math.round(arreglo[0].s_point) + '</td>' +
                '<td>' + arreglo[0].g_point + '</td>' +
                '<td>' + arreglo[0].i_point + ' </td>' +
                '<td>' + arreglo[0].g_point + '</td>' +
                 '<td> <a href="/reportcompletos/retos/'+arreglo[0].id+'" class="btn btn-warning">Completos</a> </td>' + 
                '</tr>';
                
            $('#tablamostrar').append(valor);
            toastr.success('Username: ' + arreglo[0].username +'&nbsp;', 'Usuario encontrado', {timeOut:3000});
        //finalizar impresion datos
          }else{
         $("#tablaocu").show();
         toastr.warning('Lo sentimos!', 'Datos no encontrados', {timeOut:3000});
       }
         
    }).fail(function(jqXHR, response){
        $("#tablaocu").show();
        $("#tablamostrar").empty();
          toastr.warning('Lo sentimos!', 'Datos no encontrados', {timeOut:3000});
       
      });
  });

//###########################################
  $(document).ready(function() {
  $("#filter-icon").click(function() {
    $("#filter-select").toggle();
    });
  });
 </script>
<script>
  $(document).ready(function() {
    $("#filter-select").change(function() {
      var selectedOption = $(this).val();
      // Realizar la solicitud AJAX al controlador
      $.ajax({
        url: '/reportcompletos/grupo/' + selectedOption,  // Reemplaza con la ruta adecuada
        type: 'GET',  // Reemplaza con el tipo de solicitud que necesites (GET, POST, PUT, DELETE, etc.)
        success: function(response) {
          // Manejar la respuesta del controlador aquí
          var arreglo = JSON.parse(response);
          var conta=0;
          var calculonivel = 0;
          var cniv = 0;
          var nivel = 0;
          if(arreglo.length!=0){
            $("#tablaocu").hide();
            $("#tablamostrar").empty();
            //aqui imprime los datos 
            for(var i=0; i<arreglo.length; i++){
                    calculonivel = Math.floor(arreglo[i].s_point)/100;
                    cniv = calculonivel.toString();
                    nivel = cniv.split(".");
                    var valor = '<tr>' +
                    '<td>' + arreglo[i].firstname + ' ' + arreglo[i].lastname + '</td>' +
                    '<td>' + arreglo[i].username + '</td>' +
                    '<td>' + arreglo[i].email + '</td>' +
                    '<td>' + arreglo[i].descrip + '</td>' +
                    '<td> '+ nivel[0] +'</td>' +
                    '<td>' + Math.round(arreglo[i].s_point) + '</td>' +
                    '<td>' + arreglo[i].i_point + ' </td>' +
                    '<td>' + arreglo[i].g_point + '</td>' +
                    '<td> <a href="/reportcompletos/retos/'+arreglo[i].id+'" class="btn btn-warning">Completados</a> </td>' + 
                    '</tr>';
                     $('#tablamostrar').append(valor);
            }
         }else{
            $("#tablaocu").hide();
            $("#tablamostrar").empty();
            toastr.warning('No hay ususarios en el grupo', 'Lo sentimos!', {timeOut:3000});
         }
        },
         error: function(xhr) {
          // Manejar el error en caso de que ocurra
          // console.log(xhr.responseText);
        }
      });
    });
  });
</script>


@endsection

