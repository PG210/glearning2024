<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Challenge;
use App\User;
use App\PosUsuModel\ComentarioCapModel;
use Illuminate\Support\Facades\Mail;//se agrego para correo
use App\Mail\Notificacion;//se agrego email
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//envio de correos
use App\Services\MicrosoftGraphService;
use App\Models\Token;
use App\Jobs\SendMailJob; // Importa el job

class ReportcompletosController extends Controller
{
     /*Envio de correos desde el admin */
     protected $graphService;

     public function __construct(MicrosoftGraphService $graphService)
      {
        $this->graphService = $graphService;
      }
 
      /*Enviar plantilla de correo */
      private function sendMail($destino, $nombre, $mensaje, $cap)
      {
          $descrip = "Notificación de Avance.";
          // Renderiza la vista Blade con el contenido HTML
          $content = view('mails.notifi', [
              'nombre' => $nombre, // valores para la vista de correo
              'mensaje' => $mensaje,
              'cap' => $cap
          ])->render();
  
          // Despacha el job a la cola
          SendMailJob::dispatch($descrip, $content, $destino);
          return true; 
      }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        /*Aqui se agrego los users */
        $res = DB::table('users')
                  ->join('grupos', 'users.id_grupo', '=', 'grupos.id')
                  ->select('users.id', 'firstname', 'lastname', 'username', 'email', 'level', 's_point', 'i_point', 'g_point', 'grupos.descrip', 'estado')
                  ->orderBy('s_point', 'desc')
                  ->get();
          //buscar las personas con las tareas pendientes y capitulos terminados
           
          $totTareas = DB::table('challenges')
                    ->join('subchapters', 'challenges.subchapter_id', '=', 'subchapters.id')
                    ->selectRaw('subchapters.chapter_id as cap, COUNT(challenges.id) as tareas')
                    ->groupBy('subchapters.chapter_id')
                    ->get();
      
             for ($x = 0; $x < count($res); $x++) {
                    $buscar[] = DB::table('challenge_user')
                          ->join('challenges', 'challenge_user.challenge_id', '=', 'challenges.id')
                          ->join('subchapters', 'challenges.subchapter_id', '=', 'subchapters.id')
                          ->where('challenge_user.user_id', $res[$x]->id)
                          ->selectRaw('COUNT(challenge_user.challenge_id) as valor, challenge_user.user_id as idusu, subchapters.chapter_id')
                          ->groupBy('challenge_user.user_id', 'subchapters.chapter_id')
                          ->get(); 
                  }
      
                //return $buscar[$i][$i]->chapter_id;
                $al = [];
                for ($i = 0; $i < count($buscar); $i++) {
                $conta = 0;
                for ($r = 0; $r < count($totTareas); $r++) {
                    if (isset($buscar[$i][$r]) && $buscar[$i][$r]->chapter_id == $totTareas[$r]->cap) {
                        $sum = $totTareas[$r]->tareas - $buscar[$i][$r]->valor;
                        $conta = $conta+1;
                        $item = [
                          'usuario' => $buscar[$i][$r]->idusu,
                          'capitulo' => $buscar[$i][$r]->chapter_id,
                          'tcom' => $buscar[$i][$r]->valor,
                          'tfaltan' => $sum,
                          'ttotal' => $totTareas[$r]->tareas,
                          'nivel' => $conta
                      ];
                      $al[] = $item;
                    }
                }
                } 
          //#############
          $niveles = collect($al)->groupBy('usuario')->map(function ($items) {
            return count($items);
          });//este me da los niveles 
        /*finaliza */
        $grupos = DB::table('grupos')->get();

       // return $res;
        return view('admin.reportcompletos')->with('usuarios', $res)->with('grup', $grupos)->with('bus', $al)->with('niveles', $niveles);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        //========== parte esta bien y muestra todos los retos para cada usuario =============
        //$retosuser = User::find($id);     
        //return view('admin.reportcompletes')->with('retos', $retosuser->challenges)->with('usuarioreto', $id);                        
        $usuario = User::findOrfail($id);
        
        $retosfinish = DB::table("challenge_user")
                       ->join('challenges', 'challenge_user.challenge_id', '=', 'challenges.id')
                       ->join('challenge_types', 'challenges.challenge_type_id', '=', 'challenge_types.id')
                       ->join('subchapters', 'challenges.subchapter_id', '=', 'subchapters.id')
                       ->join('chapters', 'subchapters.chapter_id', '=', 'chapters.id')
                       ->where('challenge_user.user_id', $id)
                       ->select('challenge_user.id as idretofin', 'challenge_user.challenge_id', 'challenge_user.s_point as ps', 'challenge_user.i_point as pi', 'challenge_user.g_point as pg', 'challenges.name','challenges.material', 'challenges.urlvideo', 'challenges.challenge_type_id as idtipo', 'challenge_types.name as tipo', 'chapters.name as capitulo', 'subchapters.chapter_id as cap')->get();
        //obtener los capitulos finalizados
        //obtener los capitulos con comentarios
        $comentar = ComentarioCapModel::where('user_id', $id)->get();
        
        $lecturas = DB::table("readings")
                    ->where('id_user', $id)
                    ->select('id_challenge', 'id_user', 'evidence as respuesta', 'readings.id as idlectura', 'readings.comentario')
                    ->distinct('id_challenge')
                    ->get();
        //obtener los videos
        $videos = DB::table("videos")
                    ->where('id_user', $id)
                    ->select('id_challenge', 'id_user', 'evidence as respuesta', 'videos.id as idvideo', 'videos.comentario')
                    ->distinct('id_challenge')
                    ->get();
        //obtener las salidas
        $salidas = DB::table("outdoors")
                    ->where('id_user', $id)
                    ->select('id_challenge', 'id_user', 'evidence as respuesta', 'image as img', 'video', 'outdoors.id as idout', 'outdoors.comentario')
                    ->distinct('id_challenge')
                    ->get();
        //sopa de letras
        $sopa = DB::table("challenge_user")
                    ->join('challenges', 'challenge_user.challenge_id', '=', 'challenges.id')
                    ->where('user_id', $id)->where('challenges.challenge_type_id', 3)
                    ->select('challenge_id', 'user_id', 'challenges.params as respuesta', 'challenges.description as des', 'challenge_user.comentario')
                    ->distinct('challenge_id')
                    ->get();
        // ahorcados 

        $ahorcado = DB::table("challenge_user")
                    ->join('challenges', 'challenge_user.challenge_id', '=', 'challenges.id')
                    ->where('challenge_user.user_id', $id)
                    ->where('challenges.challenge_type_id', 2)
                    ->select('challenge_id', 'user_id', 'challenges.params as respuesta', 'challenges.description as des', 'challenge_user.comentario')
                    ->distinct('challenge_id')
                    ->get();
        //pictures 
        $pictures = DB::table("pictures")
                    ->join('challenges', 'pictures.id_challenge', '=', 'challenges.id')
                    ->where('pictures.id_user', $id)
                    ->where('challenges.challenge_type_id', 6)
                    ->select('pictures.id_challenge', 'pictures.id_user', 'pictures.video', 'pictures.evidence as respuesta', 'pictures.image as img', 'challenges.description as des', 'pictures.comentario')
                    ->distinct('id_challenge')
                    ->get();
        
        //return $pictures;
        /*$quices = DB::table("challenge_user as cu")
                        ->join('challenges as c', 'cu.challenge_id', '=', 'c.id')
                        ->join('challenge_quiz as cq', 'c.id', '=', 'cq.challenge_id')
                        ->join('quizzes as q', 'cq.quiz_id', '=', 'q.id')
                        ->join('quiz_questions', 'q.id', '=', 'quiz_questions.quiz_id')
                        ->join('quiz_question_answers', 'quiz_questions.id', '=', 'quiz_question_answers.quizquestion_id')
                        ->where('cu.user_id', $id)
                        ->where('c.challenge_type_id', 1)
                        ->where('quiz_question_answers.correct', 1)
                        ->select('cu.challenge_id', 'cu.user_id', 'q.name as nomquiz', 'c.description as des', 'quiz_questions.question as pregunta', 'quiz_question_answers.answer as respuesta')
                        ->distinct('cu.challenge_id')
                        ->get();*/
        
       // return $quices;
       // return $ahorcado;

        // Inicializar un arreglo para almacenar las tareas por capítulo
        $tareasPorCapitulo = [];

        // Iterar sobre las tareas y agruparlas por capítulo
        foreach ($retosfinish as $tarea) {
            $capituloKey = $tarea->cap;
            // Verificar si la clave del capítulo ya existe en el arreglo
            if (!isset($tareasPorCapitulo[$capituloKey])) {
                $tareasPorCapitulo[$capituloKey] = [];
            }

            // Agregar la tarea al arreglo correspondiente al capítulo
            $tareasPorCapitulo[$capituloKey][] = $tarea;
        }
        //return $tareasPorCapitulo;
       return view('admin.reportcapitulos')->with('capitulos', $tareasPorCapitulo)
                                           ->with('usuarioreto', $id)->with('lecturas', $lecturas)
                                           ->with('videos', $videos)->with('salidas', $salidas)
                                           ->with('sopa', $sopa)->with('ahorcado', $ahorcado)
                                           ->with('pictures', $pictures)
                                           ->with('user', $id)->with('usu', $usuario)->with('comentar', $comentar);
                                           
    }


    public function more(Request $request)
    {
        // recibe el ID del reto
        $idusuario = $request->usuario;
        $idreto = $request->idreto;
        $retosuser = Challenge::find($idreto);  

        //#######################################
        $infocomplete = DB::table('challenges')
        ->join('videos', 'challenges.id', '=', 'videos.id_challenge')
        ->join('challenge_user', 'challenges.id', '=', 'challenge_user.challenge_id')
        ->leftjoin('readings', 'challenges.id', '=', 'readings.id_challenge')
        ->join('users', 'videos.id_user', '=', 'users.id')
        ->leftjoin('outdoors', 'challenges.id', '=', 'outdoors.id_challenge')
        ->leftjoin('pictures', 'challenges.id', '=', 'pictures.id_challenge')
        ->where('videos.id_user', '=', $idusuario)
        ->where('videos.id_challenge', '=', $idreto)
        ->select('users.id as id_usuario', 'users.firstname as Usuario', 'users.lastname as Apellido',
                  'challenges.id as id_reto', 'challenges.name as nombre_reto',  
                  'challenges.time as tiempo', 'challenges.material', 'challenges.urlvideo as video', 
                  'challenges.description as descripcion', 'challenges.params as palabras',
                  'challenge_user.s_point as S_ganados', 'challenge_user.i_point as I_ganados',
                  'challenge_user.g_point as G_ganados',
                  'outdoors.image as imagen_Salidas', 'outdoors.evidence as Evidencia_Salidas',
                  'outdoors.image as imagen_Salidas', 'pictures.evidence as Evidencia_Fotografia',
                  'pictures.image as imagen_Fotografia', 'readings.evidence as Evidencia_Lecturas',
                  'videos.evidence as Evidencia_videos')
        ->distinct()
        ->get();

        //#######################  return outdoors
        $infoout = DB::table('challenges')
            ->join('challenge_user', 'challenges.id', '=', 'challenge_user.challenge_id')
            ->leftjoin('outdoors', 'challenges.id', '=', 'outdoors.id_challenge')
            ->join('users', 'outdoors.id_user', '=', 'users.id')
            ->where('outdoors.id_user', '=', $idusuario)
            ->where('outdoors.id_challenge', '=', $idreto)
            ->where('challenge_user.challenge_id', '=', $idreto)
            ->where('challenge_user.user_id', '=', $idusuario)
            ->select('users.id as id_usuario', 'users.firstname as Usuario', 'users.lastname as Apellido',
                    'challenges.id as id_reto', 'challenges.name as nombre_reto',  
                    'challenges.time as tiempo', 'challenges.material', 'challenges.urlvideo as video', 
                    'challenges.description as descripcion', 'challenges.params as palabras',
                    'challenge_user.s_point as S_ganados', 'challenge_user.i_point as I_ganados',
                    'challenge_user.g_point as G_ganados', 'outdoors.image as imagen_Salidas',
                    'outdoors.evidence as Evidencia_Salidas',
                    'outdoors.image as imagen_Salidas', 'outdoors.video')
            ->distinct()
            ->get();
        
        //################3 return readings
        $infolectura = DB::table('challenges')
                    ->join('challenge_user', 'challenges.id', '=', 'challenge_user.challenge_id')
                    ->leftjoin('readings', 'challenges.id', '=', 'readings.id_challenge')
                    ->join('users', 'readings.id_user', '=', 'users.id')
                    ->where('readings.id_user', '=', $idusuario)
                    ->where('readings.id_challenge', '=', $idreto)
                    ->select('users.id as id_usuario', 'users.firstname as Usuario', 'users.lastname as Apellido',
                            'challenges.id as id_reto', 'challenges.name as nombre_reto',  
                            'challenges.time as tiempo', 'challenges.material', 'challenges.urlvideo as video', 
                            'challenges.description as descripcion', 'challenges.params as palabras',
                            'challenge_user.s_point as S_ganados', 'challenge_user.i_point as I_ganados',
                            'challenge_user.g_point as G_ganados',
                            'readings.evidence as Evidencia_Lecturas')
                ->distinct()
                ->get();
        //########################## pictures
        $infopicture = DB::table('challenges')
                    ->join('challenge_user', 'challenges.id', '=', 'challenge_user.challenge_id')
                    ->leftjoin('pictures', 'challenges.id', '=', 'pictures.id_challenge')
                    ->join('users', 'pictures.id_user', '=', 'users.id')
                    ->where('pictures.id_user', '=', $idusuario)
                    ->where('pictures.id_challenge', '=', $idreto)
                    ->select('users.id as id_usuario', 'users.firstname as Usuario', 'users.lastname as Apellido',
                            'challenges.id as id_reto', 'challenges.name as nombre_reto',  
                            'challenges.time as tiempo', 'challenges.material', 'challenges.urlvideo as video', 
                            'challenges.description as descripcion', 'challenges.params as palabras',
                            'challenge_user.s_point as S_ganados', 'challenge_user.i_point as I_ganados',
                            'challenge_user.g_point as G_ganados', 
                            'pictures.evidence as Evidencia_Fotografia',
                            'pictures.image as imagen_Fotografia', 'pictures.video as pvideo')
                ->distinct()
                ->get();

        //consultar quizz
        $quizs = DB::table('quiz_participant_answers')
                 ->join('users', 'quiz_participant_answers.user_id', '=', 'users.id')
                 ->join('quiz_question_answers', 'quiz_participant_answers.quizquestionanswer_id', '=', 'quiz_question_answers.id')
                 ->join('quiz_questions', 'quiz_question_answers.quizquestion_id', '=', 'quiz_questions.id')
                 ->join('quizzes', 'quiz_questions.quiz_id', '=', 'quizzes.id')
                 ->leftjoin('challenge_quiz', 'quizzes.id', '=', 'challenge_quiz.quiz_id')
                 ->join('challenges', 'challenge_quiz.challenge_id', '=', 'challenges.id')
                 ->where('quiz_participant_answers.user_id', '=', $idusuario)
                 ->where('challenges.id', '=', $idreto)
                 ->select('users.firstname as nombre', 'users.lastname as apellido', 'quiz_question_answers.answer as respuesta', 
                           'quiz_question_answers.correct as correcto', 'quiz_questions.question as pregunta',  
                           'challenges.name as reto', 'challenges.s_point as s', 'challenges.i_point as i', 'challenges.g_point as g')
                 ->distinct()
                 ->get();
               
       // $infocomplete = DB::select("call foundcompleteChallenges($idusuario, $idreto)");
        return view('admin.reportmoreinfo')
                        ->with('retos', $retosuser)
                        ->with('idusuario', $idusuario)
                        ->with('infocomplete', $infocomplete)
                        ->with('infoout', $infoout)
                        ->with('infolectura', $infolectura)
                        ->with('infopicture', $infopicture)
                        ->with('quizs', $quizs);
                
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //buscar usuario 
    public function usuretoster($id)
    {
        //
        $retosuser = User::find($id);        
        return view('admin.reportcompletes')
                        ->with('retos', $retosuser->challenges)
                        ->with('usuarioreto', $id);                        
    }
    //

    public function nuevoid(Request $request){
      
      $lista = $request->idarchivo;
       //limpiar archivo  
    if(!empty($lista)){
      $exist = file_exists("informe/archivo.txt");
      if ($exist){
       $borrado = unlink("informe/archivo.txt");
       $borrado = unlink("informe/nuevoarchivo.txt");
        //#########################
        //evidencia videos
        
        for($i = 0; $i < Count($lista); $i++){
        $id1 = $lista[$i]; 
        $res1 = DB::table('videos')
                ->join('challenges', 'videos.id_challenge', '=', 'challenges.id') 
                ->join('subchapters', 'challenges.subchapter_id', '=', 'subchapters.id')  
                ->join('users', 'videos.id_user', '=', 'users.id')
                ->join('grupos', 'users.id_grupo', '=', 'grupos.id')
                ->where('grupos.id', $id1)
                ->select('users.id as id_usuario', 'users.firstname as Usuario', 'users.lastname as Apellido', 'grupos.descrip as grup',
                         'challenges.name as nombre_reto', 'challenges.description as descripcion',
                        'challenges.material', 'challenges.urlvideo as video', 
                        'challenges.params as palabras', 'challenges.subchapter_id as idsub', 'subchapters.chapter_id as cap',
                        'videos.evidence as Evidencia_videos')
                ->distinct()
                ->get();
         $info[] = $res1;
        }
        //respuestas de lecturas
        for($i = 0; $i < Count($lista); $i++){
        $id2 = $lista[$i]; 
         $res2 = DB::table('readings')
                 ->join('challenges', 'readings.id_challenge', '=', 'challenges.id')
                 ->join('subchapters', 'challenges.subchapter_id', '=', 'subchapters.id')
                 ->join('users', 'readings.id_user', '=', 'users.id')
                 ->join('grupos', 'users.id_grupo', '=', 'grupos.id')
                 ->where('grupos.id', $id2)
                 ->select('users.id as id_usuario', 'users.firstname as Usuario', 'users.lastname as Apellido', 'grupos.descrip as grup',
                          'challenges.name as nombre_reto',  'challenges.description as descripcion', 'challenges.material', 'challenges.urlvideo as video', 
                         'challenges.params as palabras', 'challenges.subchapter_id as idsub', 'subchapters.chapter_id as cap',
                         'readings.evidence as Evidencia_Lecturas')
                ->distinct()
                ->get();
            $info2[] = $res2;
        }
        //respuestas de salidas
        for($i = 0; $i < Count($lista); $i++){
        $id3 = $lista[$i];
        $res3 = DB::table('outdoors')
                ->join('challenges', 'outdoors.id_challenge', '=', 'challenges.id')
                ->join('subchapters', 'challenges.subchapter_id', '=', 'subchapters.id')
                ->join('users', 'outdoors.id_user', '=', 'users.id')
                ->join('grupos', 'users.id_grupo', '=', 'grupos.id')
                ->where('grupos.id', $id3)
                ->select('users.id as id_usuario', 'users.firstname as Usuario', 'users.lastname as Apellido', 'grupos.descrip as grup',
                        'challenges.name as nombre_reto',  'challenges.description as descripcion', 'challenges.material', 'challenges.urlvideo as video', 
                        'challenges.params as palabras', 'challenges.subchapter_id as idsub', 'subchapters.chapter_id as cap',
                        'outdoors.evidence as evioutdoor', 'outdoors.video', 'outdoors.image as img')
            ->distinct()
            ->get();
            $info3[] = $res3;
        }
       
        //respuestas de pictures
        for($i = 0; $i < Count($lista); $i++){
        $id4 = $lista[$i];
        $res4 = DB::table('pictures')
                ->join('challenges', 'pictures.id_challenge', '=', 'challenges.id')
                ->join('subchapters', 'challenges.subchapter_id', '=', 'subchapters.id')
                ->join('users', 'pictures.id_user', '=', 'users.id')
                ->join('grupos', 'users.id_grupo', '=', 'grupos.id')
                ->where('grupos.id', $id4)
                ->select('users.id as id_usuario', 'users.firstname as Usuario', 'users.lastname as Apellido', 'grupos.descrip as grup',
                        'challenges.name as nombre_reto',  'challenges.description as descripcion', 'challenges.material', 'challenges.urlvideo as video', 
                        'challenges.params as palabras', 'challenges.subchapter_id as idsub', 'subchapters.chapter_id as cap',
                        'pictures.evidence as evipic', 'pictures.video', 'pictures.image as img')
            ->distinct()
            ->get();
            $info4[] = $res4;
        }
       // return $info4;
        //######################################
        $ar = fopen("informe/archivo.txt", "w");
        fwrite($ar, "Usuario*Grupo*nombre_reto*descripcion_reto*palabras*Evidencia_Lecturas*Evidencia_videos*Evidencia_Salidas*Descrip_imagen*Url Video*Link imagen*Capitulo\n");
        $array_num = count($info);
        //link img outdoor
        $linkout = "https://glearning.com.co/storage/gameoutdoor/";
        $linkfoto = "https://glearning.com.co/storage/gamefoto/";
        //videos
        //#################################
       foreach ($info as $infousu) {
            foreach ($infousu as $video) {
                $des = preg_replace("/[\r\n|\n|\r]+/", " ", $video->descripcion);
                $pal = preg_replace("/[\r\n|\n|\r]+/", " ", $video->palabras);
                $vid = preg_replace("/[\r\n|\n|\r]+/", " ", $video->Evidencia_videos);
                fwrite($ar, $video->Usuario.'-'.$video->Apellido.'*'.$video->grup.'*'.$video->nombre_reto.'*'.$des.'*'.$pal.'*'.'*'.$vid.'*'.'*'.'*'.'*'.'*'.$video->cap.PHP_EOL); 
            }
        }
        //lecturas
        //###################################
        foreach ($info2 as $infousu1) {
            foreach ($infousu1 as $lectura) {
                $des = preg_replace("/[\r\n|\n|\r]+/", " ", $lectura->descripcion);
                $pal = preg_replace("/[\r\n|\n|\r]+/", " ", $lectura->palabras);
                $lec = preg_replace("/[\r\n|\n|\r]+/", " ", $lectura->Evidencia_Lecturas);
                //lecturas
                fwrite($ar, $lectura->Usuario.'-'.$lectura->Apellido.'*'.$lectura->grup.'*'.$lectura->nombre_reto.'*'.$des.'*'.$pal.'*'.$lec.'*'.'*'.'*'.'*'.'*'.'*'.$lectura->cap.PHP_EOL);
         }
        }
        
        //evidencia de salidas
        //##############################
         //evidencia de salidas
        foreach ($info3 as $infousu3) {
            foreach ($infousu3 as $salida) {
                $des = preg_replace("/[\r\n|\n|\r]+/", " ", $salida->descripcion);
                $pal = preg_replace("/[\r\n|\n|\r]+/", " ", $salida->palabras);
                $sal = preg_replace("/[\r\n|\n|\r]+/", " ", $salida->evioutdoor);
                $link = $linkout.$salida->img;
                //lecturas
                fwrite($ar, $salida->Usuario.'-'.$salida->Apellido.'*'.$salida->grup.'*'.$salida->nombre_reto.'*'.$des.'*'.$pal.'*'.'*'.'*'.$sal.'*'.'*'.$salida->video.'*'.$link.'*'.$salida->cap.PHP_EOL);
            }
        }
        /*
        //evidencia imagenes
        for($i=0; $i<count($info4); $i++){
            $des = preg_replace("/[\r\n|\n|\r]+/", " ", $info4[$i]->descripcion);
            $pal = preg_replace("/[\r\n|\n|\r]+/", " ", $info4[$i]->palabras);
            $ev = preg_replace("/[\r\n|\n|\r]+/", " ", $info4[$i]->evipic);
            $linkf = $linkfoto.$info4[$i]->img;
            //lecturas
            fwrite($ar, $info4[$i]->Usuario.'-'.$info4[$i]->Apellido.'*'.$info[$i]->grup.'*'.$info4[$i]->nombre_reto.'*'.$des.'*'.$pal.'*'.'*'.'*'.'*'.$ev.'*'.$info4[$i]->video.'*'.$linkf.'*'.$info4[$i]->cap.PHP_EOL);
            }*/

        //#################################
        //evidencia imagenes
       
        foreach ($info4 as $infousu4) {
            foreach ($infousu4 as $imagen) {
                $des = preg_replace("/[\r\n|\n|\r]+/", " ", $imagen->descripcion);
                $pal = preg_replace("/[\r\n|\n|\r]+/", " ", $imagen->palabras);
                $ev = preg_replace("/[\r\n|\n|\r]+/", " ", $imagen->evipic);
                $linkf = $linkfoto.$imagen->img;
                //lecturas
                fwrite($ar, $imagen->Usuario.'-'.$imagen->Apellido.'*'.$imagen->grup.'*'.$imagen->nombre_reto.'*'.$des.'*'.$pal.'*'.'*'.'*'.'*'.$ev.'*'.$imagen->video.'*'.$linkf.'*'.$imagen->cap.PHP_EOL);
            }
        }
        
        fclose($ar);
        //================ Acomodar os datos del archiv para que salgan ordenados ================
        // Leer datos del archivo de texto
            $fileContents = file_get_contents('informe/archivo.txt');
            $dataArray = explode(PHP_EOL, $fileContents);

            // Omitir la primera línea
            $firstLine = array_shift($dataArray);
            $dataArray = array_filter($dataArray);
            // Definir una función de comparación para ordenar por Grupo
            // Ordenar el arreglo de datos por el campo "Grupo"
                usort($dataArray, function ($a, $b) {
                    $columnsA = explode('*', $a);
                    $columnsB = explode('*', $b);
                    
                    $grupoA = isset($columnsA[1]) ? $columnsA[1] : ''; // Índice 1 es el campo Grupo
                    $grupoB = isset($columnsB[1]) ? $columnsB[1] : '';
                    
                    return strcmp($grupoA, $grupoB);
                });
                // Escribir los datos ordenados en el archivo
                $header = "Usuario*Grupo*nombre_reto*descripcion_reto*palabras*Evidencia_Lecturas*Evidencia_videos*Evidencia_Salidas*Descrip_imagen*Url Video*Link imagen*Capitulo";
               // Agregar el encabezado al principio de los datos ordenados
                $sortedContents = $header . PHP_EOL . implode(PHP_EOL, $dataArray);
                //Datos Completos
                file_put_contents("informe/nuevoarchivo.txt", $sortedContents);
        //=============================
       }  
      //
      return response()->download('informe/nuevoarchivo.txt');
    }else{
        return back();
    }

    }
    //buscar usuarios por grupos
    //=============================== comentario videos =========
    public function comenVideos(Request $request){
        
        DB::table('videos')
            ->where('id', $request->idvideo)
            ->where('id_user', $request->idusu)
            ->update([
                'comentario' => $request->comentariovideo,
            ]);
        return back();
    }
    //guardar comentarios de lecturas
    public function comenLecturas(Request $request){
        DB::table('readings')
            ->where('id', $request->idlectura)
            ->where('id_user', $request->idusu)
            ->update([
                'comentario' => $request->comlectura,
            ]);
        return back();
    }
    //guardar salidas
    public function comenSalidas(Request $request){

        DB::table('outdoors')
            ->where('id', $request->idsal)
            ->where('id_user', $request->idusu)
            ->update([
                'comentario' => $request->comensal,
            ]);
        return back();
    }
    // funcion para guardar comentario pictures
    public function comenPicture(Request $request) {
        DB::table('pictures')
            ->where('id_challenge', $request->idpicture)
            ->where('id_user', $request->idusu)
            ->update([
                'comentario' => $request->comenpicture,
            ]);
        return back();
    }
    //=====================================
    // actualizar ahorcados y sopa de letras
    public function comJuegos(Request $request){
        DB::table('challenge_user')
            ->where('challenge_id', $request->challenge_id)
            ->where('user_id', $request->idusu)
            ->update([
                'comentario' => $request->comentario,
            ]);
        return back();
    }
    //===================== eliminar tareas registradas ==============
    public function tareaDelete($id){//recibe id del challenge_user
        $buscar = DB::table('challenge_user')
                    ->join('challenges', 'challenge_user.challenge_id', '=', 'challenges.id')
                    ->where('challenge_user.id', $id) // Agrega el nombre de la tabla para evitar ambigüedad
                    ->select('challenges.challenge_type_id as tipo', 'challenge_user.user_id', 'challenge_user.challenge_id as idret')
                    ->get();
        
        $tipo = $buscar[0]->tipo; //tipo de reto
        switch ($tipo) {
            case '1':
                // Código para quices
                break;
        
            case '2':
                // Código ahorcado
                break;
        
            case '3':
                // Código para sopa de letras
                break;

            case '4':
                // Código rompecabezas
                break;

            case '5':
                // Código para ver videos
                DB::table('videos')->where('videos.id_challenge', $buscar[0]->idret)->where('videos.id_user', $buscar[0]->user_id)->delete(); //borra de la tabla videos
                break;

            case '6':
                // Código subir foto
                DB::table('pictures')->where('pictures.id_challenge', $buscar[0]->idret)->where('pictures.id_user', $buscar[0]->user_id)->delete(); //borra de la tabla pictures
                break;

            case '7':
                // Código lecturas
                DB::table('readings')->where('readings.id_challenge', $buscar[0]->idret)->where('readings.id_user', $buscar[0]->user_id)->delete(); //borra de la tabla readings
                break;

            case '8':
                // Código salir hacer
                DB::table('outdoors')->where('outdoors.id_challenge', $buscar[0]->idret)->where('outdoors.id_user', $buscar[0]->user_id)->delete(); //borra de la tabla outdoors
                break;

            default:
                break;
        }
        DB::table('challenge_user')->where('id', $id)->delete(); //borra de challenges
        return back();
    }
    //==================== guardar comentario por capitulo =========================
    public function saveCapitulo(Request $request){
      $comentario = ComentarioCapModel::updateOrCreate(
            [
                'user_id' => $request->usu,
                'capitulo_id' => $request->idcap
            ],
            [
                'comentario' => $request->comenCapitulo,
                // Agrega más columnas y valores según sea necesario
            ]
        );
       //================ enviar el correo 
        $userId = $comentario->user_id;
        //============= buscar el usuario 
        $usuario = User::where('id', $userId)->first(); // Cambiado de get() a first()
        $nombres = $usuario->firstname . " " . $usuario->lastname;
        $capituloId = $comentario->capitulo_id;
        $comentarioText = $comentario->comentario;
        //enviar correo al usuario
        $respuesta = $this->sendMail($usuario->email, $nombres, $comentarioText, $capituloId); //llamar a la funcion para enviar mensajes
        // Mail::to($usuario->email)->send(new Notificacion($nombres, $capituloId, $comentarioText));
       return back();
    }
    //============================= aqui se debe mostrar los comentarios por cada usuario ===========
    public function vercomentarios(){
     $user = Auth::user();
     $retosfinish = DB::table("challenge_user")
                       ->join('challenges', 'challenge_user.challenge_id', '=', 'challenges.id')
                       ->join('challenge_types', 'challenges.challenge_type_id', '=', 'challenge_types.id')
                       ->join('subchapters', 'challenges.subchapter_id', '=', 'subchapters.id')
                       ->join('chapters', 'subchapters.chapter_id', '=', 'chapters.id')
                       ->where('challenge_user.user_id', $user->id)
                       ->select('challenge_user.challenge_id', 'challenges.name', 'challenges.params as respuesta', 'challenges.description as des', 'challenge_types.name as tipo', 'challenge_types.id as idtipo', 'chapters.name as capitulo', 'subchapters.chapter_id as cap', 'challenge_user.comentario', 'challenges.material', 'challenges.urlvideo')
                       ->distinct('challenge_id')
                       ->get();
    //obtiene los comentarios a cada capitulo
    $comentariocap = ComentarioCapModel::where('user_id',  $user->id)->get();

    $lecturas = DB::table("readings")
                ->join('challenges', 'readings.id_challenge', '=', 'challenges.id')
                ->where('readings.id_user',  $user->id)
                ->where('readings.comentario', '!=', 'Null')
                ->select('readings.id_challenge', 'readings.id_user', 'readings.evidence as respuesta', 'readings.id as idlectura', 'readings.comentario', 'challenges.description as des')
                ->distinct('id_challenge')
                ->get();
   
    //obtener los videos
    $videos = DB::table("videos")
                ->join('challenges', 'videos.id_challenge', '=', 'challenges.id')
                ->where('videos.id_user',  $user->id)
                ->where('videos.comentario', '!=', 'Null')
                ->select('videos.id_challenge', 'videos.id_user', 'videos.evidence as respuesta', 'videos.id as idvideo', 'videos.comentario', 'challenges.description as des')
                ->distinct('id_challenge')
                ->get();
    // obtener los outdoors
    $salidas = DB::table("outdoors")
                ->join('challenges', 'outdoors.id_challenge', '=', 'challenges.id')
                ->where('outdoors.id_user', $user->id)
                ->where('outdoors.comentario', '!=', 'Null')
                ->select('outdoors.id_challenge', 'outdoors.id_user', 'outdoors.evidence as respuesta', 'outdoors.image as img', 'outdoors.video', 'outdoors.id as idout', 'outdoors.comentario', 'challenges.description as des')
                ->distinct('id_challenge')
                ->get();
    //obtener subir foto
    $pictures = DB::table("pictures")
                    ->join('challenges', 'pictures.id_challenge', '=', 'challenges.id')
                    ->where('pictures.id_user', $user->id)
                    ->where('challenges.challenge_type_id', 6)
                    ->where('pictures.comentario', '!=', 'Null')
                    ->select('pictures.id_challenge', 'pictures.id_user', 'pictures.video', 'pictures.evidence as respuesta', 'pictures.image as img', 'challenges.description as des', 'pictures.comentario')
                    ->distinct('id_challenge')
                    ->get();
    //filtrar los retos por capitulos 
    $tareasPorCapitulo = [];

        // Iterar sobre las tareas y agruparlas por capítulo
        foreach ($retosfinish as $tarea) {
            $capituloKey = $tarea->cap;
            // Verificar si la clave del capítulo ya existe en el arreglo
            if (!isset($tareasPorCapitulo[$capituloKey])) {
                $tareasPorCapitulo[$capituloKey] = [];
            }

            // Agregar la tarea al arreglo correspondiente al capítulo
            $tareasPorCapitulo[$capituloKey][] = $tarea;
        }
       
    
      return view('retroalimentacion.comentarios')
                  ->with('retos', $tareasPorCapitulo)
                  ->with('lecturas', $lecturas)
                  ->with('videos', $videos)->with('pictures', $pictures)->with('comcat', $comentariocap)
                  ->with('salidas', $salidas);

    }
   //========================================================
     public function modals($id){
        $user = Auth::user();
        if($id != 100){
            $com = ComentarioCapModel::where('id', $id)->get();
            //actualizar
            ComentarioCapModel::where('id', $id)->update(['estadonot' => 1]);
        }else{
            $com = ComentarioCapModel::where('user_id', $user->id)->get();
        }
     return view('retroalimentacion.modals')->with('com', $com);
    }
  //================================================================
}
