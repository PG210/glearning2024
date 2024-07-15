document.getElementById('boton-m').addEventListener('click', function(event) {
     event.preventDefault(); // Evita que el enlace navegue
     document.getElementById('seccion1').style.display = 'none'; // Oculta la sección
     document.getElementById('seccionFem').style.display = 'block'; // mostrar la seccion femenio
 });
// boton maculino
document.getElementById('boton-masculino').addEventListener('click', function(event) {
     event.preventDefault(); // Evita que el enlace navegue
     document.getElementById('seccion1').style.display = 'none'; // Oculta la sección
     document.getElementById('seccionFem').style.display = 'none'; // mostrar la seccion femenio
     document.getElementById('seccionMas').style.display = 'block'; // mostrar la seccion femenio
 });
// boton de volver
document.getElementById('volver').addEventListener('click', function(event) {
     event.preventDefault(); // Evita que el enlace navegue
     document.getElementById('seccion1').style.display = 'block'; // Oculta la sección
     document.getElementById('seccionFem').style.display = 'none'; // mostrar la seccion femenio
});
document.getElementById('volver2').addEventListener('click', function(event) {
     event.preventDefault(); // Evita que el enlace navegue
     document.getElementById('seccion1').style.display = 'block'; // Oculta la sección
     document.getElementById('seccionMas').style.display = 'none'; // mostrar la seccion femenio
});
