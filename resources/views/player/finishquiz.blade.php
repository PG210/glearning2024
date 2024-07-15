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
    /*modal de pasado el reto */
    .modal-img{
      background-image: url('/dist/img/fondos/fondo1.jpg'); /* Ruta de la imagen de fondo */
      background-size: cover; /* Ajusta la imagen para cubrir todo el div */
      background-position: center; /* Centra la imagen */
    }
    /*modal si paso el reto y gano accesorios einsignia */
     .modal-img-dos{
      background-image: url('/dist/img/fondos/fondo3.jpg'); /* Ruta de la imagen de fondo */
      background-size: cover; /* Ajusta la imagen para cubrir todo el div */
      background-position: center; /* Centra la imagen */
     }
    /*Modal de insignia  */
    .modal-insignia-img{
      background-image: url('/dist/img/fondos/fondo2.jpg'); /* Ruta de la imagen de fondo */
      background-size: cover; /* Ajusta la imagen para cubrir todo el div */
      background-position: center; /* Centra la imagen */
    }
    .header-color{
     background-color: #131535;
    }
    .img-avat{
      width: 30%; 
      border-radius: 48%;
      border: 4px solid #FFFFFF;
    }
    #colorVal{
      color:black;
      font-weight: bold;
      font-size: larger;
    }
    #parrafo{
      font-family: 'Effortless', sans-serif;
      font-weight: 200; /* Regular by default */
      line-height: 1.6;
      font-size: 24px;
    }
    #parrafo2{
      font-family: 'Effortless', sans-serif;
      font-weight: 200; /* Regular by default */
      line-height: 1.6;
      font-size: 21px;
    }
    .inscom{
       width: 60%;
       /*border-radius: 48%;
       border: 4px solid #be18d2;
       background-color:#A74FEA;*/
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
        <a class="btn btn-success btn-lg" href="http://evolucion.website/playerchallenge/{{ $subcapitulo }}">Volver al Tema</a> --}}
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

<!---- lista para pc hacer modificacones para celulares--->
{{-- ACTIVAR EL POPUP SI HA PASADO EL RETO --}}
@if ($passretouppopup == 1 || $insigniapopup == 1 || $leveluppopup == 1)
<audio controls autoplay>
  <source src="https://commondatastorage.googleapis.com/codeskulptor-demos/riceracer_assets/music/win.ogg" type="audio/ogg">
</audio>
  <div aria-labelledby="myLargeModalLabel" class="modal modal-info fade in" id="modal-info" style="display: block;">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      @if($insigniapopup == 1)
        <div class="modal-header" style="background-color:#ff397f;">
      @else
        <div class="modal-header header-color">
      @endif
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        @if($mensaje != 0)
           <h4 class="modal-title text-center text-uppercase">FELICITACIONES: {{ strtoupper( Auth::user()->firstname) }}</h4>
           <h2 class="text-center blinking">&#127881; &#128522; CAPÍTULO {{$cap}} TERMINADO &#128522; &#127881;</h2>
          @else
           <h2 class="modal-title text-center text-uppercase">FELICITACIONES: {{ Auth::user()->firstname }}</h2>
          @endif
      </div>
        <!---toda la informacion-->
        <!---info si paso el reto --->
        @if($insigniapopup == 0 && $recompensapopup == 0)
         <div class="modal-body modal-img">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-4 text-right">
              <img class="img-avat hidden-xs" src="{{ asset($imavatar) }}" alt="Felicidades">
              <img class="img-avat visible-xs" src="{{ asset($imavatar) }}" alt="Felicidades" style="width:70%;">&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-8">
              <br class="hidden-xs">
              <h1 class="text-left hidden-sm hidden-xs">HAS PASADO EL RETO</h1>
              <h3 class="visible-sm visible-xs">HAS PASADO EL RETO</h3>
            </div>
          </div>
          <!----============== second section============-->
          <div class="row">
            <div class="col-lg-3 col-md-3"></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
               <h3 class="text-center">Sigues avanzando, has sumado los siguientes puntos por completar este reto:</h3>
               <h3 class="text-center" style="color:#fbff05;">{{ $retos->name }} </h3>
              </div>
            <div class="col-lg-3 col-md-3"></div>
          </div>
          <!---============== three section =====-->
          <div class="row">
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div>
                  <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 text-center">
                      <h4>  PUNTOS I : <br> </h4>
                      <a class="btn btn-lg btn-block" style="background-color:gold;"><h5 id="colorVal">{{ number_format($puntos_i, 0) }}</h5></a>
                  </div>
                  <div class="col-md-1 col-lg-1"></div>
                  <div class="col-md-2 col-lg-2 col-sm-3 col-xs-3 text-center">
                      <h4> PUNTOS G : <br> </h4>
                      <a class="btn btn-lg btn-block"  style="background-color: silver;"><h5 id="colorVal">{{ number_format($puntos_g, 0) }}</h5></a>
                  </div>
                  <div class="col-md-1 col-lg-1"></div>
                  <div class="col-md-2 col-lg-2 col-sm-3 col-xs-3 text-center">
                       <h4>  PUNTOS S :  <br> </h4>
                      <a class="btn btn-lg btn-block"  style="background-color:cadetblue;"><h5 id="colorVal">{{ number_format($puntos_s, 0) }}</h5></a>
                  </div>
                  <div class="col-lg-2 col-md-2"></div>
             </div>
          <!-----===================================-->
         </div>
        @endif
         <!---info si paso el reto y gano algo --->
         @if($insigniapopup == 1 || $recompensapopup == 1 || isset($inscap) && $inscap != "")
          <div class="modal-body modal-img-dos" style="padding: 20px 30px 0px 30px;">
            <div class="row">
              <!--dividir para celulares -->
              <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 hidden-xs"> 
                @if($insigniapopup == 1)
                  <!---======== insignias ===========-----> 
                  <div class="row">
                     <br class="hidden-xs"><br class="hidden-xs">
                      <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                        <h3 class="text-left"><span>HAS RECIBIDO</span> <br> <span>UNA NUEVA INSIGNIA</span></h3>
                      </div> 
                      <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                        <img style="width: 60%;" src="{{ asset($insigniawon) }}" alt="Cargando imagen ...">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <p style="font-size:16px;">{{ $insignianamewon }} </p>  
                    </div>
                  </div>
                  <br class="hidden-xs"><br class="hidden-xs">
                @elseif($recompensapopup == 1)
                  <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                    <h3 class="text-left"><span>HAS RECIBIDO UN </span> <br> <span> ACCESORIO PARA </span> <br> <span> FORTALECERTE</span></h3>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                      <img style="width: 60%;" src="{{ asset($recompensawon) }}" alt="Cargando imagen ...">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <p style="font-size:16px;">{{ $insigniadescwon }} </p>  
                    </div>
                  </div>
                  <!------============= end ========================--> 
                @endif
                <!--si termino el capitulo darle -->
                  @if(isset($inscap))
                    @if($inscap != "")
                    <div class="row">
                       <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                          <h3><span>¡FELICIDADES! </span><br><span>GANASTE UNA </span><br><span> INSIGNIA</span></h3>
                       </div>
                       <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                          <img class="inscom" src="/insigcap/{{$inscap[0]->url}}" alt="Felicidades">
                       </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <p style="font-size:16px;"> {{ $inscap[0]->nombre }} </p>  
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <a class="btn" href="/ver/insignia/{{$inscap[0]->id}}" style="font-size:20px; color:#FFFFFF; background-color: #ff397f; border: 2px solid white;" target="_blank"><i class="fa fa-share"></i> Compartir</a>
                      </div>
                     </div>
                    @endif
                  @endif
                <!---=====================================================-->
                <br>       
              </div>
              <!--end celulares-->
              <!--vista para celulares -->
              <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 visible-xs">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                      <h3 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                          Recompensa
                        </a>
                      </h3>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                      <div class="panel-body">
                        <!----======================-->
                        @if($insigniapopup == 1)
                       <!---======== insignias ===========-----> 
                        <div class="row">
                          <br class="hidden-xs"><br class="hidden-xs">
                            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                              <h3 class="text-left"><span>HAS RECIBIDO</span> <br> <span>UNA NUEVA INSIGNIA</span></h3>
                            </div> 
                            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                              <img style="width: 60%;" src="{{ asset($insigniawon) }}" alt="Cargando imagen ...">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <p style="font-size:16px;">{{ $insignianamewon }} </p>  
                          </div>
                        </div>
                        <br class="hidden-xs"><br class="hidden-xs">
                      @elseif($recompensapopup == 1)
                        <div class="row">
                          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                          <h3 class="text-left"><span>HAS RECIBIDO UN </span> <br> <span> ACCESORIO PARA </span> <br> <span> FORTALECERTE</span></h3>
                          </div>
                          <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                            <img style="width: 60%;" src="{{ asset($recompensawon) }}" alt="Cargando imagen ...">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <p style="font-size:16px;">{{ $insigniadescwon }} </p>  
                          </div>
                        </div>
                        <!------============= end ========================--> 
                      @endif
                      <!--si termino el capitulo darle -->
                        @if(isset($inscap))
                          @if($inscap != "")
                          <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                                <h3><span>¡FELICIDADES! </span><br><span>GANASTE UNA </span><br><span> INSIGNIA</span></h3>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6">
                                <img class="inscom" src="/insigcap/{{$inscap[0]->url}}" alt="Felicidades">
                            </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <p style="font-size:16px;"> {{ $inscap[0]->nombre }} </p>  
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <a class="btn" href="/ver/insignia/{{$inscap[0]->id}}" style="font-size:20px; color:#FFFFFF; background-color: #ff397f; border: 2px solid white;" target="_blank"><i class="fa fa-share"></i> Compartir</a>
                            </div>
                          </div>
                          @endif
                        @endif
                        <!--========================-->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--vista celulares-->
              <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
                <p id="parrafo2" class="text-left">Sigues avanzando, has sumado los siguientes puntos: por completar este reto:</p>
                <h3 class="text-center" style="color:#fbff05;">{{ $retos->name }} </h3>    
                <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                  <p class="text-center">
                  <b> PUNTOS I: </b>
                  </p>
                  <a class="btn btn-lg btn-block" style="background-color:gold;"><h5 id="colorVal">{{ number_format($puntos_i, 0) }}</h5></a>
                </div>
                <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                  <p class="text-center">
                  <b> PUNTOS G: </b>
                  </p>
                  <a class="btn btn-lg btn-block"  style="background-color: silver;"><h5 id="colorVal">{{ number_format($puntos_g, 0) }}</h5></a>
                </div>
                <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                  <p class="text-center">                
                    <b>PUNTOS S: </b>
                  </p>
                  <a class="btn btn-lg btn-block"  style="background-color:cadetblue;"><h5 id="colorVal">{{ number_format($puntos_s, 0) }}</h5></a>
                </div>
                <div class="col-md-12 col-md-12 col-sm-12 col-xs-12" style="margin: 0% 0% 2% 0% "></div>  
              </div>
            </div>
          </div>
        @endif
        <!-- end info--->

        <!--end informacion--> 
        @if($insigniapopup == 1)
        <div class="modal-footer" style="background-color: #101c5a!important;">
        @else
          <div class="modal-footer header-color">
        @endif
        <a class="btn btn-success btn-lg" href="/playerchallenge/{{ $subcapitulo }}" style="border: 2px solid white;"><b>VOLVER<b></a>
      </div>
    </div>
  </div>
</div>
@endif
<!--=================== Pantallas de elular ======================-->
<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 0.1
  </div>
  <strong>Copyright &copy; 2024 <a href="#">Evolución</a>.</strong> All rights
  reserved.
</footer>
<!-- ./wrapper -->
@endsection
