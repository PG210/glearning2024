<?php

use App\Http\Controllers\Carga\SubirArchivoController;
use App\Http\Controllers\Perfil\PerfilController;
use App\Http\Controllers\RegController\RegunicoController;
use App\Http\Controllers\ReportcompletosController;
use App\Http\Controllers\Carga\GruposController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Perfil\InsigniaController; //se agrego para insigias
use App\Http\Controllers\Carga\GruposRecom;
use App\Http\Controllers\Carga\GruposInsignias;//se agrego este controlador
use App\Http\Controllers\Carga\PorcentajeController;//se agrego este controlador
use App\Http\Controllers\Perfil\Administrador;//se agrego este controlador
use App\Http\Controllers\Perfil\PorcentajeAdmin;//se agrego este controlador
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
   // return view('welcome');
   return redirect('/login');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home')->middleware('redirectIfSessionExpired');

//perfil cuando ingresa el usuario
Route::get('/home/perfil', [PerfilController::class, 'index'])->name('perfilhome')->middleware('redirectIfSessionExpired');

//actualizar usuario datos al controlador
Route::post('/actualizar/usuario/{id}', [PerfilController::class, 'actu'])->name('actualizarusu')->middleware('redirectIfSessionExpired');

//actualizar vavatar
Route::get('/update/ciborg/{id}', [PerfilController::class, 'saveCiborg'])->name('saveCiborg');

Route::get('/historia', function () {
    return view('historia');
})->middleware('auth')->middleware('redirectIfSessionExpired');

Route::get('/playerchapters', 'PlayerChaptersController@index')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::resource('playerchapters', 'PlayerChaptersController')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::resource('startchallenges', 'PlayerChallengeController')->middleware('auth')->middleware('redirectIfSessionExpired');


Route::get('/playerchapter/{id}', ['uses' =>'PlayerChaptersController@pasarchapter', 'as'=>'profile.pasarchapter'])->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/playerchallenge/{id}', ['uses' =>'PlayerChaptersController@pasarchallenge', 'as'=>'profile.pasarchallenge'])->middleware('auth')->middleware('redirectIfSessionExpired');


//pasarle id reto a la pantalla de retos en el player
Route::get('/challenge/{id}', ['uses' =>'PlayerChallengeController@challenge', 'as'=>'player.challenge'])->middleware('auth')->middleware('redirectIfSessionExpired');

//comenzar el juego test encuestas
Route::get('/startchallenge/{id}', ['uses' =>'PlayerChallengeController@startplay', 'as'=>'player.startchallenge'])->middleware('auth')->middleware('redirectIfSessionExpired');

Route::get('/startchallenge', function () {
    return view('player.startchallenge');
})->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/playerCapitulos', function () {
    return view('player.capitulos');
})->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/grupos', function () {
    return view('player.grupos');
})->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/finishquiz', function () {
    return view('player.finishquiz');
})->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/insignias', function () {
    return view('player.insignias');
})->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/perfil', function () {
    return view('player.perfil');
})->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/recompensas', function () {
    return view('player.recompensas');
})->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/reconocimientos', function () {
    return view('player.recompensas');
})->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/retosUser', function () {
    return view('player.retos');
})->middleware('auth')->middleware('redirectIfSessionExpired');

//Route::get('/subcapitulos/{id}', 'SubcapituloController@pasardatos');
//Route::get('/editindustry/{id}', 'SubcapituloController@create');

Route::get('/subcaps/{id}', ['uses' =>'SubcapituloController@pasarcapitulo', 'as'=>'subcapitulos.pasarcapitulo'])->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/challenges/{id}', ['uses' =>'RetosController@pasarsubcapitulo', 'as'=>'retos.pasarsubcapitulo'])->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/verretos/{id}', ['uses' =>'RetosController@datosreto', 'as'=>'retos.datosreto'])->middleware('auth')->middleware('redirectIfSessionExpired');

Route::get('/areasregistro', 'AreaController@areasregistro')->middleware('redirectIfSessionExpired');
Route::get('/positionsregistro/{id}', ['uses' =>'AreaController@positionsregistro', 'as'=>'retos.positionsregistro'])->middleware('redirectIfSessionExpired');


Route::get('/quizzesupdate/{id}', ['uses' =>'QuizController@quizzesupdate', 'as'=>'retos.quizzesupdate'])->middleware('redirectIfSessionExpired');
Route::get('/quizzesquestionsupdate/{id}', ['uses' =>'QuizController@quizzesquestionsupdate', 'as'=>'retos.quizzesquestionsupdate'])->middleware('redirectIfSessionExpired');
Route::get('/quizzesquestionanswerssupdate/{id}', ['uses' =>'QuizController@quizzesquestionanswerssupdate', 'as'=>'retos.quizzesquestionanswerssupdate'])->middleware('redirectIfSessionExpired');


Route::get('/usuario', 'UserController@index')->middleware('redirectIfSessionExpired');
Route::resource('usuario', 'UserController')->middleware('redirectIfSessionExpired');

Route::get('/insignias', 'InsigniasController@index')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::resource('insignias', 'InsigniasController')->middleware('auth')->middleware('redirectIfSessionExpired');

Route::get('/reportcompletos', 'ReportcompletosController@index')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::resource('reportcompletos', 'ReportcompletosController')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::post('/reportcompletosinfo/{id}', ['uses' =>'ReportcompletosController@more', 'as'=>'reportcompletos.more'])->middleware('auth')->middleware('redirectIfSessionExpired');

Route::get('/reportjugados', 'ReportjugadosController@index')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::resource('reportjugados', 'ReportjugadosController')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/reportjugadosinfo/{id}', ['uses' =>'ReportjugadosController@more', 'as'=>'reportjugados.more'])->middleware('auth')->middleware('redirectIfSessionExpired');


Route::get('/competencias', 'CompetenciasController@index')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::resource('competencias', 'CompetenciasController')->middleware('auth')->middleware('redirectIfSessionExpired');

Route::get('/reconocimientos', 'AwardController@index')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::resource('reconocimientos', 'AwardController')->middleware('auth')->middleware('redirectIfSessionExpired');

Route::get('/causas', 'CausasController@index')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::resource('causas', 'CausasController')->middleware('auth')->middleware('redirectIfSessionExpired');

Route::get('/causasadmin', 'causasadminController@index')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::resource('causasadmin', 'causasadminController')->middleware('auth')->middleware('redirectIfSessionExpired');

Route::get('/quizzes', 'QuizController@index')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::resource('quizzes', 'QuizController')->middleware('auth')->middleware('redirectIfSessionExpired');

Route::get('/quizzesdisponible', 'QuizAvailableController@index')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::resource('quizzesdisponible', 'QuizAvailableController')->middleware('auth')->middleware('redirectIfSessionExpired');

Route::get('/capitulos', 'CapitulosController@index')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::resource('capitulos', 'CapitulosController')->middleware('auth')->middleware('redirectIfSessionExpired');

Route::get('/subcapitulos', 'SubcapituloController@index')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::resource('subcapitulos', 'SubcapituloController')->middleware('auth')->middleware('redirectIfSessionExpired');

Route::get('/retos', 'RetosController@index')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::resource('retos', 'RetosController')->middleware('auth')->middleware('redirectIfSessionExpired');

Route::middleware(['auth', 'adminsgo'])->group(function () {

    Route::get('/backdoor', function () {
        return view('admin.dashboard');
    })->middleware('auth')->middleware('redirectIfSessionExpired');

    Route::get('/jefes', 'JefeController@index')->middleware('auth')->middleware('redirectIfSessionExpired');
    Route::resource('jefes', 'JefeController')->middleware('auth')->middleware('redirectIfSessionExpired');

    Route::get('/jefesareas', 'jefesAreasController@index')->middleware('auth')->middleware('redirectIfSessionExpired');
    Route::resource('jefesareas', 'jefesAreasController')->middleware('auth')->middleware('redirectIfSessionExpired');

    Route::get('/jefestipos', 'jefestiposController@index')->middleware('auth')->middleware('redirectIfSessionExpired');
    Route::resource('jefestipos', 'jefestiposController')->middleware('auth')->middleware('redirectIfSessionExpired');


    Route::get('/cargos', 'CargoController@index')->middleware('auth')->middleware('redirectIfSessionExpired');
    Route::resource('cargos', 'CargoController')->middleware('auth')->middleware('redirectIfSessionExpired');

    Route::get('/areas', 'AreaController@index')->middleware('auth')->middleware('redirectIfSessionExpired');
    Route::resource('areas', 'AreaController')->middleware('auth')->middleware('redirectIfSessionExpired');

    //carga masiva
    Route::get('/carga/users', function () {
        return view('admin.carga');
    })->name('cargamasiva')->middleware('auth')->middleware('redirectIfSessionExpired');

});


Route::get('/versus/{id}', ['uses' =>'VersusController@pasarversus', 'as'=>'versus.pasarversus'])->middleware('auth')->middleware('redirectIfSessionExpired');
Route::post('/versusinvitar', ['uses' =>'VersusController@invitaciones', 'as'=>'versus.invitaciones'])->middleware('auth')->middleware('redirectIfSessionExpired');

Route::get('/versus', 'VersusController@index')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::resource('versus', 'VersusController')->middleware('auth')->middleware('redirectIfSessionExpired');

Route::get('/about', function () {
    return view('acerca_de_evolucion');
})->middleware('auth')->middleware('redirectIfSessionExpired');

Route::get('/faq', function () {
    return view('faq');
})->middleware('auth')->middleware('redirectIfSessionExpired');



// =========== juegos unity ===========
Route::get('/gameahorcado', function () {
    return view('games.ahorcado');
})->name('games.ahorcado')->middleware('auth')->middleware('redirectIfSessionExpired');

Route::get('/gamerompecabeza', function () {
    return view('games.rompecabezas');
})->name('games.rompecabezas')->middleware('auth')->middleware('redirectIfSessionExpired');

Route::get('/gamesopaletra', function () {
    return view('games.sopaletras');
})->name('games.sopaletras')->middleware('auth')->middleware('redirectIfSessionExpired');




// =========== Juegos Casuales ==============
Route::get('/ahorcado/{id}', ['uses' =>'GamesController@ahorcado', 'as'=>'games.ahorcado'])->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/sopaletras/{id}', ['uses' =>'GamesController@sopaletras', 'as'=>'games.sopaletras'])->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/rompecabezas/{id}', ['uses' =>'GamesController@rompecabezas', 'as'=>'games.rompecabezas'])->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/seevideos/{id}', ['uses' =>'GamesController@seevideos', 'as'=>'games.seevideos'])->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/upfotos/{id}', ['uses' =>'GamesController@upfotos', 'as'=>'games.upfotos'])->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/lectura/{id}', ['uses' =>'GamesController@lectura', 'as'=>'games.lectura'])->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/outdoor/{id}', ['uses' =>'GamesController@outdoor', 'as'=>'games.outdoor'])->middleware('auth')->middleware('redirectIfSessionExpired');


//funciones guardado resultado
Route::post('/unitygamesplayed/{id}', ['uses' =>'GamesController@unitygamesplayed', 'as'=>'gamesplay.unitygamesplayed'])->middleware('auth')->middleware('redirectIfSessionExpired');
Route::post('/playseevideos/{id}', ['uses' =>'GamesController@playseevideos', 'as'=>'gamesplay.seevideos'])->middleware('auth')->middleware('redirectIfSessionExpired');
Route::post('/playupfotos/{id}', ['uses' =>'GamesController@playupfotos', 'as'=>'gamesplay.upfotos'])->middleware('auth')->middleware('redirectIfSessionExpired');
Route::post('/playlectura/{id}', ['uses' =>'GamesController@playlectura', 'as'=>'gamesplay.lectura'])->middleware('auth')->middleware('redirectIfSessionExpired');
Route::post('/playoutdoor/{id}', ['uses' =>'GamesController@playoutdoor', 'as'=>'gamesplay.outdoor'])->middleware('auth')->middleware('redirectIfSessionExpired');


//funciones VUEJS para popups
Route::get('/popupinsignia', 'PopupsController@index')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::resource('popupinsignia', 'PopupsController')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/popupinsignias/{id}', ['uses' =>'PopupsController@popupinsignia', 'as'=>'popupinsignias.popupi'])->middleware('auth')->middleware('redirectIfSessionExpired');


Route::resource('gamescontroller', 'GamesController')->middleware('auth')->middleware('redirectIfSessionExpired');

//Game OVER
Route::get('/gameover', function () {
    return view('player.gameover');
})->middleware('auth')->middleware('auth')->middleware('redirectIfSessionExpired');

//ruta subir carga masiva

Route::post('/subir', [SubirArchivoController::class, 'index'])->name('subir')->middleware('redirectIfSessionExpired');
Route::get('/carga/usu/masiva', [SubirArchivoController::class, 'cargar'])->name('crg')->middleware('redirectIfSessionExpired');
Route::get('/carga/usu/registro/{file}', [SubirArchivoController::class, 'registrar'])->name('carga_usu')->middleware('redirectIfSessionExpired');
Route::get('/carga/usu/eliminar/{file}', [SubirArchivoController::class, 'eliminar'])->name('eliminar_arch')->middleware('redirectIfSessionExpired');

//egistro de usuario
Route::get('/admin/registro/unico', [RegunicoController::class, 'index'])->name('usureg_admin')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::post('/admin/reg/usu', [RegunicoController::class, 'regunico'])->name('regunicousuario')->middleware('auth')->middleware('redirectIfSessionExpired');

//grupos
Route::get('/admin/vista/grupos', [GruposController::class, 'index'])->name('gruposvis')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::post('/admin/reg/grupos', [GruposController::class, 'reg'])->name('guardargrupo')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::post('/admin/actu/grupos/{id}', [GruposController::class, 'actu'])->name('actualizargrupo')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/admin/eliminar/grupos/{id}', [GruposController::class, 'eliminar'])->name('gruposelim')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/admin/usuarios/grupos', [GruposController::class, 'usuarios'])->name('usuariosgrupos')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::post('/admin/vincular/grupo/usu', [GruposController::class, 'vingrupo'])->name('vingrupo')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/admin/capitulos/grupos/{id}', [GruposController::class, 'vincap'])->name('vincap')->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/admin/capitulos/vin/usu/{id}/{id1}', [GruposController::class, 'vinculocap'])->middleware('auth')->middleware('redirectIfSessionExpired');
Route::get('/admin/capitulos/eliminar/usu/{id}/{id1}', [GruposController::class, 'eliminarvincap'])->middleware('auth')->middleware('redirectIfSessionExpired');
//end grupos
//Route::get('/generar/respuestas/nuevo/{id}', [ReportcompletosController::class, 'nuevoid'])->middleware('redirectIfSessionExpired');
Route::post('/generar/respuestas/nuevo', [ReportcompletosController::class, 'nuevoid'])->name('generatequest')->middleware('redirectIfSessionExpired');
//ruta para buscar usuarios
Route::post('/admin/buscar/user', [GruposController::class, 'buscarusu'])->name('buscar_usuario')->middleware('auth');

//actualizar perfil desde el admin
Route::get('/home/perfil/admin/{id}', [PerfilController::class, 'actuadmin'])->middleware('redirectIfSessionExpired');

//ctualizar usuario
Route::post('/home/perfil/usu/admin/{id}', [PerfilController::class, 'actualizarusuadmin'])->name('actualizarusuadmin')->middleware('redirectIfSessionExpired');

//buscador
Route::get('/reportcompletos/retos/{id}', [ReportcompletosController::class, 'usuretoster'])->middleware('redirectIfSessionExpired');

//buscar por grupo
Route::get('/reportcompletos/grupo/{id}', [GruposController::class, 'buscargrupo'])->name('buscargrupo')->middleware('redirectIfSessionExpired');

//filtro con php
Route::POST('/filtrar/usuarios/grupos', [GruposController::class, 'valFormu'])->name('valFormu')->middleware('redirectIfSessionExpired');

//buscar user retos
Route::POST('/filtrar/usuarios/grupos/retos', [GruposController::class, 'consultarter'])->name('consultarter')->middleware('redirectIfSessionExpired');
//ruta para integrar el perfil dentro de la aplicacion
Route::get('/home/perfil/usuario', [PerfilController::class, 'perfilhomedos'])->name('perfilhomedos')->middleware('redirectIfSessionExpired');
//deshabilitar usuario
Route::get('/deshabilitar/usuario/{id}', [PerfilController::class, 'deshabilitar'])->name('deshabilitar')->middleware('redirectIfSessionExpired');

//eliminar usuario
Route::get('/eliminar/usuario/{id}', [UserController::class, 'destroy'])->middleware('redirectIfSessionExpired');
//buscar usuario por correo
Route::get('/buscar/usuario/grupo', [GruposController::class, 'buscarcor'])->name('buscarcor')->middleware('redirectIfSessionExpired');

//############################################## nuevas funcionalidades
//vista para certificado
Route::get('/ver/insignia/{id}', [PerfilController::class, 'detinsignia']);
//registrar insignia por capitulo
Route::get('/formulario/insignia/capitulo', [InsigniaController::class, 'index'])->name('formuinsigcap')->middleware('redirectIfSessionExpired');
//guardar insignia de capitulo
Route::POST('/registrar/insignia/capitulo', [InsigniaController::class, 'guardar'])->name('insigniasguar')->middleware('redirectIfSessionExpired');
//elimnar insignias e capitulo
Route::get('/eliminar/insignia/capitulo/{id}', [InsigniaController::class, 'eliminar'])->name('deletinscap')->middleware('redirectIfSessionExpired');
//editar insignia
Route::get('/editar/insignia/capitulo/{id}', [InsigniaController::class, 'editar'])->name('editinscap')->middleware('redirectIfSessionExpired');
//editar insfignia formulario
Route::POST('/actualizar/insignia/capitulo', [InsigniaController::class, 'actualizar'])->name('actuignias')->middleware('redirectIfSessionExpired');
//descargar material
Route::get('/material/ver', [PerfilController::class, 'vistamaterial'])->middleware('redirectIfSessionExpired');

//activar grupos
Route::get('/activar/grupo/{id}', [GruposController::class, 'activargrupo'])->middleware('redirectIfSessionExpired');

//mapear rutas para el controlador de grupos de recompenss
Route::resource('gruporeconocimiento', 'Carga\GruposRecom')->middleware('redirectIfSessionExpired');
Route::POST('/gruporeconocimiento/actu', [GruposRecom::class, 'actu'])->name('acturec')->middleware('redirectIfSessionExpired');

//CATEGORIAS DE INSIGNIAS 
Route::get('/formulario/categorias', [GruposInsignias::class, 'formularioreg'])->name('formuCategory')->middleware('redirectIfSessionExpired');
Route::POST('/formulario/categorias/registro', [GruposInsignias::class, 'registrarCategoria'])->name('registrarCategoria')->middleware('redirectIfSessionExpired');
Route::get('/formulario/editcat/{id}', [GruposInsignias::class, 'formeditar'])->name('formuEditarCat')->middleware('redirectIfSessionExpired');
Route::POST('/formulario/editcat/registro', [GruposInsignias::class, 'regisEditCat'])->name('regisEditCat')->middleware('redirectIfSessionExpired');

//llamada a visualizarinsignia
Route::get('/evolucion/insignia/win/{id}', [PerfilController::class, 'insigniaVisu']);

//porcentajes
Route::get('/reporte/view/porcentaje', [PorcentajeController::class, 'index'])->name('porcentaje')->middleware('redirectIfSessionExpired');
//filtrarpor grupos
Route::post('/reporte/view/filtrar', [PorcentajeController::class, 'filtrar'])->name('valFormuPorcentaje')->middleware('redirectIfSessionExpired');

//enviar   correos
Route::post('/enviar-correos/{id}', [PorcentajeController::class, 'correos'])->middleware('redirectIfSessionExpired');

//================ perfil de administrcion ==============

Route::get('/admin', [Administrador::class, 'index'])->middleware('redirectIfSessionExpired');
//Route::get('/admin/reporte', [Administrador::class, 'resultado'])->name('reportegeneral')->middleware('redirectIfSessionExpired');
//================================================================================
Route::get('/admin/reporte', function () {
    return redirect('/admin/reporte/view/porcentaje');
})->name('reportegeneral')->middleware('redirectIfSessionExpired');
//============================================================================
Route::POST('/admin/reporte/busqueda', [Administrador::class, 'consultarter'])->name('consultauser')->middleware('redirectIfSessionExpired');
Route::get('/admin/detalle/{id}', [Administrador::class, 'detalle'])->name('detalleusu')->middleware('redirectIfSessionExpired');
Route::POST('/admin/mas/detalle', [Administrador::class, 'masdet'])->name('masdet')->middleware('redirectIfSessionExpired');
Route::POST('/admin/filtrar/usuarios/grupos', [Administrador::class, 'filtrarFormu'])->name('filtrarFormu')->middleware('redirectIfSessionExpired');
Route::get('/admin/reporte/view/porcentaje', [PorcentajeAdmin::class, 'porcentaje'])->name('porcentajeAdmin')->middleware('redirectIfSessionExpired');
Route::POST('/admin/reporte/view/filtrar', [PorcentajeAdmin::class, 'filtrar'])->name('AdminvalFormuPorcentaje')->middleware('redirectIfSessionExpired');
Route::post('/admin/enviar-correos/{id}', [PorcentajeAdmin::class, 'correos'])->middleware('redirectIfSessionExpired');

//===================== rutas para  cambio de avatars ====
Route::get('/admin/registrar/avatar', [PerfilController::class, 'regavatar'])->name('registrarAvatars')->middleware('redirectIfSessionExpired');
Route::POST('/admin/update/avatar', [PerfilController::class, 'actuAvatar'])->name('actuAvatar')->middleware('redirectIfSessionExpired');

//============ comentarios ============================
Route::POST('/admin/update/comentario/videos', [ReportcompletosController::class, 'comenVideos'])->name('comentarioVideos')->middleware('redirectIfSessionExpired');
Route::POST('/admin/update/comentario/lecturas', [ReportcompletosController::class, 'comenLecturas'])->name('comenLecturas')->middleware('redirectIfSessionExpired');
Route::POST('/admin/update/comentario/salidas', [ReportcompletosController::class, 'comenSalidas'])->name('comenSalidas')->middleware('redirectIfSessionExpired');
Route::POST('/admin/update/comentario/pictures', [ReportcompletosController::class, 'comenPicture'])->name('comenPicture')->middleware('redirectIfSessionExpired');
Route::POST('/admin/update/comentario/juegos', [ReportcompletosController::class, 'comJuegos'])->name('comJuegos')->middleware('redirectIfSessionExpired');
//======================== eliminar tareas ===================
Route::get('/eliminar/tarea/{id}', [ReportcompletosController::class, 'tareaDelete'])->name('tareaDelete')->middleware('redirectIfSessionExpired');
Route::POST('/admin/save/comentario/capitulo', [ReportcompletosController::class, 'saveCapitulo'])->name('saveCapitulo')->middleware('redirectIfSessionExpired');

//============================ retroalimentacion de los usuarios===============
Route::get('/informe/comentarios', [ReportcompletosController::class, 'vercomentarios'])->name('retroalimentacion')->middleware('redirectIfSessionExpired');

Route::get('/notificacion/{id}', [ReportcompletosController::class, 'modals'])->middleware('redirectIfSessionExpired');













