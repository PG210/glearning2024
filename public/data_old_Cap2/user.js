/*window.InitUserScripts = function()
{
var player = GetPlayer();
var object = player.object;
var once = player.once;
var addToTimeline = player.addToTimeline;
var setVar = player.SetVar;
var getVar = player.GetVar;
window.Script1 = function()
{
  var player = GetPlayer();
var avatar = player.GetVar("avatar");
console.log(avatar);


var idavatar=4;
avatar=idavatar;
console.log(avatar);
player.SetVar("avatar",idavatar);
}

window.Script2 = function()
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

window.Script3 = function()
{
  // Obtener el reproductor de Storyline
var player = GetPlayer();

// Valores de configuración
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

window.Script4 = function()
{
  //linea para conseguir la imagen//
var player = GetPlayer();
var avatar = player.GetVar("avatar");
console.log(avatar);


var idavatar=4;
avatar=idavatar;
console.log(avatar);
player.SetVar("avatar",idavatar);

//linea para conseguir el nombre del cyborg//
var player = GetPlayer();
var navatar = player.GetVar("navatar");
console.log(navatar);

var idavatar=blank;
navatar=idavatar;
console.log(navatar);
player.SetVar("navatar",idavatar);

//línea para conseguir el nombre del jugador//
var player = GetPlayer();
var nplayer = player.GetVar("nplayer");
console.log(nplayer)

var idavatar=blank;
nplayer=idavatar;
console.log(nplayer);
player.SetVar("nplayer",idavatar);
}

window.Script5 = function()
{
  // Obtener el reproductor de Storyline
var player = GetPlayer();

// Valores de configuración
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

window.Script6 = function()
{
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

window.Script7 = function()
{
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

window.Script8 = function()
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

window.Script9 = function()
{
  //linea para conseguir la imagen//
var player = GetPlayer();
var avatar = player.GetVar("avatar");
console.log(avatar);


var idavatar=4;
avatar=idavatar;
console.log(avatar);
player.SetVar("avatar",idavatar);

//linea para conseguir el nombre del cyborg//
var player = GetPlayer();
var navatar = player.GetVar("navatar");
console.log(navatar);

var idavatar=blank;
navatar=idavatar;
console.log(navatar);
player.SetVar("navatar",idavatar);

//línea para conseguir el nombre del jugador//
var player = GetPlayer();
var nplayer = player.GetVar("nplayer");
console.log(nplayer)

var idavatar=blank;
nplayer=idavatar;
console.log(nplayer);
player.SetVar("nplayer",idavatar);
}

window.Script10 = function()
{
  // Obtener el reproductor de Storyline
var player = GetPlayer();

// Valores de configuración
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

window.Script11 = function()
{
  //linea para conseguir la imagen//
var player = GetPlayer();
var avatar = player.GetVar("avatar");
console.log(avatar);


var idavatar=4;
avatar=idavatar;
console.log(avatar);
player.SetVar("avatar",idavatar);

//linea para conseguir el nombre del cyborg//
var player = GetPlayer();
var navatar = player.GetVar("navatar");
console.log(navatar);

var idavatar=blank;
navatar=idavatar;
console.log(navatar);
player.SetVar("navatar",idavatar);

//línea para conseguir el nombre del jugador//
var player = GetPlayer();
var nplayer = player.GetVar("nplayer");
console.log(nplayer)

var idavatar=blank;
nplayer=idavatar;
console.log(nplayer);
player.SetVar("nplayer",idavatar);
}

window.Script12 = function()
{
  // Obtener el reproductor de Storyline
var player = GetPlayer();

// Valores de configuración
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

window.Script13 = function()
{
  // Obtener el reproductor de Storyline
var player = GetPlayer();

// Valores de configuración
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

window.Script14 = function()
{
  // Obtener el reproductor de Storyline
var player = GetPlayer();

// Valores de configuración
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

window.Script15 = function()
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

window.Script16 = function()
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

window.Script17 = function()
{
  // Obtener el reproductor de Storyline
var player = GetPlayer();

// Valores de configuración
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

window.Script18 = function()
{
  // Obtener el reproductor de Storyline
var player = GetPlayer();

// Valores de configuración
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

window.Script19 = function()
{
  //linea para conseguir la imagen//
var player = GetPlayer();
var avatar = player.GetVar("avatar");
console.log(avatar);


var idavatar=4;
avatar=idavatar;
console.log(avatar);
player.SetVar("avatar",idavatar);

//linea para conseguir el nombre del cyborg//
var player = GetPlayer();
var navatar = player.GetVar("navatar");
console.log(navatar);

var idavatar=blank;
navatar=idavatar;
console.log(navatar);
player.SetVar("navatar",idavatar);

//línea para conseguir el nombre del jugador//
var player = GetPlayer();
var nplayer = player.GetVar("nplayer");
console.log(nplayer)

var idavatar=blank;
nplayer=idavatar;
console.log(nplayer);
player.SetVar("nplayer",idavatar);
}

window.Script20 = function()
{
  // Obtener el reproductor de Storyline
var player = GetPlayer();

// Valores de configuración
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

window.Script21 = function()
{
  var respuesta = player.GetVar("respuesta");
console.log(respuesta);
}

};*/
