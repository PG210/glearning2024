@extends('layouts.admin')

@section('titulos')
<section class="content-header">
    <ol class="breadcrumb">
    <li><a href="{{ url('/backdoor') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
     <li class="active">Notificaciones</li>
    </ol>
</section>
@endsection

@section('areas')

<style>
     .cke_notifications_area{
        display: none;
        }
</style>

<div class="box box-default" style="margin-top: 5%;">
    <div class="box-header with-border">
        <div class="box-tools pull-right">
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <h1>Recordatorios de ingreso y reconocimiento.</h1>

                <div class="row">
                    <div class="col-md-2" >
                        <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#agregarevento">
                         <i class="fa fa-plus"></i> Agregar
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="agregarevento" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                            
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title" style="color: #333333">Agregar Nuevo Mensaje</h4>
                            </div>
                            
                            <form action="{{route('recordatorio')}}" method="POST">
                                @csrf
                                <div class="modal-body">

                                <div class="row">
                                    <div class="form-group col-md-6">
                                    <label for="tipo">Tipo <i class="fa fa-info-circle" data-toggle="tooltip" title="Seleccionar el tipo de mensaje"></i></label>
                                    <select class="form-control" id="tipo" name="tipo" required>
                                        <option value="">Elegir ...</option>
                                        @foreach ($opciones as $valor => $texto)
                                            <option value="{{ $valor }}">{{ $texto }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                    <label for="tem">Tiempo o frecuencia (días) <i class="fa fa-info-circle" data-toggle="tooltip" title="Número de días sin acceso a la plataforma o sin enviar reconocimientos"></i></label>
                                    <select class="form-control" id="tem" name="tem" required>
                                        <option value="">Elegir ...</option>
                                        @foreach ($frecuencia as $numero)
                                            <option value="{{ $numero }}">{{ $numero }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                    <label for="dia">Día <i class="fa fa-info-circle" data-toggle="tooltip" title="Día de la semana en que se envía el mensaje"></i></label>
                                    <select class="form-control" id="dia" name="dia" required>
                                        <option value="">Elegir ...</option>
                                        @foreach ($diasemana as $numero => $dia)
                                            <option value="{{ $numero }}">{{ $dia }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                    <label for="hora">Hora <i class="fa fa-info-circle" data-toggle="tooltip" title="Hora del día en que se envía el mensaje"></i></label>
                                    <input type="time" name="hora" id="hora" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-12">
                                    <label for="contenido">Descripción <i class="fa fa-info-circle" data-toggle="tooltip" title="Describa el mensaje a enviar"></i></label>
                                    <textarea name="contenido" id="contenido" rows="10" class="form-control">{{ old('contenido') }}</textarea>
                                    </div>
                                </div>

                                </div>

                                <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                                <button type="submit" class="btn btn-success">Adicionar</button>
                                </div>
                            </form>

                            </div>
                        </div>
                        </div>
                        <!--end modal-->
                    </div>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Tiempo (Dias)</th>
                            <th>Día y hora</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $dat)
                        <tr>
                            <td>
                           
                            @foreach ($opciones as $valor => $texto)
                              @if($dat->tipo == $valor)
                                <option value="{{ $valor }}">{{ $texto }}</option>
                              @endif
                            @endforeach
                            </td>
                            <td>
                            {!! $dat->contenido !!}
                            </td>
                            <td>
                            <span>{{  $dat->tiempo }}</span>
                            </td>
                            <td>
                            @foreach ($diasemana as $numero => $dia)
                               @if($dat->dia == $numero)
                               <span>{{ $dia }}</span>
                               @endif
                            @endforeach
                            
                            <span> - {{ \Carbon\Carbon::createFromFormat('H:i:s', $dat->hora)->format('g:i A') }} </span>
                            </td>
                            <td>
                                <!---modal para confirmacion-->
                                <button type="button" class=" btn-xs" data-toggle="modal" data-target="#deleteMen{{ $dat->id }}">
                                    <i class="fa fa-trash"></i>
                                </button>

                                <div class="modal fade" id="deleteMen{{ $dat->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $dat->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title" id="modalLabel{{ $dat->id }}">Mensaje de confirmación</h4>
                                    </div>
                                    <div class="modal-body text-left">
                                        <p>¿Estás seguro de que deseas eliminar este mensaje?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        <form action="{{ route('deleteMensaje') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" value="{{ $dat->id }}" name="idmen" id="idmen{{ $dat->id }}">
                                        <button type="submit" class="btn btn-success">Eliminar</button>
                                        </form>
                                    </div>
                                    </div>
                                </div>
                                </div>
                                <!--end modal confirmacion-->

                                <button type="button" class=" btn-xs" data-toggle="modal" data-target="#editarEvento{{ $dat->id }}">
                                <i class="fa fa-edit"></i>
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="editarEvento{{ $dat->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                    
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title" style="color: #333333">Agregar Nuevo Mensaje</h4>
                                    </div>
                                    
                                    <form action="{{route('upRecordatorio')}}" method="POST">
                                        @csrf
                                        <div class="modal-body">

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                            <label for="tipo">Tipo <i class="fa fa-info-circle" data-toggle="tooltip" title="Seleccionar el tipo de mensaje"></i></label>
                                            <select class="form-control" id="tipoup{{ $dat->id }}" name="tipoup" required>
                                            @foreach ($opciones as $valor => $texto)
                                                <option value="{{ $valor }}" @if ($dat->tipo == $valor) selected @endif>
                                                    {{ $texto }}
                                                </option>
                                            @endforeach
                                            </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                            <label for="tem">Tiempo o frecuencia (días) <i class="fa fa-info-circle" data-toggle="tooltip" title="Número de días sin acceso a la plataforma o sin enviar reconocimientos"></i></label>
                                            <select class="form-control" id="temup{{ $dat->id }}" name="temup" required>
                                                <option value="">Elegir ...</option>
                                                @foreach ($frecuencia as $numero)
                                                    <option value="{{ $numero }}"  @if ($dat->tiempo == $numero) selected @endif>{{ $numero }}</option>
                                                @endforeach
                                            </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                            <label for="dia">Día <i class="fa fa-info-circle" data-toggle="tooltip" title="Día de la semana en que se envía el mensaje"></i></label>
                                            <select class="form-control" id="diaup{{ $dat->id }}" name="diaup" required>
                                            @foreach ($diasemana as $numero => $dia)
                                                <option value="{{ $numero }}"  @if ($dat->dia == $numero) selected @endif>{{ $dia }}</option>
                                            @endforeach
                                            </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                            <label for="hora">Hora <i class="fa fa-info-circle" data-toggle="tooltip" title="Hora del día en que se envía el mensaje"></i></label>
                                            <input type="time" name="horaup" id="horaup{{ $dat->id }}" class="form-control" value="{{ $dat->hora }}" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-12">
                                            <label for="contenido">Descripción <i class="fa fa-info-circle" data-toggle="tooltip" title="Describa el mensaje a enviar"></i></label>
                                            <textarea name="contenidoup" id="contenidoup{{ $dat->id }}" rows="5" class="form-control"> {!! $dat->contenido !!}</textarea>
                                            </div>
                                        </div>

                                        </div>
                                        <input type="hidden" id="idup{{ $dat->id }}" name="idup" value="{{ $dat->id }}" required>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                                        <button type="submit" class="btn btn-success">Actualizar</button>
                                        </div>
                                    </form>

                                    </div>
                                </div>
                                </div>
                                <!--end modal-->

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>        
            </div>
            <!-- /.col -->                                
        </div>
    </div>
    <!-- /.box-body -->
</div>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('contenido');
</script>
@endsection
