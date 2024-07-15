<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\alertaas;

use Illuminate\Http\Request;
use App\Subchapter;
use App\Chapter;
use App\Challenge;
use App\User;
use App\Quiz;
use App\Quiz_Question;
use App\Quiz_Question_Answer;
use App\Quiz_Participant;
Use App\Insignia;
use App\Gift;
use Carbon\Carbon;
Use App\ModingCap; //se agrego para reg insignias por capitulo
use DB;
use Auth;


class PlayerChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }
     //========================== funciones que se llaman de  la funcion store =====
    //funcion que encuentra el capitulo y lo retorna al ser encontrado
    public function eval($id){
        $var = DB::table('challenges')
                ->join('subchapters', 'challenges.subchapter_id', '=', 'subchapters.id')
                ->where('challenges.id', $id)
                ->select('chapter_id')
                ->get();
        $cap = $var[0]->chapter_id;
        return $cap;
    }
     //validar si el quiz tiene insignias para compartir
    public function valinsig($cap, $userauthid){
        $tarealizadas = DB::table('challenge_user')
                  ->join('challenges', 'challenge_user.challenge_id', '=', 'challenges.id')
                  ->join('subchapters', 'challenges.subchapter_id', '=', 'subchapters.id')
                  ->where('subchapters.chapter_id', $cap)
                  ->where('challenge_user.user_id', '=',  $userauthid)
                  ->selectRaw('challenge_user.user_id as idusu, subchapters.chapter_id, COUNT(challenge_user.challenge_id) as tot')
                  ->groupBy('challenge_user.user_id', 'subchapters.chapter_id')
                  ->get();
         $tarporcap = DB::table('challenges')
                  ->join('subchapters', 'challenges.subchapter_id', '=', 'subchapters.id')
                  ->where('subchapters.chapter_id', $cap)
                  ->selectRaw('subchapters.chapter_id as cap, COUNT(challenges.id) as tot')
                  ->groupBy('subchapters.chapter_id')
                  ->get();
          if(count($tarealizadas) != 0){
              $niv = ($tarealizadas[0]->tot*100)/$tarporcap[0]->tot;
              $bn = round($niv, 0);
           }
          if($bn >= 100){
              $idinsig = DB::table('insigniacap')->where('capitulo', $cap)->get();
              $fechai = Carbon::now();
              $Gr = new ModingCap();
              $Gr->userid =  $userauthid;
              $Gr->insigid = $idinsig[0]->id;
              $Gr->created_at = $fechai;
              $Gr->save();
            return $idinsig;
          }
      }
     //#################################### validar el mesnaje
    public function mensaje($cap, $userauthid){
            $tarfin = DB::table('challenge_user')
                        ->join('challenges', 'challenge_user.challenge_id', '=', 'challenges.id')
                        ->join('subchapters', 'challenges.subchapter_id', '=', 'subchapters.id')
                        ->where('subchapters.chapter_id', $cap)
                        ->where('challenge_user.user_id', '=',  $userauthid)
                        ->selectRaw('challenge_user.user_id as idusu, subchapters.chapter_id, COUNT(challenge_user.challenge_id) as tot')
                        ->groupBy('challenge_user.user_id', 'subchapters.chapter_id')
                        ->get();
     $tarcap = DB::table('challenges')
                        ->join('subchapters', 'challenges.subchapter_id', '=', 'subchapters.id')
                        ->where('subchapters.chapter_id', $cap)
                        ->selectRaw('subchapters.chapter_id as cap, COUNT(challenges.id) as tot')
                        ->groupBy('subchapters.chapter_id')
                        ->get();
     if(count($tarfin) != 0){
                $nvel = ($tarfin[0]->tot*100)/$tarcap[0]->tot;
                $puntos = round($nvel, 0);
            }
            if($puntos >= 100){
                $varmensaje = 1;
            }else{
                $varmensaje = 0;
            }

            return $varmensaje;
    }
     //================= end funciones===============================
    public function challenge($id)
    {
        //###############################
         $var2 = DB::table('challenges')
                ->join('subchapters', 'challenges.subchapter_id', '=', 'subchapters.id')
                ->where('challenges.id', $id)
                ->select('chapter_id')
                ->get();
        $cap = $var2[0]->chapter_id;
        //#########################
        $retos = Challenge::where('id', $id)->first();
        $quiz = Challenge::with('quizzes')->find($retos->id);

        return view('player.retos')->with('retos', $retos)
                                ->with('cap', $cap)
                                ->with('quiz', $quiz);
    }

    //llega el id del quiz a desarrollar para el reto elegido
    public function startplay(Request $request, $id)
    {
        //$request->idreto = es el id del RETO
        //$id = es el id del QUIZ
        //$request->versu = es el flag de que es un versus (1)
    
        //reto al que pertenece el quiz
        $challengequiz = Quiz::find($id);
        foreach ($challengequiz->challenges as $challenge) {
        }
        $tiempoasignado = $challenge->time;
        
        //hora actual
        $tiempoinicio = Carbon::now();
       
        //preguntas que pertenecen al quiz elegido        
        $questions = Quiz_Question::where('quiz_id', $id)->get();
        return view('player.startchallenge')->with('questions',$questions)
                                            ->with('tiempoasignado', $tiempoasignado)
                                            ->with('tiempoinicio', $tiempoinicio)
                                            ->with('idreto', $request->idreto);
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
        $userauthid = Auth::user()->id;
        $datetime = Carbon::now();       


        //obtener los datos del jugador
        $userplayer = User::find($userauthid);

        //obtener las respuestas elegidas por el jugador
        $playerParticipant = $request->usuario;
        $quiz_selected = $request->quizactual;
        $retoactual = $request->idretoactual;
        //======================================= validar que no duplique resultados ======================
        $cap = $this->eval($retoactual); //se valida el capitulo
        //obtener el reto correspondiente:
         $reto = Challenge::find($retoactual);
         
         //validar para que no duplique campos
         $validar = DB::table('challenge_user')->where('challenge_id', $retoactual)->where('user_id', $userauthid)->count();
         if($validar != 0){
             $retosig = $reto->subchapter_id;
              return redirect('playerchallenge/' .$retosig);
        }else{
        // ========== calcular respuestas correctas, pasa o no pasa el puntaje para ganar (80% minimo para ganar)
        //matrices temporales
        $arrayanswers = [];
        $arraycorrectas = [];
        
        //verificar las respuestas con la bd
        $answersid = $request->idquizzes; //array multiple seleccion de respuestas 
        $answersgroup = array_unique($answersid);    
        
        $new_array = array_values($answersgroup); 


        foreach ($new_array as $answersgroid) {
            $answers = $request->$answersgroid;
            // foreach ($answers as $answer) {            
                $quizanswers = DB::table('quiz_question_answers')
                ->where('id', $answers)
                ->get();
            
                $arrayanswers[] = $quizanswers[0];      
            // }
        }
    
        //obtener y almacenar solo las respuestas correctas
        foreach ($arrayanswers as $respuesta) {
            if ($respuesta->correct == 1) {
                $arraycorrectas[] = $respuesta;
            }
        }

        //cantidad respuestas contestadas
        $cantanswers = count($arrayanswers);

        //cantidad respuestas correctas
        $cantcorrectanswers = count($arraycorrectas); 

        $porcentwin = ($cantanswers*0.8);

        // === (aqui se podrian plantear intentos x juegos perdidos, podria necesitar cambios en BD) ==== //
        // ======== validar se obtubo el 80% o mas para pasar la prueba y guardar los puntajes =======//
        if ($cantcorrectanswers >= $porcentwin) {      
            //obtener los retos quiz ligados al juego actual:
            $challenge_quiz_id = DB::table('challenge_quiz')
                                ->where('quiz_id', $quiz_selected)
                                ->get();            
            foreach ($challenge_quiz_id as $challenquiz) {                
            }            

            //obtener el reto correspondiente:
            $Challengesplayed = Challenge::find($challenquiz->challenge_id); 

            $subchapter_id = $Challengesplayed->subchapter_id;

            for ($i=0; $i < count($arraycorrectas); $i++) { 
                $id_answer = $arraycorrectas[$i];   
                
                //crear y guardar datos del array recorrido en QUIZ_PARTICIPANS_ANSWERS
                $answerarray = [
                    'quizquestionanswer_id' => $id_answer->id,
                    'user_id' => $playerParticipant,
                    'timeQuestionStart' => '2019-01-23 00:00:00',
                    'timeQuestionEnd' => '2019-01-23 00:00:00',  
                ];
                Quiz_Participant::create($answerarray);
            }


            // ======================= PUNTAJES EN RETOS JUGADOS vs SUBCAPITULOS ========================

            //cantidad puntos S en el subcapitulo
            $subchapterspoint = DB::table('subchapters')
                                ->where('id', $subchapter_id)
                                ->pluck('s_point'); 

            $subchapterpoint = $subchapterspoint[0];
            
            //cantidad de Retos en el subcapitulo actual
            $challengesin = DB::table('challenges')
                            ->where('subchapter_id', $subchapter_id)
                            ->count();

            $challenges = DB::table('challenges')
                            ->where('id', $retoactual)
                            ->get();
                                                                    
            //cantidad puntos para retos
            $retospts = $subchapterpoint / $challengesin;
            // $retospts = ceil($retospts);

            $i_point = 0;
            $g_point = 0;
            foreach ($challenges as $challenge) {
                $i_point = $challenge->i_point;
                $g_point = $challenge->g_point;
            }    

            //guardar campos en la tabla pivote CHALLENGE_USER, forzando campos que no estan en el guardado inmediato anterior
            $retos = new Challenge;
            $retos->users()->attach($playerParticipant, [
                'start' => $datetime,
                'end' => $datetime,
                'result_api' => '0',
                's_point' => $retospts,
                'i_point' => $i_point,
                'g_point' => $g_point,
                'challenge_id' => $retoactual
                ]);        
            
            //========================== TOTAL PUNTOS S, I, G DEL USUARIO - JUGADOR =======================
            $sum_spoints = 0;
            $sum_ipoints = 0;
            $sum_gpoints = 0;
            
            //puntos S de retos jugados
            $userspoints = DB::table('challenge_user')
                            ->where('user_id', $userauthid)
                            ->pluck('s_point');

            for ($i=0; $i < count($userspoints); $i++) { 
                //suma de puntos S de retos jugados por el usuario
                $sum_spoints = $sum_spoints + $userspoints[$i];          
            }

            //puntos I de retos jugados
            $userspointi = DB::table('challenge_user')
                            ->where('user_id', $userauthid)
                            ->pluck('i_point');

            for ($i=0; $i < count($userspointi); $i++) { 
                //suma de puntos I, retos jugados por el usuario
                $sum_ipoints = $sum_ipoints + $userspointi[$i];          
                //ACTUALIZAR puntaje del jugador
            }

            //puntos G de retos jugados 
            $userspointi = DB::table('challenge_user')
                            ->where('user_id', $userauthid)
                            ->pluck('g_point');

            for ($i=0; $i < count($userspointi); $i++) { 
                //suma de puntos S, retos jugados por el usuario
                $sum_gpoints = $sum_gpoints + $userspointi[$i];          
            }

        //====== DESCOMPONER puntajes ganados y puntajes actuales =====//
        
           //puntos ganados
           $winpoints = ceil($sum_spoints);
           $winpoints = number_format($winpoints,0);            
           $unidades = $winpoints % 10;            
           $aux = $winpoints - $unidades;
           $aux = $aux % 100;
           $decenas = $aux / 10;
           $auxcent = $winpoints - $decenas*10 - $unidades;
           $centenas = $auxcent / 100;
       
           //puntos actuales antes de actualizar
           $actualpoints = ceil($userplayer->s_point);
           $actualpoints = number_format($actualpoints,0);
           $unidadesdos = $actualpoints % 10;            
           $auxdos = $actualpoints - $unidadesdos;
           $auxdos = $auxdos % 100;
           $decenasdos = $auxdos / 10;
           $auxcentdos = $actualpoints - $decenasdos*10 - $unidadesdos;
           $centenasdos = $auxcentdos / 100;
            
            //activar POPUP subida de nivel
            if ($centenas > $centenasdos) {                
                //subiste de nivel
                $leveluppopup = 1; 
            }else {
                //no ha subido de nivel
                $leveluppopup = 0; 
            }

            //========== Actualizar puntos S, I, G del Usuario en tabla USERS:
            User::where('id', $userauthid)
                        ->update(['s_point' => $winpoints, 'i_point' => $sum_ipoints, 'g_point' => $sum_gpoints]);
            
            //========== Actualizar puntos S de CHALLENGES:
            challenge::where('id', $Challengesplayed->id)
                        ->update(['s_point' => $retospts]);            

            //========  Actualizar insignias del jugador  =======//
            $insignias = Insignia::all();
            $insigniauser = User::find($userauthid);

            //asignar valor en caso de no haber ninguna insignia
            $insigniapopup = 0;
            $insigniawon = '';
            $insignianamewon = '';
            $insigniadescwon = '';
                        
            //obtener y recorrer todas las insignias:
            //==================================== evaluar si existe insignias ===========
            if($reto->id_insignia != 100){
                //tiene recompensa
                $insearch = DB::table('insignias')
                         ->where('insignias.id', $reto->id_insignia)
                         ->select('insignias.id as idinsig', 'insignias.name', 'insignias.imagen', 'insignias.s_point', 'insignias.i_point', 'insignias.g_point',                            'insignias.description')
                         ->first();
                //validar que esta insignia no este rpetida
                $valinsig = DB::table('insignia_user')->where('user_id', $userauthid)->where('insignia_id', $insearch->idinsig)->get();
                if ($valinsig->isEmpty()) {                        
                    DB::table('insignia_user')->insert([
                        'user_id' => $userplayer->id,
                        'insignia_id' => $insearch->idinsig, 
                    ]);
                //una insignia nueva
                    $insigniapopup = 1;
                    $insigniawon = $insearch->imagen;
                    $insignianamewon = $insearch->name;
                    $insigniadescwon = $insearch->description;
               }else{
                   $insigniapopup = 0;
                }
               
            }

            //========================================================================//
            //====================== Actualizar RECOMPENSAS GIFTS del jugador  ===============//
            $recompensas = Gift::all();
            $recompensauser = User::find($userauthid);
            
            //asignar valor en caso de no haber ninguna insignia
            $recompensapopup = 0;
            $recompensawon = '';
            $recompensanamewon = '';

            //obtener y recorrer todas las recompensas:
            //================================Validar recompensas====================
              if($reto->id_grupo != 1){
                //tiene recompensa
               $search = DB::table('gifts')
                         ->where('id_grupo', $reto->id_grupo)
                         ->where('avatar_id', $userplayer->avatar_id)
                         ->select('gifts.id as idin', 'gifts.imagen', 'avatarchange as avatar', 'gifts.name')
                         ->first();
               //validar que esta insignia no este rpetida
                $validarin = DB::table('gift_user')->where('user_id', $userauthid)->where('gift_id', $search->idin)->get();
                if ($validarin->isEmpty()) {                        
                    DB::table('gift_user')->insert([
                        'gift_id' => $search->idin,
                        'user_id' => $userplayer->id,
                        // Agrega más columnas y valores según corresponda
                    ]);
                    //====================aqui se debe actualizar el usuario =========================
                    $usuact =User::findOrfail($userplayer->id);
                    $usuact->imgavat = $search->avatar; //guarda la direccion del avatar
                    $usuact->save();
                    //==============================================================================
                    //una insignia nueva
                    $recompensapopup = 1;
                    $recompensawon = $search->imagen;
                    $recompensanamewon = $search->name;
                }else{
                    $recompensapopup = 0;
                }
               
            }
            //====================== Actualizar RECOMPENSAS del jugador  ===============//
            //========================================================================//


            //======= Enviar confirmacion via EMAIL al jefe de area del reto terminado por el usuario        
            //obtener area del usuario   
           /* $userareas = User::find($userauthid);        
            foreach ($userareas->areas as $userarea) {            
            }
        
            //obtener el jefe del area        
            $jefeareas = DB::table('type_user')->where('id_areas', $userarea->id)->get();  
                        
            //obtener datos del jefe para crear mensaje            
            if (!$jefeareas->isEmpty()) {                
                //obtener puntajes de jefes para cambio de mensaje , segun el area              
                foreach ($jefeareas as $jefe) {
                    $puntajejefes = User::find($jefe->user_id);
                    foreach ($puntajejefes->types as $valtype ) {                        
                        $punajejefeg = $valtype->g_point;
                        $punajejefei = $valtype->i_point;
                        $messagejefe = $valtype->message;
                        $statuson = 1;
                        $statusoff = 0;

                        $tablemessages = DB::table('messages')->where('id_user', $userauthid)->get();                      

                        if ($tablemessages->count() > 0) {
                            foreach ($tablemessages as $messagestatus) {                                
                                if ($sum_ipoints >= $punajejefei && $sum_gpoints >= $punajejefeg && $jefe->user_id != $messagestatus->id_jefe ) {
                                    
                                    //obtener datos del jefe para crear mensaje            
                                    if (!$jefeareas->isEmpty()) {
                                        foreach ($jefeareas as $jefearea) { 
        
                                            //guardar estados en la tabla messages para no repetir mails por usuario
                                            DB::table('messages')->insert([
                                                'id_jefe'     =>    $jefearea->user_id,
                                                'id_user'     =>    $userauthid,
                                                'status'      =>    $statuson,
                                            ]);
        
                                            $datajefe = User::find($jefearea->user_id);
                                            $nombrelider = $datajefe->firstname . " " . $datajefe->lastname;
                                            $nombrejugador = Auth::user()->firstname . " " . Auth::user()->lastname;
                                            $contactlist = $datajefe->email; 
                                
                                            //objeto para enviar datos a la plantilla de correo
                                            $mailobjeto = new \stdClass();            
                                            $mailobjeto->nombrejugador = $nombrejugador;
                                            $mailobjeto->nombrelider = $nombrelider;
                                            $mailobjeto->messagejefe = $messagejefe;
                                            Mail::to($contactlist)->send( new alertaas($mailobjeto) );
                                        }
                                    }                    
                                }
                            }                            
                        } else {                       
                            if ($sum_ipoints >= $punajejefei && $sum_gpoints >= $punajejefeg ) {
                                
                                //obtener datos del jefe para crear mensaje            
                                if (!$jefeareas->isEmpty()) {
                                    foreach ($jefeareas as $jefearea) { 
    
                                        //guardar estados en la tabla messages para no repetir mails por usuario
                                        DB::table('messages')->insert([
                                            'id_jefe'     =>    $jefearea->user_id,
                                            'id_user'     =>    $userauthid,
                                            'status'      =>    $statuson,
                                        ]);
    
                                        $datajefe = User::find($jefearea->user_id);
                                        $nombrelider = $datajefe->firstname . " " . $datajefe->lastname;
                                        $nombrejugador = Auth::user()->firstname . " " . Auth::user()->lastname;
                                        $contactlist = $datajefe->email; 
                            
                                        //objeto para enviar datos a la plantilla de correo
                                        $mailobjeto = new \stdClass();            
                                        $mailobjeto->nombrejugador = $nombrejugador;
                                        $mailobjeto->nombrelider = $nombrelider;
                                        $mailobjeto->messagejefe = $messagejefe;
                                        Mail::to($contactlist)->send( new alertaas($mailobjeto) );
                                    }
                                }                    
                            }
                        }
                     
                    }            
                }
                
            }*/           
            
            //====================POPUP al terminar ultimo reto del tema:
            //verificar si esta en el ultimo RETO del TEMA al que le pertenece
            $subcapitulo_reto = DB::table('subchapters')
            ->join('challenges', 'subchapters.id', '=', 'challenges.subchapter_id')  
            ->select('subchapter_id', DB::raw('COUNT(subchapter_id) as cantidad_retos_tema') )     
            ->where('subchapters.id', $subchapter_id) 
            ->groupBy('subchapter_id')
            ->first();
            $guar = $subcapitulo_reto->cantidad_retos_tema;
            $subcapitulo_reto = DB::table('subchapters')
            ->join('challenges', 'subchapters.id', '=', 'challenges.subchapter_id')
            ->join('challenge_user', 'challenges.id', '=', 'challenge_user.challenge_id')  
            ->select( DB::raw('COUNT(challenge_user.user_id) as cantidad_retos_terminados'))     
            ->where('subchapters.id', $subchapter_id)
            ->where('challenge_user.user_id', $userauthid) 
            ->first();

            $n = $subcapitulo_reto->cantidad_retos_terminados;

            if ($insigniapopup == 0 && $recompensapopup == 0 && $leveluppopup == 0 || $guar == $n) {
                $passretouppopup =  1;
            } else {
                $passretouppopup =  0;
            }


            $pt_s = $retospts;
            //#########################################
                //validar que este en el capitulo 1 externo osea 2
                $count = DB::table('insigniacap')->where('capitulo', $cap)->count();
                if($count != 0){
                    $rinsignia = $this->valinsig($cap, $userauthid); 
                }else{
                    $rinsignia = "";
                }
            //#################################
            $mensajefinal = $this->mensaje($cap, $userauthid);

            return view('player.finishquiz')->with('puntos_s', $pt_s)
                                            ->with('puntos_i', $i_point)
                                            ->with('puntos_g', $g_point)
                                            ->with('retos', $Challengesplayed)
                                            ->with('subcapitulo', $subchapter_id)
                                            ->with('insigniawon', $insigniawon)
                                            ->with('insignianamewon', $insignianamewon)
                                            ->with('insigniadescwon', $insigniadescwon)
                                            ->with('leveluppopup', $leveluppopup)
                                            ->with('insigniapopup', $insigniapopup)
                                            ->with('recompensapopup', $recompensapopup)
                                            ->with('passretouppopup', $passretouppopup)
                                            ->with('recompensawon', $recompensawon)
                                            ->with('recompensanamewon', $recompensanamewon)
                                            ->with('inscap', $rinsignia)
                                            ->with('mensaje', $mensajefinal)
                                            ->with('cap', $cap); 
        }else{
            //validar reto
            $challenge_quiz_id_01= DB::table('challenge_quiz')
                                ->where('quiz_id', $quiz_selected)
                                ->get();
            //obtener el reto correspondiente;
            $challengesplayed_01 = Challenge::find($challenge_quiz_id_01[0]->challenge_id); 
            $subchapter_id_01 = $challengesplayed_01->subchapter_id;
            return view('player.gamefailed')->with('subcapitulo', $subchapter_id_01);
        }
      }//cierre del si de validar

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
