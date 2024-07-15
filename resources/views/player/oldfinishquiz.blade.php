@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/magic-master/magic.css') }}">

<style media="screen">
  .cajita{
    position: relative;
    width: 100%;
    height: 15vh;
  }
  .pend{
    width: 10em;
    background-color: #fb1515;
    font-size: 3em;
    text-align: center;
    color: white;
    z-index: 1;
    position: absolute;
    border-radius: 1px 49px;
    font-family: effortless;
  }
  .comp{
    background-color: #0fb70f;
    font-size: 3em;
    text-align: center;
    color: white;
    z-index: 0;
    width: 10em;
    position: absolute;
    border-radius: 1px 49px;
    font-family: effortless;
  }
/* cambiar de color */
  @keyframes blink {
      0% { opacity: 0; color: red; }
      50% { opacity: 1; color: blue; }
      100% { opacity: 0; color: green; }
    }
    .blinking {
      animation: blink 1s infinite;
    }
 /*mover emoticones */
    @keyframes moveLeft {
      from { transform: translateX(100%); }
      to { transform: translateX(-100%); }
    }

    .moving-emoticon {
      animation: moveLeft 5s linear infinite;
      font-size: 24px;
      display: inline-block;
    }
</style>

@section('content')
    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">

  </section>

  <!-- Main content -->
  <section class="content">

     <!-- /.row -->

    <div class="col-md-12" style="text-align: -webkit-center;">

        {{-- <h1>FELICITACIONES {{ Auth::user()->firstname }}, SEGUIMOS AVANZANDO</h1>

        <div class="row">
          <div class="col-md-12">
            <h2>El reto: <strong>{{ $retos->name }}</strong> esta ahora: </h2>

            <div class="cajita" style="padding: 0% 28% 0% 29%;">
              <div class="comp">COMPLETO</div>
              <div class="pend">PENDIENTE</div>
            </div>

            <script type="application/javascript">
              setTimeout(function(){
                $('.pend').addClass('magictime boingOutDown');
              }, 1500);
            </script>

          </div>
        </div>

        <div class="row">
          <div class="col-md-12" style="padding-bottom: 6%;">
            <h3>TU MISIÓN HA FINALIZADO… POR AHORA</h3>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12" style="padding-bottom: 6%;">
            <div class="col-md-3"></div>
            <div class="col-md-2">
              <p>
                PUNTOS I : <span class="punti">{{ number_format($puntos_i, 0) }}</span>
              </p>
            </div>
            <div class="col-md-2">
              <p>
                PUNTOS G : <span class="puntg">{{ number_format($puntos_g, 0) }}</span>
              </p>
            </div>
            <div class="col-md-2">
              <p>
                PUNTOS S : <span class="punts">{{ number_format($puntos_s, 0) }}</span>
              </p>
            </div>
            <div class="col-md-3"></div>

          </div>
        </div>
        <a class="btn btn-success btn-lg" href="https://glearning.com.co/playerchallenge/{{ $subcapitulo }}">Volver al Tema</a> --}}
    </div>
    <!-- /.col -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
 //$avatarimage = App\Avatar::find(Auth::user()->avatar_id);
 $imavatar = Auth::user()->imgavat;
?>


{{-- ACTIVAR EL POPUP SI HA OBTENIDO INSIGNIAS NUEVAS --}}

@if ($insigniapopup == 1)
 <div class="hidden-xs">
  <audio controls autoplay>
    <source src="https://commondatastorage.googleapis.com/codeskulptor-demos/riceracer_assets/music/win.ogg" type="audio/ogg">
  </audio>
  <div class="modal modal-info fade in" id="modal-info" style="display: block; padding-right: 15px;">
    <div class="modal-dialog" style="border-radius: 27px; width: 69%;">
      <div class="modal-content" style="text-align: center; border-radius: 21px; background-color: #ff7737!important;">
        <div class="modal-header" style="border-radius: 16px; background-color: #942f11!important;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">FELICITACIONES {{ Auth::user()->firstname }}</h4>
          @if($mensaje != 0)
            <h3 class="text-center blinking">&#127881; &#128522; CAPÍTULO {{$cap}} TERMINADO &#128522; &#127881;</h3>
          @endif
        </div>
        <div class="modal-body" style="height: 60%; background-color: #ff7737!important;">

          <div class="row">
            <div class="col-md-6">  
              <h1>Has recibido una nueva insignia:</h1>
              <img style="width: 20%;" src="{{ asset($insigniawon) }}" alt="Felicidades">
              <h3> {{ $insignianamewon }} </h3>   
              <p>{{ $insigniadescwon }} </p>         
            </div>
            <div class="col-md-6">
              <h2>Sigues avanzando, has sumado los siguientes puntos: por completar este reto:</h2>
              <h3 style="color:#fbff05;">{{ $retos->name }} </h3>      
              
              <div class="col-md-4">
                <p>
                  PUNTOS I : 
                </p>
                <span class="punti">{{ number_format($puntos_i, 0) }}</span>
              </div>
              <div class="col-md-4">
                <p>
                  PUNTOS G : 
                </p>
                <span class="puntg">{{ number_format($puntos_g, 0) }}</span>
              </div>
              <div class="col-md-4">
                <p>                
                  PUNTOS S : 
                </p>
                <span class="punts">{{ number_format($puntos_s, 0) }}</span>
              </div>
              <div class="col-md-12" style="margin: 0% 0% 2% 0% "></div>  
            </div>
          </div>
        
        </div>
        <div class="modal-footer" style="border-radius: 14px; background-color: #942f11!important;">
          {{-- <button type="button" class="btn btn-danger btn-lg pull-left" data-dismiss="modal">Cerrar</button> --}}
<!--<a class="btn btn-success btn-lg" href="http://evolucion.website/playerchallenge/{{ $subcapitulo }}"> VOLVER </a>-->
        <a class="btn btn-success btn-lg" href="https://glearning.com.co/playerchallenge/{{ $subcapitulo }}"> VOLVER </a>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
 </div>
@endif




{{-- ACTIVAR EL POPUP SI HA OBTENIDO RECONOCIMIENTOS NUEVOS --}}
@if ($recompensapopup == 1)
 <div class="hidden-xs">
  <audio controls autoplay>
    <source src="https://commondatastorage.googleapis.com/codeskulptor-demos/riceracer_assets/music/win.ogg" type="audio/ogg">
  </audio>
  <div class="modal modal-info fade in" id="modal-info" style="display: block; padding-right: 15px;">
    <div class="modal-dialog" style="border-radius: 27px; width: 69%;">
      <div class="modal-content" style="text-align: center; border-radius: 21px; background-color: #56aab5!important;">
        <div class="modal-header" style="border-radius: 16px; background-color: #0d4856!important;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"> × </span></button>
          <h4 class="modal-title">FELICITACIONES {{ Auth::user()->firstname }}</h4>
         @if($mensaje != 0)
          <h3 class="text-center blinking">&#127881; &#128522; CAPÍTULO {{$cap}} TERMINADO &#128522; &#127881;</h3>
         @endif
        </div>
        <div class="modal-body" style="height: 65%; background-color: #56aab5!important;">

          <div class="row">
            <div class="col-md-6">              
              <h1>Has recibido un accesorio para fortalecerte:</h1>
              <img style="width: 35%; height:35%;" src="{{ asset($recompensawon) }}" alt="Felicidades">
              <h3> {{ $recompensanamewon }} </h3>
            </div>
            <div class="col-md-6">
              <h2>Sigues avanzando, has sumado los siguientes puntos: por completar este reto:</h2>
              <h3 style="color:#fbff05;">{{ $retos->name }} </h3>      
              
              <div class="col-md-4">
                <p>
                  PUNTOS I : 
                </p>
                <span class="punti">{{ number_format($puntos_i, 0) }}</span>
              </div>
              <div class="col-md-4">
                <p>
                  PUNTOS G : 
                </p>
                <span class="puntg">{{ number_format($puntos_g, 0) }}</span>
              </div>
              <div class="col-md-4">
                <p>                
                  PUNTOS S : 
                </p>
                <span class="punts">{{ number_format($puntos_s, 0) }}</span>
              </div>
  
              <div class="col-md-12" style="margin: 0% 0% 2% 0% "></div>
  
            </div>
          </div>
        </div>
        <div class="modal-footer" style="border-radius: 14px; background-color: #0d4856!important;">
          {{-- <button type="button" class="btn btn-danger btn-lg pull-left" data-dismiss="modal">Cerrar</button> --}}
         <!-- <a class="btn btn-success btn-lg" href="http://evolucion.website/playerchallenge/{{ $subcapitulo }}"> VOLVER </a>    
        -->
        <a class="btn btn-success btn-lg" href="https://glearning.com.co/playerchallenge/{{ $subcapitulo }}"> VOLVER </a>
          </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>
@endif



{{-- ACTIVAR EL POPUP SI HA SUBIDO DE NIVELES --}}
@if ($leveluppopup == 1)
<div class="hidden-xs">
<audio controls autoplay>
  <source src="https://commondatastorage.googleapis.com/codeskulptor-demos/riceracer_assets/music/win.ogg" type="audio/ogg">
</audio>
  <div class="modal modal-info fade in" id="modal-info" style="display: block; padding-right: 15px;">
    <div class="modal-dialog" style="border-radius: 27px; width: 69%;">
      <div class="modal-content" style="text-align: center; border-radius: 21px; background-color: #a74fea;">
        <div class="modal-header" style="border-radius: 16px; background-color: #8200e4!important;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">FELICITACIONES {{ Auth::user()->firstname }}</h4>
         @if($mensaje != 0)
           <h3 class="text-center blinking">&#127881; &#128522; CAPÍTULO {{$cap}} TERMINADO &#128522; &#127881;</h3>
         @endif
        </div>
        <div class="modal-body" style="height: 65%; background-color: #a74fea!important;">
          <!--cuerpo del modal-->
          <div class="table-responsive" style="border:0px; overflow-x: hidden;">
            <table class="table">
              <tbody>
                <tr>
                  <td rowspan="3" style="border-top:0px;">
                  @if($insigniapopup == 0 && $recompensapopup == 0)
                   <h1>Has pasado al siguiente Nivel:</h1>
                    <div class="text-center">
                    <img src="{{ asset($imavatar) }}" alt="Felicidades" style=" width: 32%; border-radius: 48%; border: 4px solid #be18d2;">
                  </div>
                  @endif
                  <!--si gano una insignia -->
                    @if($insigniapopup == 1)
                    <div class="col-md-6">  
                        <h4>Has recibido una nueva insignia:</h4>
                        <img style="width: 70%; height:50%;" src="{{ asset($insigniawon) }}" alt="Felicidades">
                        <h4> {{ $insignianamewon }} </h4>            
                    </div> 
                    @endif
                    @if ($recompensapopup == 1)
                      <h4>Has recibido un accesorio para fortalecerte:</h4>
                      <img style="width: 30%; height:30%;" src="{{ asset($recompensawon) }}" alt="Felicidades">
                      <h4> {{ $recompensanamewon }} </h4>
                    @endif
                  <!--end si gano una insignia-->
                   <!--si termino el capitulo darle -->
                   @if(isset($inscap))
                      @if($inscap != "")
                      <div class="text-center">
                        <h4>¡Felicidades! Ganaste una insignia.</h4>
                        <img style=" width: 32%; border-radius: 48%; border: 4px solid #be18d2; background-color:#A74FEA;" src="/insigcap/{{$inscap[0]->url}}" alt="Felicidades">
                        <h4> {{ $inscap[0]->nombre }} </h4>
                        <i class="fa fa-share"></i>
                        <a href="/ver/insignia/{{$inscap[0]->id}}" style="font-size:20px; color:#FBFF05;" target="_blank"><i class="bi bi-linkedin"></i> Compartir</a>
                      </div>
                      @endif
                   @endif
                  <!--end insignia capitulo--->
                  </td>
                  <td style="border-top:0px;" class="text-center">
                    <h2 class="text-center visible-lg">Sigues avanzando, has sumado los siguientes puntos: por completar este reto:</h2>
                    <h3 class="text-center hidden-lg">Sigues avanzando, </h3>
                    <h3 class="text-center hidden-lg">Has sumado los siguientes puntos:</h3>
                    <h3 class="text-center hidden-lg">Por completar este reto:</h3>
                    </td>
                </tr>
                <tr>
                
                  <td style="border-top:0px;"><h3 class="text-center" style="color:#fbff05;">{{ $retos->name }} </h3> </td>
                </tr>
                <tr>
                  <td style="border-top:0px;" class="text-center">
                    <div class="row">
                      <div class="col-md-4">
                          <p>
                            PUNTOS I : <br>
                          </p>
                          <span class="punti visible-lg">{{ number_format($puntos_i, 0) }}</span>
                          <span class="hidden-lg" style="background:#FFD700;  padding: 1% 1%; margin: 0 auto 0 3%; border-radius: 80px;">{{ number_format($puntos_i, 0) }}</span>
                      </div>
                      <div class="col-md-4">
                          <p>
                            PUNTOS G : <br> 
                          </p>
                          <span class="puntg visible-lg">{{ number_format($puntos_g, 0) }}</span>
                          <span class="hidden-lg" style="background:#FFD700; padding: 1% 1%; margin: 0 auto 0 3%; border-radius: 80px;">{{ number_format($puntos_g, 0) }}</span>
                      </div>
                      <div class="col-md-4">
                          <p>                
                            PUNTOS S :  <br>
                          </p>
                          <span class="punts visible-lg">{{ number_format($puntos_s, 0) }}</span>
                          <span class="hidden-lg" style="background:#FFD700;  padding: 1% 1%; margin: 0 auto 0 3%; border-radius: 80px;">{{ number_format($puntos_s, 0) }}</span>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
            

          <!--end cuerpo del modal-->
        </div>
        <div class="modal-footer" style="border-radius: 14px; background-color: #8200e4!important;">
          {{-- <button type="button" class="btn btn-danger btn-lg pull-left" data-dismiss="modal">Cerrar</button> --}}
          <!--<a class="btn btn-success btn-lg" href="http://evolucion.website/playerchallenge/{{ $subcapitulo }}"> VOLVER </a>-->
          <a class="btn btn-success btn-lg" href="/playerchallenge/{{ $subcapitulo }}"> VOLVER </a>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>
@endif



{{-- ACTIVAR EL POPUP SI HA PASADO EL RETO --}}
@if ($passretouppopup == 1)
<div class="hidden-xs">
<audio controls autoplay>
  <source src="https://commondatastorage.googleapis.com/codeskulptor-demos/riceracer_assets/music/win.ogg" type="audio/ogg">
</audio>
  <div class="modal modal-info fade in" id="modal-info" style="display: block; padding-right: 15px;">
    <div class="modal-dialog modal-lg" style="border-radius: 27px; width: 75%;">
      <div class="modal-content" style="text-align: center; border-radius: 21px; background-color: #a74fea;">
        <div class="modal-header" style="border-radius: 16px; background-color: #8200e4!important;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">FELICITACIONES {{ Auth::user()->firstname }}</h4>
          @if($mensaje != 0)
            <h3 class="text-center blinking">&#127881; &#128522; CAPÍTULO {{$cap}} TERMINADO &#128522; &#127881;</h3>
          @endif
        </div>
        <div class="modal-body" style="height: 65%; background-color: #a74fea!important;">
         <!--aqui contenido modal-->
         <div class="container-fluid">
         <div class="table-responsive" style="border:0px; overflow-x: hidden;">
         <table class="table">
          <tbody>
            <tr>
              <td rowspan="3" style="border-top:0px;">
              @if($insigniapopup == 0 && $recompensapopup == 0)
                <h1 readonly >HAS PASADO EL RETO</h1>
                <div class="text-center">
                 <img src="{{ asset($imavatar) }}" alt="Felicidades" style=" width: 32%; border-radius: 48%; border: 4px solid #be18d2;">
               </div>
               @endif
               <!--validar si gano insignia--> 
                 @if($insigniapopup == 1)
                    <div class="col-md-6">  
                        <h4>Has recibido una nueva insignia:</h4>
                        <img style="width: 70%; height:50%;" src="{{ asset($insigniawon) }}" alt="Felicidades">
                        <h4> {{ $insignianamewon }} </h4>            
                    </div> 
                    @endif
                    @if ($recompensapopup == 1)
                      <h4>Has recibido un accesorio para fortalecerte:</h4>
                      <img style="width: 30%; height:30%;" src="{{ asset($recompensawon) }}" alt="Felicidades">
                      <h4> {{ $recompensanamewon }} </h4>
                    @endif
               <!--end validar si gano insignia-->
               <!--si termino el capitulo darle -->
                   @if(isset($inscap))
                      @if($inscap != "")
                      <div class="text-center">
                        <h4>¡Felicidades! Ganaste una insignia.</h4>
                        <img style=" width: 32%; border-radius: 48%; border: 4px solid #be18d2; background-color:#A74FEA;" src="/insigcap/{{$inscap[0]->url}}" alt="Felicidades">
                        <h4> {{ $inscap[0]->nombre }} </h4>
                        <i class="fa fa-share"></i>
                        <a href="/ver/insignia/{{$inscap[0]->id}}" style="font-size:20px; color:#FBFF05;" target="_blank"><i class="bi bi-linkedin"></i> Compartir</a>
                      </div>
                      @endif
                   @endif
                  <!--end insignia capitulo--->
              </td>
              <td style="border-top:0px;" class="text-center">
                 <h2 class="text-center visible-lg">Sigues avanzando, has sumado los siguientes puntos: por completar este reto:</h2>
                 <h3 class="text-center hidden-lg">Sigues avanzando</h3>
                 <h3 class="text-center hidden-lg">Has sumado los siguientes puntos:</h3>
                 <h3 class="text-center hidden-lg">Por completar este reto:</h3>
                </td>
            </tr>
            <tr>
             
              <td style="border-top:0px;"> <h3 class="text-center" style="color:#fbff05;">{{ $retos->name }} </h3></td>
            </tr>
            <tr>
              <td style="border-top:0px;" class="text-center">
                <div class="row">
                  <div class="col-md-4">
                      <p>
                        PUNTOS I : <br>
                      </p>
                      <span class="punti visible-lg">{{ number_format($puntos_i, 0) }}</span>
                      <span class="hidden-lg" style="background:#FFD700;  padding: 1% 1%; margin: 0 auto 0 3%; border-radius: 80px;">{{ number_format($puntos_i, 0) }}</span>
                  </div>
                  <div class="col-md-4">
                      <p>
                        PUNTOS G : <br> 
                      </p>
                      <span class="puntg visible-lg">{{ number_format($puntos_g, 0) }}</span>
                      <span class="hidden-lg" style="background:#FFD700; padding: 1% 1%; margin: 0 auto 0 3%; border-radius: 80px;">{{ number_format($puntos_g, 0) }}</span>
                  </div>
                  <div class="col-md-4">
                      <p>                
                        PUNTOS S :  <br>
                      </p>
                      <span class="punts visible-lg">{{ number_format($puntos_s, 0) }}</span>
                      <span class="hidden-lg" style="background:#FFD700;  padding: 1% 1%; margin: 0 auto 0 3%; border-radius: 80px;">{{ number_format($puntos_s, 0) }}</span>
                  </div>
                    </div>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
         
          <!--end table-->
        </div>
        <div class="modal-footer" style="border-radius: 14px; background-color: #8200e4!important;">
          {{-- <button type="button" class="btn btn-danger btn-lg pull-left" data-dismiss="modal">Cerrar</button> --}}
          <!--<a class="btn btn-success btn-lg" href="http://evolucion.website/playerchallenge/{{ $subcapitulo }}"> VOLVER </a>-->
         <a class="btn btn-success btn-lg" href="/playerchallenge/{{ $subcapitulo }}"> VOLVER </a>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>
@endif

<!--=================== Pantallas de elular ======================-->
@if($passretouppopup == 1 || $leveluppopup == 1 ||$recompensapopup == 1 || $insigniapopup == 1)
<div class="visible-xs">
<!--modal-->
<div class="modal modal-info fade in" id="modal-info" style="display: block;  overflow-x: hidden; ">
    <div class="modal-dialog modal-lg" style="border-radius: 27px;">
      <div class="modal-content" style="text-align: center; border-radius: 21px; background-color: #a74fea;">
        <div class="modal-header" style="border-radius: 16px; background-color: #8200e4!important;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">×</span></button>
            <h4 class="modal-title">FELICITACIONES {{ Auth::user()->firstname }}</h4>
          @if($mensaje != 0)
          <h3 class="text-center blinking">&#127881; &#128522; CAPÍTULO {{$cap}} TERMINADO &#128522; &#127881;</h3>
          @endif
        </div>
          <div class="modal-body" style="height: 65%; background-color: #a74fea!important;">
         <!--aqui contenido modal-->
         <div class="container-fluid">
            <div class="table-responsive" style="border:0px; overflow-x: hidden;">
               <!--avatar--->
               <div class="row">
               <div  class="col-md-4">
                 @if($insigniapopup == 0 && $recompensapopup == 0)
                   <h4 readonly >RETO SUPERADO</h4>
                   <div class="text-center">
                    <img src="{{ asset($imavatar) }}" alt="Felicidades" class="img-responsive" style="width: 32%; border-radius: 48%; border: 4px solid #be18d2;">
                    </div>
                  @endif
                  </div>
                 <div  class="col-md-4">
                 <!--SI RECIBIO UNA INSIGNIA-->
                @if($insigniapopup == 1)
                    <div class="col-md-6">  
                        <h4>INSIGNIA OBTENIDA</h4>
                        <img  src="{{ asset($insigniawon) }}" class="img-responsive" style="width: 32%;" alt="Felicidades">
                        <h4> {{ $insignianamewon }} </h4>            
                    </div> 
                    @endif
                 <!--END INSIGNIA-->
                 </div>
                  <div  class="col-md-4">
                  <!--RECOMPENSA-->
                  @if ($recompensapopup == 1)
                      <h4>NUEVO ACCESORIO </h4>
                      <img src="{{ asset($recompensawon) }}"  class="img-responsive" style="width: 30%; " alt="Felicidades">
                      <h4> {{ $recompensanamewon }} </h4>
                    @endif
                  <!--END RECOMPENSA-->
                 </div>
               </div>
               <!--end avatar-->
               <!--================= INSIGNIAS PARACOMPARTIR ============= -->
               @if(isset($inscap))
               <div class="row">
                 <div class="col-md-12">
                      <!--si termino el capitulo darle -->
                   @if($inscap != "")
                      <div class="text-center">
                        <h4>¡FELICIDADES! INSIGNIA OBTENIDA</h4>
                         <img src="/insigcap/insignia_01jpeg.jpeg"  alt="Felicidades" class="img-responsive" style="width: 36%; border-radius: 48%; border: 4px solid #be18d2;">
                          <h4> {{ $inscap[0]->nombre }} </h4>
                        <i class="fa fa-share"></i>
                        <a href="/ver/insignia/{{$inscap[0]->id}}" style="font-size:18px; color:#FBFF05;" target="_blank"><i class="bi bi-linkedin"></i> Compartir</a>
                      </div>
                      @endif
                  <!--end insignia capitulo--->
                 </div>
               </div>
               @endif
               <!--================= Tabla de puntos ================-->
               <br>
                <div class="row">
                  <div class="col-md-12">
                  <div class="panel-group" id="accordion">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">TABLA DE PUNTOS POR RETO</a>
                          </h4>
                           </div>
                        <div id="collapse2" class="panel-collapse collapse">
                          <div class="panel-body">
                               <!--TABLA DE PUNTOS -->
                               <div class="table-responsive">
                                  <table class="table">
                                   <thead>
                                      <tr>
                                        <th class="text-center">Puntos I</th>
                                        <th class="text-center">Puntos G</th>
                                        <th class="text-center">Puntos S</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td class="text-center"><span class="punti">{{ number_format($puntos_i, 0) }}</span></td>
                                        <td class="text-center"><span class="puntg">{{ number_format($puntos_g, 0) }}</span></td>
                                        <td class="text-center"><span class="punts">{{ number_format($puntos_s, 0) }}</span></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                               <!--END TABLA DE PUNTOS-->
                                </div>
                        </div>
                      </div>
                    </div>
                  </div>
               </div>
               <!--=================================-->
               <!--==========emoticones ================-->
               <br>
               <div class="row">
                <div class="moving-emoticon">&#128522;</div>
                <div class="moving-emoticon">&#128526;</div>
                <div class="moving-emoticon">	&#128521;</div>
              </div>
               <!--=====================================-->
            </div>
          </div>
          <!--end table-->
          </div>
        <div class="modal-footer" style="border-radius: 14px; background-color: #8200e4!important;">
         <a class="btn btn-success btn-lg" href="/playerchallenge/{{ $subcapitulo }}"> VOLVER </a>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>
<!--end modal-->
</div>
@endif
<!--================ en pantallas pequeñas =========================-->


<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 0.1
  </div>
  <strong>Copyright &copy; 2018 <a href="#">Evolución</a>.</strong> All rights
  reserved.
</footer>
<!-- ./wrapper -->
@endsection




