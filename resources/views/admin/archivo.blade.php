@extends('layouts.admin')

@section('retos')


<div class="box box-default" style="margin-top: 5%;">
    <div class="box-header with-border">
        <div class="box-tools pull-right">
        </div>
    </div>
    <div style="padding:2rem;">
    <form method="POST" action="{{route('subirFile')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="uploadedfile">Eliga un archivo zip</label>
            <input type="file" name="uploadedfile" id="uploadedfile" accept=".zip" class="form-control-file" required>
        </div>
        <div class="form-group">
            <label for="nombre">Descripciòn</label>
            <input type="text" name="descrip" id="descrip" class="form-control-file" required>
        </div>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button class="btn btn-info" type="submit"><span>Guardar</span></button>
        </div>
    </form>
    </div>
    <!--- prueba de impresion en el iframe-->
      <!--- inicar capitulos --> 
      @foreach($rutas as $ruta)
        <iframe src="{{ asset('capsulas/' . $ruta->ruta . '/story.html') }}" width="100%" height="500px"></iframe>
      @endforeach

      <iframe src="{{ asset('capsulas/' . $rutas[1]->ruta . '/res/index.html') }}" width="100%" height="500px"></iframe>
      <!---en iniciar capitulos-->
    <!---end prueba-->
</div>

@endsection

