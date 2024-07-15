<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Insignia</title>
  <!-- Aquí puedes agregar enlaces a tus archivos CSS y scripts JS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
  <!--<script src="{{asset('dist/js/estilo.js')}}"></script>-->
  <style>
  @media screen and (min-width: 1920px) {
        h3, h2 {
          font-family: 'Roboto';
          font-size: 2.2em !important;
          line-height: 1.6em;
          margin-bottom: 0.0rem !important;
        }
    }

    @media screen and (min-width: 1400px) and (max-width: 1919px) {
        h3 {
          font-family: 'Roboto';
          font-size: 2.2em !important;
          line-height: 1.6em;
          margin-bottom: 0.0rem !important;
        }
    }

    @media screen and (min-width: 501px) and (max-width: 1399px) {
        h6 {
          font-family: 'Roboto';
          font-size: 1em !important;
          line-height: 2.3em;
        }
      }

      @media screen and (min-width: 371px) and (max-width: 500px) {
        h6 {
          font-family: 'Roboto';
          font-size: 0.85em !important;
          line-height: 1.5em;
        }
      }

      @media screen and (min-width: 360px) and (max-width: 370px) {
        h6 {
          font-family: 'Roboto';
          font-size: 0.85em !important;
          line-height: 1.0em;
        }
      }

      @media screen and (max-width: 359px) {
        h6 {
          font-family: 'Roboto';
          font-size: 0.65em !important;
          line-height: 1.2em;
        }
    }
    .tletra{
      font-family: 'Roboto';
    }
  </style>
</head>
<body>
<div style="background-color:#1ED5F4;">
    <div class="container text-end" style="padding-top:5px; padding-bottom:5px;">
       <div class="container">
        <button class="btn btn-success d-none d-lg-block" id="btnDownload" > <i class="bi bi-download"></i>&nbsp;Descargar</button>
        <button class="btn btn-success  d-lg-none" id="btnDownload2" > <i class="bi bi-download"></i>&nbsp;Descargar</button>
      </div>
    </div>
</div>

<!--<button onclick="descargarPDF()">Descargar en PDF</button>-->
<br>
<div id="elementToCapture">
 <div class="container d-none d-sm-block" style="background-image: url('/dist/img/fondo2.png'); background-size: cover; background-position: center;  background-size: contain; background-size: 100hv auto; background-repeat: no-repeat;">
    <div class="row">
          <div class="col-lg-7">
          </div>
          <div class="col-lg-5 col-md-12 col-sm-12 mt-md-5">
                <img src="/insigcap/{{$info[0]->imagen}}" class="mt-5 d-md-none d-lg-block d-sm-none d-md-block" alt="Descripción de la imagen" style="width: 120px; height: auto; border-radius:80px;">
                <!---imagen pantallas medianas-->
                <img src="/insigcap/{{$info[0]->imagen}}" class="d-none d-md-block d-lg-none" alt="Descripción de la imagen" style="width: 110px; height: auto; border-radius:80px;">
                <!---pantallas peque-->
                <div class="d-none d-sm-block d-md-none"><br><br><br><br><br></div>
                <img src="/insigcap/{{$info[0]->imagen}}" class="d-none d-sm-block d-md-none" alt="Descripción de la imagen" style="width: 70px; height: auto; border-radius:80px;">

          </div>
      </div>
      <div class="row"> 
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <h3 class="text-center mb-3 d-sm-none d-md-block"><span style="color:blue;"><b>Certifica que:</b></span> </h3>
          <h4 class="text-center mb-3 d-none d-sm-block d-md-none"><span style="color:blue;"><b>Certifica que:</b></span></h4>
        </div>
      </div>
     <div class="container">
      <h3 class="text-center d-sm-none d-md-block">{{$info[0]->usuname}} {{$info[0]->usuape}}</h3>
      <h4 class="text-center d-sm-none d-md-block">C.C {{$info[0]->cedula}}</h4>
      <h4 class="text-center d-none d-sm-block d-md-none">{{$info[0]->usuname}} {{$info[0]->usuape}}</h4>
      <h5 class="text-center d-none d-sm-block d-md-none">C.C {{$info[0]->cedula}}</h5>
      <br>
    </div>
    <div class="container">
        <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2">
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8">
            <p> <h3 class="text-center d-sm-none d-md-block"><span style="color:blue;">
               <b>Aprobó el programa:</b></span>
                @if(strlen($info[0]->name) > 25)
                   {{$info[0]->name}}
                 @else
                   {{$info[0]->name}}
                   <br>
                   <br>
                @endif
            </h3>
            <h4 class="text-center d-none d-sm-block d-md-none"><span style="color:blue;">
               <b>Aprobó el programa:</b></span>
                @if(strlen($info[0]->name) > 25)
                   {{$info[0]->name}}
                 @else
                   {{$info[0]->name}}
                   <br>
                   <br>
                @endif
            </h4>
            </p>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2">
        </div>
      </div>
    </div>
    <div class="container">
    <br><br><br><br><br><br><br><br>
    </div>
    </div>
  </div>
</div>
<?php
 $f = $info[0]->created_at;
 $fecha = substr($f, 0, 10);
?>
  <!--#################################################################--->
       <!--visualizar en pantallas pequenias-->
  <div id="elementToCapture2">
  <div class="d-block d-sm-none" style="background-image: url('/dist/img/fondo2.png'); background-size: cover; background-position: center;  background-size: contain; background-size: 100% auto; background-repeat: no-repeat; padding-top:0px;">
    <br class="d-none d-sm-block">
     <div class="text-start"  style="position: relative;  z-index: 1;">
        <img src="/insigcap/{{$info[0]->imagen}}"  class="img-thumbnail" alt="Descripción de la imagen" style="width: 50px; height: auto; border-radius:100px; padding-top:0px;">
    </div>
    <br>
     <div class="container" style="position: relative;  z-index: 2;">
      <div class="row"> 
         <div class="col-md-12 col-sm-12 col-xs-12">
            <h6 class="text-center"><span style="color:blue; "><b>Certifica que:</b></span> </h6>
         </div>
        </div>
      <h6 class="text-center">{{$info[0]->usuname}} {{$info[0]->usuape}}</h6>
      <h6 class="text-center">C.C {{$info[0]->cedula}}</h6>
    </div>
    <div class="container" style="position: relative;  z-index: 2;">
        <div class="row">
        <div class="col-md-12 col-sm-2 col-xs-12">
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <p> <h6 class="text-center"><span style="color:blue;">
               <b>Aprobó el programa:</b></span>
                @if(strlen($info[0]->name) > 25)
                   {{$info[0]->name}}
                 @else
                   {{$info[0]->name}}
                @endif
            </h6></p>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
        </div>
      </div>
    </div>
     <br>
    <div class="container" style="position: relative;  z-index: 2;">
    <br>
    <br>
    </div>
  </div>
  </div>
  <h5 class="text-center mt-3">Fecha emisión:  {{$fecha}}</h5>
  <!--eend visualiar en pantallas pequenias-->
  <!--################################################################-->
  <!--contenedor para compartir-->
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"></div> 
            <div class="col-md-8 col-sm-8 col-xs-8 text-center">
            <!--describir insignia-->
            <button class="btn btn-warning  ms-2 tletra"  style="margin-top:10px;" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Descripción Insignia
            </button>
            <div class="collapse" id="collapseExample">
                <div class="card card-body" style="text-align:justify">
                  {{$info[0]->description}}
                </div>
            </div>
            @auth
            
             <?php
                $fec = $info[0]->created_at;
                $anio = date("Y", strtotime($fec));
                $mes = date("m", strtotime($fec));
              ?>
             <a class="btn btn-primary ms-2 tletra" style="margin-top:10px;"  href="https://www.linkedin.com/profile/add?startTask=CERTIFICATION_NAME&name={{$info[0]->name}}&organizationId=35549462&issueYear=2023&issueMonth={{$mes}}&certUrl=https://glearning.com.co/evolucion/insignia/win/{{$info[0]->id}}&certId={{$info[0]->id}} ">
               Compartir en perfil <i class="bi bi-linkedin"></i>
             </a>
                          <!--end boton-->
             @endauth
              <!-- Modal -->
                <div class="modal" id="comu{{$info[0]->id}}">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content" style="border-radius:20px;">
                        <div class="modal-header">
                        <h5 class="modal-title tletra">Compartir insignia</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="text-align:left;">
                            <p>
                                Por favor, introduce la URL de tu perfil de LinkedIn en el campo correspondiente para poder agregar una insignia a tu perfil.
                            </p>
                            <p>
                                La URL debe seguir el siguiente formato: <b><br>https://www.linkedin.com/in/tu-nombre-de-perfil/</b></p>
                            <p>Para obtener esta URL, ve a LinkedIn, haz clic en ver perfil, copia la URL y pégala en el campo indicado.</p> 
                            <!--aqui debe ir-->
                             <!--colapsed-->
                             <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                              Información de insignia
                            </button>
                            
                            <div class="collapse" id="collapseExample">
                                <div class="card card-body">
                                   <p>Nombre: {{($info[0]->name) }}</p> 
                                    <p>Empresa emisora: Evolución / Aprendizaje Divertido</p> 
                                    <p>Fecha expedición: {{$info[0]->created_at}}</p> 
                                    <p>Fecha caducidad: Indefinido</p> 
                                    <p>ID credencial: </p> 
                                    <p>Url de la credencial: </p>
                                </div>
                            </div>
                            <br><br>
                            <!--end colapsed-->
                            <label for="usuario">Url de LinkedIn:</label>
                            <input type="text" name="urlval"  id="urlval"  class="form-control" onInput="validarInput()" />
                            <br>
                        </div>
                       
                        <div class="modal-footer">
                          <button type="button" class="btn btn-warning"  data-bs-dismiss="modal" id="btncerrar">Cerrar</button>
                          <button onclick="compartirLinkedIn()" name="add_to_cart" id="btnCompartir" class="btn btn-info" style="display: none;">Compartir</button>
                        </div>
                    </div>
                    </div>
                </div>
                <!--end modal-->
                </div> 
            <div class="col-md-2 col-xs-2 col-sm-2"></div> 
        </div>
    </div>
    <br>
  <!--end compartir-->
  <!--#################################################################################--->
  <footer class="d-none d-lg-block">
  <div style="background-color:#1ED5F4;">
    <div class="container text-center tletra">
       <br><p style="font-size:20px;">&copy; 2023 Evolución SAS. Todos los derechos reservados.</p>
       <br>
    </div>
    </div>
  </footer>
 
  <footer class="footer  d-block d-sm-none">
  <div style="background-color:#1ED5F4;">
    <div class="container text-center tletra">
       <br><p style="font-size:18px;">&copy; 2023 Evolución SAS. Todos los derechos reservados.</p>
       <br>
    </div>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script>
    function validarInput() {
      var btnCompartir = document.getElementById("btnCompartir");
      var btncerrar = document.getElementById("btncerrar");
      var usuarioInput = document.getElementById("urlval");

      if (!usuarioInput.value.length) {
        btnCompartir.style.display = "none";
      } else if (usuarioInput.value.includes("https://www.linkedin.com/in/")) {
        //compartirLinkedIn();
        btncerrar.style.display = "none";
        btnCompartir.style.display = "block";

      } else {
        console.log('La URL no es válida');
      }
    }
    function compartirLinkedIn() {
        var usuarioInput = document.getElementById("urlval");
        var usuario = usuarioInput.value;
        var url = usuario + "edit/forms/certification/new/?profileFormEntryPoint=PROFILE_COMPLETION_HUB";
        window.open(url, "_blank");
      }
  </script>
  <!--aqui gener pdf-->
  <script>
        document.getElementById('btnDownload').addEventListener('click', function() {
            const elementToCapture = document.getElementById('elementToCapture');

            html2canvas(elementToCapture).then(function(canvas) {
                const imgData = canvas.toDataURL('image/png');

                const img = new Image();
                img.src = imgData;

                /*const pdf = new jsPDF();
                pdf.addImage(img, 'PNG', 15, 15, 180, 0);
                pdf.save('midiploma.pdf');*/

                const link = document.createElement('a');
                link.href = imgData;
                link.download = 'midiploma.png';
                link.click();
            });
        });
    </script>
      <script>
        document.getElementById('btnDownload2').addEventListener('click', function() {
            const elementToCapture = document.getElementById('elementToCapture2');

            html2canvas(elementToCapture).then(function(canvas) {
                const imgData = canvas.toDataURL('image/png');

                const img = new Image();
                img.src = imgData;

                /*const pdf = new jsPDF();
                pdf.addImage(img, 'PNG', 15, 15, 180, 0);
                pdf.save('midiploma.pdf');*/

                const link = document.createElement('a');
                link.href = imgData;
                link.download = 'midiploma.png';
                link.click();
            });
        });
    </script>
</body>
</html>
