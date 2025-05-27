function ExecuteScript(strId)
{
  /*Recuperar los datos para el avatar principal */
  let userData = JSON.parse(localStorage.getItem("userData"));
  let nomcom = userData.nombre + " " + userData.apellido;

  /*Recuperar los avatars random */
  let datausers = JSON.parse(localStorage.getItem("datrandom"));

  let idreto = JSON.parse(localStorage.getItem("idreto"));


  switch (strId)
  {
      case "6Pj3I0Kckle":
        Script1(userData.idavat);
        break;
      case "6cUF4DbTHpj":
        Script2();
        console.log('caso 2 se ejecuto');
        break;
      case "5Um6kY3NTFx":
        Script2(); //es el mismo caso que el script 2
        console.log('caso 3 se ejecuto');
        break;
      case "6qeixQrXpPQ":
        Script4(userData.idavat, userData.nomavat, nomcom);
        console.log('caso 4 se ejecuto');
        break;
      case "5W1BSQVQvUG":
        Script2();
        console.log('caso 5 se ejecuto');
        break;
      case "6C1z6brQrhk":
        Script6();
        console.log('caso 6 se ejecuto');
        break;
      case "6hCIC5nIaPn":
        Script7();
        console.log('caso 7 se ejecuto');
        break;
      case "6Vnw6stNP9n":
        Script8();
        console.log('caso 8 se ejecuto');
        break;
      case "6iMBUYdZ58o":
        Script4(userData.idavat, userData.nomavat, nomcom); //es igual al caso 4
        console.log('caso 9 se ejecuto');
        break;
      case "62HRKp6W1o5":
        Script2(); //este caso corresponde al mismo caso 2
        console.log('caso 10 se ejecuto');
        break;
      case "5exgDjKNzAU":
        Script4(userData.idavat, userData.nomavat, nomcom);
        console.log('caso 11 se ejecuto verificar');
        break;
      case "60cT1kT26Oz":
        Script2(); //revisar aqui 
        console.log('caso 12 se ejecuto');
        break;
      case "6maNU9s2z2d":
        Script2();
        console.log('caso 13 se ejecuto');
        break;
      case "5bRoJuTidy7":
        Script2();
        console.log('caso 14 se ejecuto');
        break;
      case "6gIpzlciaAe":
        Script2();
        console.log('caso 15 se ejecuto');
        break;
      case "6at6wO92781":
        Script2();
        console.log('caso 16 se ejecuto');
        break;
      case "5vyrC49ksaq":
        Script2();
        console.log('caso 17 se ejecuto');
        break;
      case "5fZOc7lWY36":
        Script2();
        console.log('caso 18 se ejecuto');
        break;
      case "5fnC9wWx98L":
        //usuario aleatorio
        let nomper = datausers[0].nombre + " " + datausers[0].apellido;
        let nomavat = datausers[0].nomavat;
        let idavat = datausers[0].idavat;
        Script4(idavat, nomavat, nomper); //script 2
        console.log('caso 19 se ejecuto');
        break;
      case "612893yAeiJ":
        Script2();
        console.log('caso 20 se ejecuto');
        break;
      case "6oYQ2IIH2ar":
        Script21();
        console.log('caso 21 se ejecuto');
        break;
  }
}

window.InitExecuteScripts = function()
{
var player = GetPlayer();
var object = player.object;
var once = player.once;
var addToTimeline = player.addToTimeline;
var setVar = player.SetVar;
var getVar = player.GetVar;
};

/*actualizar el avatar principal */
function Script1(id){
  var player = GetPlayer();
  player.SetVar("avatar", 0);  /*limpiar la variable */       
  player.SetVar("avatar", id);
}


function Script2()
{
  // Obtener el reproductor de Storyline
var player = GetPlayer();

// Valores de configuración
var valorInicial = 0;
var valorFinal = 10000;
var paso = 1; // cuánto aumenta cada vez
var intervalo = 1100; // tiempo en milisegundos entre cada incremento (50ms = rápido)

// Nombre de la variable de Storyline
var nombreVariable = "Contador"; // asegúrate de que la variable exista en Storyline

// Inicializa la variable en Storyline
player.SetVar(nombreVariable, valorInicial);

// Función de conteo
var intervaloID = setInterval(function() {
    valorInicial += paso;
    if (valorInicial > valorFinal) {
        clearInterval(intervaloID); // Detener cuando se alcanza el valor final
    } else {
        player.SetVar(nombreVariable, valorInicial);
    }
}, intervalo);

}


function Script4(id, nomavat, nomperson){//avatar de la persona logueada
  //linea para conseguir la imagen//
var player = GetPlayer();
player.SetVar("avatar", 0);  /*limpiar la variable */       
player.SetVar("avatar", id);

//linea para conseguir el nombre del cyborg//
player.SetVar("navatar", "");
player.SetVar("navatar",nomavat);

player.SetVar("nplayer", "");
player.SetVar("nplayer", nomperson);

}

function Script6(){
  var player = GetPlayer(); // Obtiene el reproductor de Storyline
  var contador1 = player.GetVar("contador1")
  var contador1 = 0; // Inicializa el contador
  var limite = 90; // Establece el límite máximo del contador
  var velocidad = 35; // Velocidad en milisegundos (1000ms = 1s)

  function iniciarContador() {
      var intervalo = setInterval(function () {
          if (contador1 < limite) {
              contador1++;
              player.SetVar("contador1", contador1); // Actualiza la variable en Storyline
          } else {
              clearInterval(intervalo); // Detiene el contador cuando alcanza el límite
          }
      }, velocidad);
  }

  iniciarContador(); // Inicia el contador

  var player = GetPlayer(); // Obtiene el reproductor de Storyline
  var contador1 = player.GetVar("contador2")
  var contador1 = 0; // Inicializa el contador
  var limite = 90; // Establece el límite máximo del contador
  var velocidad = 25; // Velocidad en milisegundos (1000ms = 1s)
}

function Script7(){
  var player = GetPlayer(); // Obtiene el reproductor de Storyline
  var contador2 = player.GetVar("contador2")
  var contador2 = 0; // Inicializa el contador
  var limite = 60; // Establece el límite máximo del contador
  var velocidad = 50; // Velocidad en milisegundos (1000ms = 1s)

  function iniciarContador() {
      var intervalo = setInterval(function () {
          if (contador2 < limite) {
              contador2++;
              player.SetVar("contador2", contador2); // Actualiza la variable en Storyline
          } else {
              clearInterval(intervalo); // Detiene el contador cuando alcanza el límite
          }
      }, velocidad);
  }

  iniciarContador(); // Inicia el contador

  var player = GetPlayer(); // Obtiene el reproductor de Storyline
  var contador2 = player.GetVar("contador2")
  var contador2 = 0; // Inicializa el contador
  var limite = 60; // Establece el límite máximo del contador
  var velocidad = 20; // Velocidad en milisegundos (1000ms = 1s)
}

function Script8()
{
  var player = GetPlayer(); // Obtiene el reproductor de Storyline
  var contador3 = player.GetVar("contador3")
  var contador3 = 0; // Inicializa el contador
  var limite = 50; // Establece el límite máximo del contador
  var velocidad = 50; // Velocidad en milisegundos (1000ms = 1s)

  function iniciarContador() {
      var intervalo = setInterval(function () {
          if (contador3 < limite) {
              contador3++;
              player.SetVar("contador3", contador3); // Actualiza la variable en Storyline
          } else {
              clearInterval(intervalo); // Detiene el contador cuando alcanza el límite
          }
      }, velocidad);
  }


  iniciarContador(); // Inicia el contador

  var player = GetPlayer(); // Obtiene el reproductor de Storyline
  var contador3 = player.GetVar("contador3")
  var contador3 = 0; // Inicializa el contador
  var limite = 50; // Establece el límite máximo del contador
  var velocidad = 15; // Velocidad en milisegundos (1000ms = 1s)
}


function Script11(id, navat, nomper){
  //linea para conseguir la imagen//
  var player = GetPlayer();
  player.SetVar("avatar", id); //no sale el avatar

  //linea para conseguir el nombre del cyborg//
  player.SetVar("navatar", navat);

  //línea para conseguir el nombre del jugador//
  player.SetVar("nplayer", nomper);

}

function Script21()
{
  var respuesta = player.GetVar("respuesta");
  console.log(respuesta);
}