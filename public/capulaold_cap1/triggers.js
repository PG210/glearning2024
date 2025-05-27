/* informacion */

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
      case "6LhMoeULu4F":
        avat(userData.idavat);
        console.log('caso 1 se ejecuto');
        console.log('idreto', idreto);
        break;
      case "5z9HksGayrW":
        avat2(userData.idavat, userData.nomavat, nomcom); //script 2
        console.log('caso 2 se ejecuto');
        break;
      case "6UGn4pc0sJ4": /*Avatar aleatorio 1 */
        let nom1 = datausers[0].nombre + " " + datausers[0].apellido;
        let nomavat1 = datausers[0].nomavat;
        let idavat1 = datausers[0].idavat;
        avat2(idavat1, nomavat1, nom1); //script 2
        console.log('avatar', datausers[0]);
        console.log('caso 3 se ejecuto');
        break;
      case "6mc7AK4dzIh": /*Avatar aleatorio 2 */
        let nom2 = datausers[1].nombre + " " + datausers[1].apellido;
        let nomavat2 = datausers[1].nomavat;
        let idavat2 = datausers[1].idavat;
        avat2(idavat2, nomavat2, nom2); //script 2
        console.log('avatar', datausers[1]);
        console.log('caso 4 se ejecuto');
        break;
      case "5yo9wi9jyYi":
        avat2(userData.idavat, userData.nomavat, nomcom); //script 2
        console.log('caso 5 se ejecuto');
        break;
      case "5duPCOwngpA":
        respuesta();
        break;
  }
}

window.InitExecuteScripts = function()
{
var player = GetPlayer();
var object = player.object;
var addToTimeline = player.addToTimeline;
var setVar = player.SetVar;
var getVar = player.GetVar;
};

/*actualizar el avatar principal */
function avat(id){
  var player = GetPlayer();
  player.SetVar("avatar", 0);  /*limpiar la variable */       
  player.SetVar("avatar", id);
}

/*actualizar el avatar 2 */
function avat2(id, nomavat, nomperson){

  var player = GetPlayer();
  player.SetVar("avatar", 0);  /*limpiar la variable */       
  player.SetVar("avatar", id);


  player.SetVar("navatar", "");
  player.SetVar("navatar",nomavat);

  player.SetVar("nplayer", "");
  player.SetVar("nplayer", nomperson);

}

function respuesta(){
  let player = GetPlayer();
  let respuesta = player.GetVar("respuesta");
  let tok1 = JSON.parse(localStorage.getItem("tok1"));
  //let idreto = localStorage.getItem("idreto");
  console.log('token', tok1);
 
  /* enviar la respuesta al backend */
  if (respuesta) {
    console.log('enviando datos', respuesta);
    fetch("/saveDatos", {  // Ruta en Laravel
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": tok1
        },
        body: JSON.stringify({ data: respuesta, idreto:idreto })
        
    })
    .then(response => response.json())
    .then(result => console.log("Respuesta del servidor:", result))
    .catch(error => console.error("Error:", error));
  }

}
