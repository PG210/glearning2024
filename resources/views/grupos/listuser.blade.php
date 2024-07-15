@extends('layouts.admin')
@section('titulos')
<section class="content-header">
    <ol class="breadcrumb">
    <li><a href="{{ url('/backdoor') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li class="active">usuarios</li>
    </ol>
</section>
@endsection
@section('cargosCreate')

<!--botones-->
<br>
<div class="row box-body">
    <div class="col-12">
         <!--mensaje-->
         @if(Session::has('datreg'))
            <div class="alert alert-warning alert-dismissible fade in" role="alert" style="border-radius:15px;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <strong>{{Session('datreg')}}</strong> 
            </div>
         @endif
        <!--end mensaje-->
     <!--end modal-->
    </div>
</div>
<!--buscar-->
<div class="box" style="background:none; margin-top:1em;">
   <div class="row box-body">
     <div class="col-md-8"><h2>Usuarios</h2></div>
      <div class="col-md-4">
        <!--buscar-->
        <form method="GET" action="{{route('buscarcor')}}">
         @csrf
        <div class="form-row">
            <div class="col-md-8">
            <input type="text" name="correo" class="form-control" placeholder="Ingrese correo" required>
            </div>
            <div class="col-md-4">
            <button class="btn btn-info float-right" type="submit">Buscar</button>
            </div>
        </div>
        </form>
        <!--end buscar-->
      </div>
    </div></div>
<!--end buscar-->
<!--end botones-->
<div class="box box-default" style="margin-top: 5%;">
   <!--table-->
   <div class="bs-example" data-example-id="striped-table">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Usuario</th>
          <th>Grupo</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $conta=1;
        ?>
        @foreach($usu as $u)
        <tr>
          <th scope="row">{{$conta++}}</th>
          <td>{{$u->nombre}}</td>
          <td>{{$u->ape}}</td>
          <td>{{$u->username}}</td>
          <td>{{$u->grupo}}</td>
          <td>
          <form action="{{route('vingrupo')}}" method="POST"> 
            @csrf
          <input value="{{$u->iduser}}" name="nomusu" hidden>
          <select class="form-control" name="opcion">
          @foreach($grupos as $g)
              @if($u->grupo != $g->descrip)
              <option value="{{$g->idgrup}}">{{$g->descrip}}</option>
              @endif
            @endforeach
           </select>
          <td>
          <button type="submit" class="btn btn-success">Confirmar</button>
          </td>
          </form>
        <!-- Button trigger modal -->
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
   <!--end table-->
</div>

@endsection















