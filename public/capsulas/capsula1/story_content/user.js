window.InitUserScripts = function()
{
var player = GetPlayer();
var object = player.object;
var addToTimeline = player.addToTimeline;
var setVar = player.SetVar;
var getVar = player.GetVar;
window.Script1 = function()
{
  
// Capturar las variables
var contm = player.GetVar("ContM");
var puntajemision = player.GetVar("PuntajeMision");
console.log(puntajemision,contm)
// Realizar la operación
puntajemision = puntajemision - contm;

// Mostrar el resultado en la consola
console.log("Nuevo PuntajeMision: ", puntajemision);
sendData(puntajemision); //llama a la funcion para enviar los datos

}

};

//ajax
function sendData(data) {
    console.log('hola valor', data);
    $.ajax({
        url: '/capsula/'+data,
        type: "GET",
        dataType: "json",
        success: function (response) {
            // Aquí puedes manejar la respuesta
            console.log("Respuesta del servidor: ", response);
            window.alert('Datos recibidos de manera correcta');
        },
        error: function (xhr, status, error) {
            // Manejar errores
            console.error("Error en la petición: ", status, error);
        }
    });
}
