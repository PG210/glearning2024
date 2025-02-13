
document.addEventListener("DOMContentLoaded", function() {
  // Definir una variable
  if (window.valor) {
      let miVariable = window.valor;
      localStorage.setItem("miClave", miVariable);  // Guardar en localStorage
  }
});


window.InitUserScripts = function(){
  var player = GetPlayer();
  var object = player.object;
  var addToTimeline = player.addToTimeline;
  var setVar = player.SetVar;
  var getVar = player.GetVar;

  window.Script1 = function(){

    var player = GetPlayer();
    var avatar = player.GetVar("avatar");
    console.log(avatar);
    /* recuperar el valor de local storage */
    let valorGuardado = localStorage.getItem("miClave");  // Recuperar desde localStorage
    console.log("Valor de id avatar desde la vista blade:", valorGuardado);
  
    player.SetVar("avatar", valorGuardado); // Asignar un nuevo valor
  }
 
};



