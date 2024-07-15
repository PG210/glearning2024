<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    
    <title>Introducción</title>
    <link rel="stylesheet" href="{{asset('dist/css/styleciborgs.css')}}">
    <style>
      #contenedor {
         height: 100vh; /* Ajusta la altura según tus necesidades */
         background-image: url("{{asset('dist/ciborgs/fondo.png')}}");;
         background-size: cover; /* Ajusta el tamaño de la imagen para cubrir el contenedor */
         background-position: center; /* Centra la imagen en el contenedor */
         background-repeat: no-repeat; /* Evita que la imagen se repita */
      }
    </style>
  </head>
  <body style="background-color: #282828;">
    <!--información-->
    <div class="container" id="contenedor">
        <div class="container" id="seccion1">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                 </div>
                 <div class="col-lg-6 col-md-12 mt-5" id="contenedor2">
                    <h2 class="text-center" id="titulo">ELIGE TU CIBORG</h2>
                 </div>
                 <div class="col-lg-3 col-md-12">
                </div>
            </div>
            <!---gener-->
            <div class="row mt-5">
                <div class="col-lg-3 col-md-12">
                 </div>
                 <div class="col-lg-3 col-md-2 mt-5">
                    <a href="#" id="boton-m">
                    <img src="{{asset('dist/ciborgs/f1.png')}}" class="rounded mx-auto d-block" alt="Cargando imagen ...">
                    </a> 
                 </div>
                 <div class="col-lg-3 col-md-2 mt-5">
                      <a href="#" id="boton-masculino">
                      <img src="{{asset('dist/ciborgs/m.png')}}" class="rounded mx-auto d-block"  alt="Cargando imagen ...">
                     </a>
                    </div>
                 </div>
                 <div class="col-lg-3 col-md-12">
                </div>
        </div>
            <!--end gener-->
        <!--seccion 2--> 
        <div class="container" id="seccionFem" style="display: none;">
            <div class="row">
                <div class="col-lg-2">
                     <div class="container">
                        <div class="row">
                           <div class="col-lg-12 mt-2">
                              <a href="#" type="button" class="btn btn-lg btn-block btnsalir" id="volver">Volver</a>
                           </div>
                        </div>
                     </div>
                </div>
                <div class="col-lg-8 col-md-12">
                    <!--imagenes-->
                    <div class="container" style="margin-top: 16rem;">
                        <div class="mt-5" id="cards-inferior">
                        <div>
                            <a href="#" type="button" id="avatarf1" data-toggle="modal" data-target="#modalvatarf1">
                             <img alt="Cargando imagen ..." class="card-img-top" onmouseout="this.src='{{asset('dist/ciborgs/femenino/af1.png')}}';" onmouseover="this.src='{{asset('dist/ciborgs/femenino/af1hover.png')}}';" src="{{asset('dist/ciborgs/femenino/af1.png')}}"/>
                            </a>
                            <!--modal-->
                            <!-- Modal -->
                            <div class="modal fade" id="modalvatarf1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                <div class="modal-content degradado" style="border-radius: 15px;">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">MEMOREX</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                       <p class="text-justify">
                                        Los Memorex, surgen por el mar de información que abundaba en el mundo. Ingenieros, científicos o médicos que buceaban en las aguas más profundas del conocimiento. Por ellos, surgieron los Memorex, aquellos lideres que necesitaban una basta memoria para almacenar toda la información. Con sus habilidades para la seguridad, encriptación y expansión: Memorex se convirtió en la clase de líder que se la sabe todas.
                                       </p>
                                        <!--- botones de accesorios y escoger-->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>
                                                <a class="btn btnaccesorios" data-toggle="collapse" href="#avatarf01" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                   <b>Accesorios</b>
                                                </a>
                                                <a href="{{route('saveCiborg', 5)}}" class="btn btnciborg">
                                                    <b>Escoger ciborg</b>
                                                 </a>
                                                </p>
                                                <div class="collapse" id="avatarf01">
                                                <div class="card card-body degradado">
                                                   <!--disenio de los accesorios-->
                                                   <div class="row">
                                                     <div class="col-lg-2 col-md-12">
                                                        <img src="{{asset('dist/ciborgs/accesorios/acf1.png')}}"  alt="Cargando imagen ..." width="100">
                                                     </div>
                                                     <div class="col-lg-10 col-md-12 text-justify">
                                                        <span class="tituloaccesorios">Energibrazalete:</span> Brazalete energético o Energibrazalete es un módulo tecnológico portable que permite al usuario mantener total control de sus implantes y le brinda información sobre su entorno, incrementando la capacidad de autoliderazgo en Memorex.
                                                     </div>
                                                   </div>
                                                   <div class="row mt-2">
                                                    <div class="col-lg-2 col-md-12">
                                                       <img src="{{asset('dist/ciborgs/accesorios/acf2.png')}}"  alt="Cargando imagen ..." width="100">
                                                    </div>
                                                    <div class="col-lg-10 col-md-12 text-justify">
                                                       <span class="tituloaccesorios">Cyberguantelete:</span> Cyberguantelete es una herramienta que brinda al portador una sobrecarga energética con el cual recibe una especie de escudo de energía que además impulsa su fuerza física posibilitando una mejor optimización del tiempo en Memorex.
                                                    </div>
                                                  </div>
                                                  <div class="row mt-2">
                                                    <div class="col-lg-2 col-md-12">
                                                       <img src="{{asset('dist/ciborgs/accesorios/acf3.png')}}"  alt="Cargando imagen ..." width="100">
                                                    </div>
                                                    <div class="col-lg-10 col-md-12 text-justify">
                                                       <span class="tituloaccesorios">MAV:</span> Modulo de Aumento Visual o MAV es una mejora que permite al usuario magnificar su campo visual y proyecta información directa sobre la visualización, dándole a Memorex la capacidad de desarrollar las personas con bastante información y tacto.
                                                    </div>
                                                  </div>
                                                   <!--end accesorios-->
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end escoger-->
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!--end modal-->
                        </div>
                        <div>
                            <a href="#" id="avatarf2" data-toggle="modal" data-target="#modalvatarf2">
                             <img alt="Cargando imagen ..." class="card-img-top" onmouseout="this.src='{{asset('dist/ciborgs/femenino/af2.png')}}';" onmouseover="this.src='{{asset('dist/ciborgs/femenino/af2hover.png')}}';" src="{{asset('dist/ciborgs/femenino/af2.png')}}"/>
                            </a>
                            <!-- Modal -->
                            <div class="modal fade" id="modalvatarf2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                <div class="modal-content degradado" style="border-radius: 15px;">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">LINGUO</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                       <p class="text-justify">
                                        Especialistas en interacciones sociales, su enfoque es el relacionamiento con las personas u otros seres vivientes, tiene un gran manejo de los lenguajes y de la empatía, eran los más efectivos para interactuar con humanos en la tierra.
                                       </p>
                                        <!--- botones de accesorios y escoger-->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>
                                                <a class="btn btnaccesorios" data-toggle="collapse" href="#avatarf02" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                   <b>Accesorios</b>
                                                </a>
                                                <a href="{{route('saveCiborg', 6)}}" class="btn btnciborg">
                                                    <b>Escoger ciborg</b>
                                                 </a>
                                                </p>
                                                <div class="collapse" id="avatarf02">
                                                <div class="card card-body degradado">
                                                   <!--disenio de los accesorios-->
                                                   <div class="row">
                                                     <div class="col-lg-2 col-md-12">
                                                        <img src="{{asset('dist/ciborgs/accesorios/acf21.png')}}" alt="Cargando imagen ..." width="100">
                                                     </div>
                                                     <div class="col-lg-10 col-md-12 text-justify mt-3">
                                                        <span class="tituloaccesorios">Tecnobrazo:</span> Una mano que ayuda debe estar preparada, el tecnobrazo viene con toda una interfaz de reconocimiento de área, eso sin contar sus múltiples sensores y proyectores de energía que incrementan la capacidad del usurario de incrementar su autoliderazgo.
                                                     </div>
                                                   </div>
                                                   <div class="row mt-2">
                                                    <div class="col-lg-2 col-md-12">
                                                       <img src="{{asset('dist/ciborgs/accesorios/acf22.png')}}"  alt="Cargando imagen ..." width="100">
                                                    </div>
                                                    <div class="col-lg-10 col-md-12 text-justify mt-3">
                                                       <span class="tituloaccesorios">Vi-Au:</span> Para estar en perpetua conexión con quienes nos rodean y sobre lo que nos rodea, el Vi-Au es la herramienta que nos mantiene al tanto en tiempo real sobre toda la información del espacio y de quienes están en él, nos brinda una capacidad de gestionar nuestro tiempo de manera fluida y constante.
                                                    </div>
                                                  </div>
                                                  <div class="row mt-2">
                                                    <div class="col-lg-2 col-md-12">
                                                       <img src="{{asset('dist/ciborgs/accesorios/acf23.png')}}"  alt="Cargando imagen ..." width="100">
                                                    </div>
                                                    <div class="col-lg-10 col-md-12 text-justify mt-3">
                                                       <span class="tituloaccesorios">A-Com:</span> Complemento ideal de estar informado es comunicar, el A-Com es la pieza fundamental para llevar a nuestro equipo adelante y mantener todo en perfecta sincronía, dándonos habilidades óptimas para el desarrollo de personas.
                                                    </div>
                                                  </div>
                                                   <!--end accesorios-->
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end escoger-->
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!--end modal-->
                        </div>
                        <div>
                            <a href="#" id="avatarf3" data-toggle="modal" data-target="#modalvatarf3">
                             <img alt="Cargando imagen ..." class="card-img-top" onmouseout="this.src='{{asset('dist/ciborgs/femenino/af3.png')}}';" onmouseover="this.src='{{asset('dist/ciborgs/femenino/af3hover.png')}}';" src="{{asset('dist/ciborgs/femenino/af3.png')}}"/>
                            </a>
                             <!-- Modal -->
                             <div class="modal fade" id="modalvatarf3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                <div class="modal-content degradado" style="border-radius: 15px;">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">MAKER</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                       <p class="text-justify">
                                         Hacia dónde este se dirige todos lo siguen. Tiene gran visión de saber qué es lo que se debe hacer, que información recolectar, cómo liderar y trabajar en equipo, con quien adquirir nuevos conocimientos, tiene un gran compromiso para hacer que las cosas sucedan. Eran los cyborgs perfectos para sacar, liderar proyectos y sus personas.
                                       </p>
                                        <!--- botones de accesorios y escoger-->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>
                                                <a class="btn btnaccesorios" data-toggle="collapse" href="#avatarf03" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                   <b>Accesorios</b>
                                                </a>
                                                <a href="{{route('saveCiborg', 7)}}" class="btn btnciborg">
                                                    <b>Escoger ciborg</b>
                                                 </a>
                                                </p>
                                                <div class="collapse" id="avatarf03">
                                                <div class="card card-body degradado">
                                                   <!--disenio de los accesorios-->
                                                   <div class="row">
                                                     <div class="col-lg-2 col-md-12">
                                                        <img src="{{asset('dist/ciborgs/accesorios/acf31.png')}}" alt="Cargando imagen ..." width="100">
                                                     </div>
                                                     <div class="col-lg-10 col-md-12 text-justify mt-3">
                                                        <span class="tituloaccesorios">Servoguantes:</span> Unas manos fuertes necesitan una ayuda para ser la herramienta ideal, los servoguantes son impulsados por 2 módulos de energía para ayudar a la protección a la hora de manipular herramientas o pesos más grandes.
                                                     </div>
                                                   </div>
                                                   <div class="row mt-2">
                                                    <div class="col-lg-2 col-md-12">
                                                       <img src="{{asset('dist/ciborgs/accesorios/acf32.png')}}" alt="Cargando imagen ..." width="100">
                                                    </div>
                                                    <div class="col-lg-10 col-md-12 text-justify mt-3">
                                                       <span class="tituloaccesorios">Módulo de Expansión Cognitiva:</span> El módulo de expansión cognitiva es una unidad que eleva las características de análisis del cybervisor de maker, un impulso de poder extra que permitirá a Maker manejar su tiempo con mayor resolución.
                                                    </div>
                                                  </div>
                                                  <div class="row mt-2">
                                                    <div class="col-lg-2 col-md-12">
                                                       <img src="{{asset('dist/ciborgs/accesorios/acf33.png')}}"  alt="Cargando imagen ..." width="100">
                                                    </div>
                                                    <div class="col-lg-10 col-md-12 text-justify mt-3">
                                                       <span class="tituloaccesorios">Servoimplantes:</span> Servoimplantes musculares o TurboMusculo, una unidad de energía que ayuda a Maker a mantener la integridad muscular en un 100% sin recibir fatiga, dándole la posibilidad de resistir cada día hasta el final con la misma energía y optimismo para desarrollar personas.
                                                    </div>
                                                  </div>
                                                   <!--end accesorios-->
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end escoger-->
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!--end modal-->
                        </div>
                        <div>
                            <a href="#" id="avatarf4" data-toggle="modal" data-target="#modalvatarf4">
                             <img alt="Cargando imagen ..." class="card-img-top" onmouseout="this.src='{{asset('dist/ciborgs/femenino/af4.png')}}';" onmouseover="this.src='{{asset('dist/ciborgs/femenino/af4hover.png')}}';" src="{{asset('dist/ciborgs/femenino/af4.png')}}"/>
                            </a>
                             <!-- Modal -->
                             <div class="modal fade" id="modalvatarf4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                <div class="modal-content degradado" style="border-radius: 15px;">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">SABIUS</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                       <p class="text-justify">
                                        Lo ha vivido todo y con su sabiduría aconseja, guía, cuestiona para bien lo que se debe hacer. Enseña a través del ejemplo, entiende el porqué de las cosas y no habla por hablar, fueron grandes consejeros en la tierra, aquellos que estaban más conectados al mundo como humanos que como máquinas, normalmente son personas mayores que se han negado a la muerte.
                                       </p>
                                        <!--- botones de accesorios y escoger-->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <p>
                                                <a class="btn btnaccesorios" data-toggle="collapse" href="#avatarf04" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                   <b>Accesorios</b>
                                                </a>
                                                <a href="{{route('saveCiborg', 8)}}" class="btn btnciborg">
                                                    <b>Escoger ciborg</b>
                                                 </a>
                                                </p>
                                                <div class="collapse" id="avatarf04">
                                                <div class="card card-body degradado">
                                                   <!--disenio de los accesorios-->
                                                   <div class="row">
                                                     <div class="col-lg-2 col-md-12">
                                                        <img src="{{asset('dist/ciborgs/accesorios/acf41.png')}}" alt="Cargando imagen ..." width="100">
                                                     </div>
                                                     <div class="col-lg-10 col-md-12 text-justify mt-3">
                                                        <span class="tituloaccesorios">Cinturón de Aumento Exponencial (CAE):</span> El Cinturón de Aumento Exponencial o CAE es un sistema de mejora basado en una IA que asiste todas las cybermejoras con las que cuenta Sabius y magnifica su autoliderazgo. Cuenta con dos extensiones para amplificar sus capacidades de liderazgo.
                                                     </div>
                                                   </div>
                                                   <div class="row mt-2">
                                                    <div class="col-lg-2 col-md-12">
                                                       <img src="{{asset('dist/ciborgs/accesorios/acf42.png')}}"  alt="Cargando imagen ..." width="100">
                                                    </div>
                                                    <div class="col-lg-10 col-md-12 text-justify mt-3">
                                                       <span class="tituloaccesorios">Módulos AB:</span> Módulos de impulso AB o simplemente módulos AB son dos pequeños módulos que incrementan las habilidades del CAE dándole la habilidad de Gestionar su Tiempo de la manera más optima.
                                                    </div>
                                                  </div>
                                                  <div class="row mt-2">
                                                    <div class="col-lg-2 col-md-12">
                                                       <img src="{{asset('dist/ciborgs/accesorios/acf43.png')}}"  alt="Cargando imagen ..." width="100">
                                                    </div>
                                                    <div class="col-lg-10 col-md-12 text-justify mt-3">
                                                       <span class="tituloaccesorios">Módulos C:</span> El módulo C es un módulo de Almacenamiento de información y de conexión a servidores que permite a Sabius acceder a todos los datos disponibles en las bases de sus compañeros. El módulo C junto a la experiencia de Sabius mejora las habilidades de desarrollo de personas.
                                                    </div>
                                                  </div>
                                                   <!--end accesorios-->
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end escoger-->
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!--end modal-->
                        </div>
                        </div>
                    </div>
                    <!--imagenes-->
                </div>
                <div class="col-lg-2"></div>
            </div>
        </div>
        <!--end seccion 2-->
        <!---seccion 3-->
        <div class="container" id="seccionMas" style="display: none;">
         <div class="row">
             <div class="col-lg-2">
                  <div class="container">
                     <div class="row">
                        <div class="col-lg-12 mt-2">
                           <a href="#" type="button" class="btn btn-lg btn-block btnsalir" id="volver2">Volver</a>
                        </div>
                     </div>
                  </div>
             </div>
             <div class="col-lg-8 col-md-12">
                 <!--imagenes-->
                 <div class="container" style="margin-top: 16rem;">
                     <div class="mt-5" id="cards-inferior">
                     <div>
                         <a href="#" type="button" id="avatarf1" data-toggle="modal" data-target="#modalvatarm1">
                          <img alt="Cargando imagen ..." class="card-img-top" onmouseout="this.src='{{asset('dist/ciborgs/masculino/m1.png')}}';" onmouseover="this.src='{{asset('dist/ciborgs/masculino/mh1.png')}}';" src="{{asset('dist/ciborgs/masculino/m1.png')}}"/>
                         </a>
                         <!--modal-->
                         <!-- Modal -->
                         <div class="modal fade" id="modalvatarm1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                             <div class="modal-dialog modal-xl">
                             <div class="modal-content degradado" style="border-radius: 15px;">
                                 <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalLabel">MAKER</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </button>
                                 </div>
                                 <div class="modal-body">
                                    <p class="text-justify">
                                       Hacia dónde este se dirige todos lo siguen. Tiene gran visión de saber qué es lo que se debe hacer, que información recolectar, cómo liderar y trabajar en equipo, con quien adquirir nuevos conocimientos, tiene un gran compromiso para hacer que las cosas sucedan. Eran los cyborgs perfectos para sacar, liderar proyectos y sus personas.
                                    </p>
                                     <!--- botones de accesorios y escoger-->
                                     <div class="row">
                                         <div class="col-lg-12">
                                             <p>
                                             <a class="btn btnaccesorios" data-toggle="collapse" href="#avatarm01" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                <b>Accesorios</b>
                                             </a>
                                             <a href="{{route('saveCiborg', 3)}}" class="btn btnciborg">
                                                 <b>Escoger ciborg</b>
                                              </a>
                                             </p>
                                             <div class="collapse" id="avatarm01">
                                             <div class="card card-body degradado">
                                                <!--disenio de los accesorios-->
                                                <div class="row">
                                                  <div class="col-lg-2 col-md-12">
                                                     <img src="{{asset('dist/ciborgs/accesorios/m11.png')}}"  alt="Cargando imagen ..." width="100">
                                                  </div>
                                                  <div class="col-lg-10 col-md-12 text-justify">
                                                     <span class="tituloaccesorios">Servoguantes:</span> Unas manos fuertes necesitan una ayuda para ser la herramienta ideal, los servoguantes son impulsados por 2 módulos de energía para ayudar a la protección a la hora de manipular herramientas o pesos más grandes.
                                                  </div>
                                                </div>
                                                <div class="row mt-2">
                                                 <div class="col-lg-2 col-md-12">
                                                    <img src="{{asset('dist/ciborgs/accesorios/m12.png')}}"  alt="Cargando imagen ..." width="100">
                                                 </div>
                                                 <div class="col-lg-10 col-md-12 text-justify">
                                                    <span class="tituloaccesorios">Módulo de Expansión Cognitiva:</span> El módulo de expansión cognitiva es una unidad que eleva las características de análisis del cybervisor de Maker, un impulso de poder extra que permitirá a Maker manejar su tiempo con mayor resolución.
                                                 </div>
                                               </div>
                                               <div class="row mt-2">
                                                 <div class="col-lg-2 col-md-12">
                                                    <img src="{{asset('dist/ciborgs/accesorios/m13.png')}}"  alt="Cargando imagen ..." width="100">
                                                 </div>
                                                 <div class="col-lg-10 col-md-12 text-justify">
                                                    <span class="tituloaccesorios">Servoimplantes:</span> Servoimplantes musculares o TurboMusculo, una unidad de energía que ayuda a Maker a mantener la integridad muscular en un 100% sin recibir fatiga, dándole la posibilidad de resistir cada día hasta el final con la misma energía y optimismo para desarrollar personas.
                                                 </div>
                                               </div>
                                                <!--end accesorios-->
                                             </div>
                                             </div>
                                         </div>
                                     </div>
                                     <!--end escoger-->
                                 </div>
                             </div>
                             </div>
                         </div>
                         <!--end modal-->
                     </div>
                     <div>
                         <a href="#" id="avatarm2" data-toggle="modal" data-target="#modalvatarm2">
                          <img alt="Cargando imagen ..." class="card-img-top" onmouseout="this.src='{{asset('dist/ciborgs/masculino/m2.png')}}';" onmouseover="this.src='{{asset('dist/ciborgs/masculino/mh2.png')}}';" src="{{asset('dist/ciborgs/masculino/m2.png')}}"/>
                         </a>
                         <!-- Modal -->
                         <div class="modal fade" id="modalvatarm2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                             <div class="modal-dialog modal-xl">
                             <div class="modal-content degradado" style="border-radius: 15px;">
                                 <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalLabel">LINGUO</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </button>
                                 </div>
                                 <div class="modal-body">
                                    <p class="text-justify">
                                     Especialistas en interacciones sociales, su enfoque es el relacionamiento con las personas u otros seres vivientes, tiene un gran manejo de los lenguajes y de la empatía, eran los más efectivos para interactuar con humanos en la tierra.
                                    </p>
                                     <!--- botones de accesorios y escoger-->
                                     <div class="row">
                                         <div class="col-lg-12">
                                             <p>
                                             <a class="btn btnaccesorios" data-toggle="collapse" href="#avatarm02" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                <b>Accesorios</b>
                                             </a>
                                             <a href="{{route('saveCiborg', 2)}}" class="btn btnciborg">
                                                 <b>Escoger ciborg</b>
                                              </a>
                                             </p>
                                             <div class="collapse" id="avatarm02">
                                             <div class="card card-body degradado">
                                                <!--disenio de los accesorios-->
                                                <div class="row">
                                                  <div class="col-lg-2 col-md-12">
                                                     <img src="{{asset('dist/ciborgs/accesorios/m21.png')}}" alt="Cargando imagen ..." width="100">
                                                  </div>
                                                  <div class="col-lg-10 col-md-12 text-justify mt-3">
                                                     <span class="tituloaccesorios">Tecnobrazo:</span> Una mano que ayuda debe estar preparada, el tecnobrazo viene con toda una interfaz de reconocimiento de área, eso sin contar sus múltiples sensores y proyectores de energía que incrementan la capacidad del usurario de incrementar su autoliderazgo.
                                                  </div>
                                                </div>
                                                <div class="row mt-2">
                                                 <div class="col-lg-2 col-md-12">
                                                    <img src="{{asset('dist/ciborgs/accesorios/m22.png')}}"  alt="Cargando imagen ..." width="100">
                                                 </div>
                                                 <div class="col-lg-10 col-md-12 text-justify mt-3">
                                                    <span class="tituloaccesorios">Vi-Au:</span> Para estar en perpetua conexión con quienes nos rodean y sobre lo que nos rodea, el Vi-Au es la herramienta que nos mantiene al tanto en tiempo real sobre toda la información del espacio y de quienes están en él, nos brinda una capacidad de gestionar nuestro tiempo de manera fluida y constante.
                                                 </div>
                                               </div>
                                               <div class="row mt-2">
                                                 <div class="col-lg-2 col-md-12">
                                                    <img src="{{asset('dist/ciborgs/accesorios/m23.png')}}"  alt="Cargando imagen ..." width="100">
                                                 </div>
                                                 <div class="col-lg-10 col-md-12 text-justify mt-3">
                                                    <span class="tituloaccesorios">A-Com:</span> Complemento ideal de estar informado es comunicar, el A-Com es la pieza fundamental para llevar a nuestro equipo adelante y mantener todo en perfecta sincronía, dándonos habilidades óptimas para el desarrollo de personas.
                                                 </div>
                                               </div>
                                                <!--end accesorios-->
                                             </div>
                                             </div>
                                         </div>
                                     </div>
                                     <!--end escoger-->
                                 </div>
                             </div>
                             </div>
                         </div>
                         <!--end modal-->
                     </div>
                     <div>
                         <a href="#" id="avatarf3" data-toggle="modal" data-target="#modalvatarm3">
                          <img alt="Cargando imagen ..." class="card-img-top" onmouseout="this.src='{{asset('dist/ciborgs/masculino/m3.png')}}';" onmouseover="this.src='{{asset('dist/ciborgs/masculino/mh3.png')}}';" src="{{asset('dist/ciborgs/masculino/m3.png')}}"/>
                         </a>
                          <!-- Modal -->
                          <div class="modal fade" id="modalvatarm3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                             <div class="modal-dialog modal-xl">
                             <div class="modal-content degradado" style="border-radius: 15px;">
                                 <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalLabel">MEMOREX</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </button>
                                 </div>
                                 <div class="modal-body">
                                    <p class="text-justify">
                                       Los Memorex, surgen por el mar de información que abundaba en el mundo. Ingenieros, científicos o médicos que buceaban en las aguas más profundas del conocimiento. Por ellos, surgieron los Memorex, aquellos lideres que necesitaban una basta memoria para almacenar toda la información. Con sus habilidades para la seguridad, encriptación y expansión: Memorex se convirtió en la clase de líder que se la sabe todas.
                                    </p>
                                     <!--- botones de accesorios y escoger-->
                                     <div class="row">
                                         <div class="col-lg-12">
                                             <p>
                                             <a class="btn btnaccesorios" data-toggle="collapse" href="#avatarm03" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                <b>Accesorios</b>
                                             </a>
                                             <a href="{{route('saveCiborg', 1)}}" class="btn btnciborg">
                                                 <b>Escoger ciborg</b>
                                              </a>
                                             </p>
                                             <div class="collapse" id="avatarm03">
                                             <div class="card card-body degradado">
                                                <!--disenio de los accesorios-->
                                                <div class="row">
                                                  <div class="col-lg-2 col-md-12">
                                                     <img src="{{asset('dist/ciborgs/accesorios/m31.png')}}" alt="Cargando imagen ..." width="100">
                                                  </div>
                                                  <div class="col-lg-10 col-md-12 text-justify mt-3">
                                                     <span class="tituloaccesorios">Energibrazalete:</span> Brazalete energético o Energibrazalete es un módulo tecnológico portable que permite al usuario mantener total control de sus implantes y le brinda información sobre su entorno, incrementando la capacidad de autoliderazgo en Memorex.
                                                  </div>
                                                </div>
                                                <div class="row mt-2">
                                                 <div class="col-lg-2 col-md-12">
                                                    <img src="{{asset('dist/ciborgs/accesorios/m32.png')}}" alt="Cargando imagen ..." width="100">
                                                 </div>
                                                 <div class="col-lg-10 col-md-12 text-justify mt-3">
                                                    <span class="tituloaccesorios">Cyberguantelete:</span> Cyberguantelete es una herramienta que brinda al portador una sobrecarga energética con el cual recibe una especie de escudo de energía que además impulsa su fuerza física posibilitando una mejor optimización del tiempo en Memorex.
                                                 </div>
                                               </div>
                                               <div class="row mt-2">
                                                 <div class="col-lg-2 col-md-12">
                                                    <img src="{{asset('dist/ciborgs/accesorios/m33.png')}}"  alt="Cargando imagen ..." width="100">
                                                 </div>
                                                 <div class="col-lg-10 col-md-12 text-justify mt-3">
                                                    <span class="tituloaccesorios">MAV:</span> Modulo de Aumento Visual o MAV es una mejora que permite al usuario magnificar su campo visual y proyecta información directa sobre la visualización, dándole a Memorex la capacidad de desarrollar las personas con bastante información y tacto.
                                                 </div>
                                               </div>
                                                <!--end accesorios-->
                                             </div>
                                             </div>
                                         </div>
                                     </div>
                                     <!--end escoger-->
                                 </div>
                             </div>
                             </div>
                         </div>
                         <!--end modal-->
                     </div>
                     <div>
                         <a href="#" id="avatarf4" data-toggle="modal" data-target="#modalvatarm4">
                          <img alt="Cargando imagen ..." class="card-img-top" onmouseout="this.src='{{asset('dist/ciborgs/masculino/m4.png')}}';" onmouseover="this.src='{{asset('dist/ciborgs/masculino/mh4.png')}}';" src="{{asset('dist/ciborgs/masculino/m4.png')}}"/>
                         </a>
                          <!-- Modal -->
                          <div class="modal fade" id="modalvatarm4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                             <div class="modal-dialog modal-xl">
                             <div class="modal-content degradado" style="border-radius: 15px;">
                                 <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalLabel">SABIUS</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                     <span aria-hidden="true">&times;</span>
                                 </button>
                                 </div>
                                 <div class="modal-body">
                                    <p class="text-justify">
                                     Lo ha vivido todo y con su sabiduría aconseja, guía, cuestiona para bien lo que se debe hacer. Enseña a través del ejemplo, entiende el porqué de las cosas y no habla por hablar, fueron grandes consejeros en la tierra, aquellos que estaban más conectados al mundo como humanos que como máquinas, normalmente son personas mayores que se han negado a la muerte.
                                    </p>
                                     <!--- botones de accesorios y escoger-->
                                     <div class="row">
                                         <div class="col-lg-12">
                                             <p>
                                             <a class="btn btnaccesorios" data-toggle="collapse" href="#avatarm04" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                <b>Accesorios</b>
                                             </a>
                                             <a href="{{route('saveCiborg', 4)}}" class="btn btnciborg">
                                                 <b>Escoger ciborg</b>
                                              </a>
                                             </p>
                                             <div class="collapse" id="avatarm04">
                                             <div class="card card-body degradado">
                                                <!--disenio de los accesorios-->
                                                <div class="row">
                                                  <div class="col-lg-2 col-md-12">
                                                     <img src="{{asset('dist/ciborgs/accesorios/m41.png')}}" alt="Cargando imagen ..." width="100">
                                                  </div>
                                                  <div class="col-lg-10 col-md-12 text-justify mt-3">
                                                     <span class="tituloaccesorios">Cinturón de Aumento Exponencial (CAE):</span> El Cinturón de Aumento Exponencial o CAE es un sistema de mejora basado en una IA que asiste todas las cybermejoras con las que cuenta Sabius y magnifica su autoliderazgo. Cuenta con dos extensiones para amplificar sus capacidades de liderazgo.
                                                  </div>
                                                </div>
                                                <div class="row mt-2">
                                                 <div class="col-lg-2 col-md-12">
                                                    <img src="{{asset('dist/ciborgs/accesorios/m42.png')}}"  alt="Cargando imagen ..." width="100">
                                                 </div>
                                                 <div class="col-lg-10 col-md-12 text-justify mt-3">
                                                    <span class="tituloaccesorios">Módulos AB:</span> Módulos de impulso AB o simplemente módulos AB son dos pequeños módulos que incrementan las habilidades del CAE dándole la habilidad de Gestionar su Tiempo de la manera más optima.
                                                 </div>
                                               </div>
                                               <div class="row mt-2">
                                                 <div class="col-lg-2 col-md-12">
                                                    <img src="{{asset('dist/ciborgs/accesorios/m43.png')}}"  alt="Cargando imagen ..." width="100">
                                                 </div>
                                                 <div class="col-lg-10 col-md-12 text-justify mt-3">
                                                    <span class="tituloaccesorios">Módulos C:</span> El módulo C es un módulo de Almacenamiento de información y de conexión a servidores que permite a Sabius acceder a todos los datos disponibles en las bases de sus compañeros. El módulo C junto a la experiencia de Sabius mejora las habilidades de desarrollo de personas.
                                                 </div>
                                               </div>
                                                <!--end accesorios-->
                                             </div>
                                             </div>
                                         </div>
                                     </div>
                                     <!--end escoger-->
                                 </div>
                             </div>
                             </div>
                         </div>
                         <!--end modal-->
                     </div>
                     </div>
                 </div>
                 <!--imagenes-->
             </div>
             <div class="col-lg-2"></div>
         </div>
        </div>
        <!--end seccion 3-->
    </div>
    <!--end-->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="{{asset('dist/js/jsciborgs.js')}}"></script>
</body>
</html>