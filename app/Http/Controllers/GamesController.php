<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\alertaas;
use Illuminate\Http\Request;
use App\Subchapter;
use App\Chapter;
use App\Challenge;
use App\User;
Use App\Insignia;
use App\Gift;
use Carbon\Carbon;
use DB;
use Auth;
Use App\ModingCap; //se agrego para reg insignias por capitulo
use Intervention\Image\Facades\Image; // optimizar las imagenes

class GamesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
     //##############################
     //funcion que encuentra el capitulo y lo retorna al ser encontrado
    public function eval($id){
        $var1 = DB::table('challenges')
                ->join('subchapters', 'challenges.subchapter_id', '=', 'subchapters.id')
                ->where('challenges.id', $id)
                ->select('chapter_id')
                ->get();
        $cap = $var1[0]->chapter_id;
        return $cap;
    }
    //############################################
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
     //validar mensaje
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
    //comunicacion con la vista de los retos
    public function ahorcado($id){
        $cap = $this->eval($id); //se valida el capitulo
        $retos = Challenge::find($id);
        return view('games.ahorcado')->with('retos', $retos)->with('cap', $cap);
    }

    public function sopaletras($id){
        $cap = $this->eval($id); //se valida el capitulo
        $retos = Challenge::find($id);
        return view('games.sopaletras')->with('retos', $retos)->with('cap', $cap);
    }

    public function rompecabezas($id){
        $cap = $this->eval($id); //se valida el capitulo
        $retos = Challenge::find($id);
        return view('games.rompecabezas')->with('retos', $retos)->with('cap', $cap);
    }

    public function seevideos($id){
        $cap = $this->eval($id); //se valida el capitulo
        $retos = Challenge::find($id);
        return view('games.vervideos')->with('retos', $retos)->with('cap', $cap);
    }

    public function upfotos($id){
        $cap = $this->eval($id); //se valida el capitulo
        $retos = Challenge::find($id);
        return view('games.subirfotos')->with('retos', $retos)->with('cap', $cap);
    }

    public function lectura($id){
        $cap = $this->eval($id); //se valida el capitulo
        $retos = Challenge::find($id);
        return view('games.lectura')->with('retos', $retos)->with('cap', $cap);
    }

    public function outdoor($id){
        $cap = $this->eval($id); //se valida el capitulo
        $retos = Challenge::find($id);
        return view('games.outdoor')->with('retos', $retos)->with('cap', $cap);
    }

    //==============================================================================================================///
    //============================  GUARDAR resultados en cada juego  TERMINADO de unity  ===========================//

    public function unitygamesplayed(Request $request, $id){
        // dd($request->valorjuego); llega un 1 ó 0
        $validarSiguiente = 0; // validar el estado del capitulo siguiente
        $capsiguiente = 0;

        $userauthid = Auth::user()->id;
        $datetime = Carbon::now();  
        
        //obtener los datos del jugador
        $userplayer = User::find($userauthid);

        //obtener las respuestas elegidas por el jugador
        $valorjuego = $request->valorjuego;
        $usuario = $request->usuario;
        $idretoactual = $request->idretoactual;   
         //######################################
         $cap = $this->eval($idretoactual); //se valida el capitulo
         
         $reto = Challenge::find($idretoactual);
         $validar = DB::table('challenge_user')->where('challenge_id', $idretoactual)->where('user_id', $userauthid)->count();
         if($validar != 0){
            $retosig = $reto->subchapter_id;
             return redirect('playerchallenge/' .$retosig);
         }else{
        //validar si el reto unity se perdio o se gano 1 = win , 0 = lose
        if ($valorjuego == 1){ 
            //obtener el reto correspondiente:
            // ======================= PUNTAJES EN RETOS JUGADOS vs SUBCAPITULOS ========================
            //cantidad puntos S en el subcapitulo
            $subchapterspoint = DB::table('subchapters')->where('id', $reto->subchapter_id)->pluck('s_point'); 
            $subchapterpoint = $subchapterspoint[0];
            
            //cantidad de Retos en el subcapitulo actual
            $challengesin = DB::table('challenges')->where('subchapter_id', $reto->subchapter_id)->count();
            $challenges = DB::table('challenges')->where('subchapter_id', $reto->subchapter_id)
                                                ->where('id', $idretoactual)->get();

            $i_point = 0;
            $g_point = 0;
            foreach ($challenges as $challenge) {
                $i_point = $challenge->i_point;
                $g_point = $challenge->g_point;
            }                                                
            
            //cantidad puntos para retos
            $retospts = $subchapterpoint / $challengesin;
            //guardar campos en la tabla pivote CHALLENGE_USER, forzando campos que no estan en el guardado inmediato anterior
            $retos = new Challenge;
            $retos->users()->attach($usuario, [
                'start' => $datetime,
                'end' => $datetime,
                'result_api' => '0',
                's_point' => $retospts,
                'i_point' => $i_point,
                'g_point' => $g_point,
                'challenge_id' => $idretoactual
                ]);
                    
            //========================== TOTAL PUNTOS S DEL USUARIO - JUGADOR =======================
            $sum_spoints = 0; //puntos S
            $sum_ipoints = 0; //puntos I
            $sum_gpoints = 0; //puntos G
            
            //puntos S
            $userspoints = DB::table('challenge_user')->where('user_id', $userauthid)->pluck('s_point');
            for ($i=0; $i < count($userspoints); $i++) { 
                //suma de puntos S, retos jugados por el usuario
                $sum_spoints = $sum_spoints + $userspoints[$i];          
                //ACTUALIZAR puntaje del jugador
            }

            //puntos I
            $userspointi = DB::table('challenge_user')->where('user_id', $userauthid)->pluck('i_point');
            for ($i=0; $i < count($userspointi); $i++) { 
                //suma de puntos I, retos jugados por el usuario
                $sum_ipoints = $sum_ipoints + $userspointi[$i];          
                //ACTUALIZAR puntaje del jugador
            }
            //puntos G
            $userspointi = DB::table('challenge_user')->where('user_id', $userauthid)->pluck('g_point');
            for ($i=0; $i < count($userspointi); $i++) { 
                //suma de puntos S, retos jugados por el usuario
                $sum_gpoints = $sum_gpoints + $userspointi[$i];          
                //ACTUALIZAR puntaje del jugador
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
            // ========= actualizar puntos S, I, G del USERS:
            User::where('id', $userauthid)->update(['s_point' => $winpoints, 'i_point' => $sum_ipoints, 'g_point' => $sum_gpoints]);
            
            // ========= actualizar puntos S de CHALLENGES:
            challenge::where('id', $idretoactual)->update(['s_point' => $retospts]);        

            //========================================================================//
            //====================== Actualizar insignias del jugador  ===============//
            $insignias = Insignia::all();
            $insigniauser = User::find($userauthid);
            
            //asignar valor en caso de no haber ninguna insignia
            $insigniapopup = 0;
            $insigniawon = '';
            $insignianamewon = '';
            $insigniadescwon = '';
            //======================Validar si tiene una insignia agregada ===========//
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
            //====================== Actualizar INSIGNIAS del jugador  ===============//
            //========================================================================//



           //========================================================================//
            //====================== Actualizar RECOMPENSAS GIFTS del jugador  ===============//
            $recompensas = Gift::all();
            $recompensauser = User::find($userauthid);
            
            //asignar valor en caso de no haber ninguna insignia
            $recompensapopup = 0;
            $recompensawon = '';
            $recompensanamewon = '';

             //======================= Verificar si tiene recompensas ===================//
             //veirifcar si el reto tiene una recompensa
             if($reto->id_grupo != 1){
                //tiene recompensa
               $search = DB::table('gifts')
                         ->where('id_grupo', $reto->id_grupo)
                         ->where('avatar_id', $userplayer->avatar_id)
                         ->select('gifts.id as idin', 'gifts.imagen', 'gifts.name', 'avatarchange as avatar')
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
                    //=================end guaradar avatar ==============================

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
            
            //====================POPUP al terminar ultimo reto del tema:
            //verificar si esta en el ultimo RETO del TEMA al que le pertenece

            $subcapitulo_reto_temas = DB::table('subchapters')
                                ->join('challenges', 'subchapters.id', '=', 'challenges.subchapter_id')  
                                ->select('subchapter_id', DB::raw('COUNT(subchapter_id) as cantidad_retos_tema') )     
                                ->where('subchapters.id', $reto->subchapter_id) 
                                ->groupBy('subchapter_id')
                                ->first();
            
            $subcapitulo_reto = DB::table('subchapters')
                                ->join('challenges', 'subchapters.id', '=', 'challenges.subchapter_id')
                                ->join('challenge_user', 'challenges.id', '=', 'challenge_user.challenge_id')  
                                ->select( DB::raw('COUNT(challenge_user.user_id) as cantidad_retos_terminados'))     
                                ->where('subchapters.id', $reto->subchapter_id)
                                ->where('challenge_user.user_id', $userauthid) 
                                ->first();

                
            if ($insigniapopup == 0 && $recompensapopup == 0 && $leveluppopup == 0 || $subcapitulo_reto_temas->cantidad_retos_tema == $subcapitulo_reto->cantidad_retos_terminados) {
                $passretouppopup =  1;
            } else {
                $passretouppopup =  0;
            }
                        
            $pt_s = $retospts;
            //#################################
          
            $count = DB::table('insigniacap')->where('capitulo', $cap)->count();
      
            if($count != 0){
               $rinsignia = $this->valinsig($cap, $userauthid); 
             }else{
               $rinsignia = "";
             }
             //validar mensaje de finalizacion 
              $mensajefinal = $this->mensaje($cap, $userauthid);
            //========== validar el numero de capitulo que sigue si este reto es el final =============
            if($subcapitulo_reto_temas->cantidad_retos_tema == $subcapitulo_reto->cantidad_retos_terminados){
                $validarSiguiente = 1;
                $capsiguiente = $cap + 1; //sumar un valor al capitulo
            }
            return view('player.finishquiz')->with('puntos_s', $pt_s)
                                            ->with('puntos_i', $i_point)
                                            ->with('puntos_g', $g_point)
                                            ->with('retos', $reto)
                                            ->with('subcapitulo', $reto->subchapter_id)
                                            ->with('leveluppopup', $leveluppopup)
                                            ->with('insigniapopup', $insigniapopup)
                                            ->with('recompensapopup', $recompensapopup)
                                            ->with('passretouppopup', $passretouppopup)
                                            ->with('insigniawon', $insigniawon)
                                            ->with('insignianamewon', $insignianamewon)
                                            ->with('insigniadescwon', $insigniadescwon)                                            
                                            ->with('recompensawon', $recompensawon)
                                            ->with('cap', $cap)
                                            ->with('inscap', $rinsignia)
                                            ->with('mensaje', $mensajefinal)
                                            ->with('validarSiguiente', $validarSiguiente)
                                            ->with('capsiguiente', $capsiguiente)
                                            ->with('recompensanamewon', $recompensanamewon);
        }else{
            $reto = Challenge::find($idretoactual);
            return view('player.gamefailed')->with('subcapitulo', $reto->subchapter_id)->with('cap', $cap);
        }
       } //cierre validacion
    }




    public function playseevideos(Request $request, $id){
        $validarSiguiente = 0; // validar el estado del capitulo siguiente
        $capsiguiente = 0;

        $rules = [
            'evidence' => 'required|min:120',           
        ];         
        $messages = [
            'evidence.required' => 'Es necesario registras como fue tu experiencia en este reto.',
            'evidence.min' => 'Trata con un poco mas de palabras para relatar tu experiencia.',            
        ];         
        $this->validate($request, $rules, $messages);

        $userauthid = Auth::user()->id;
        $datetime = Carbon::now();   
        
        //obtener los datos del jugador
        $userplayer = User::find($userauthid);

        //obtener las respuestas elegidas por el jugador
        $usuario = $request->usuario;
        $idretoactual = $request->reto; 
        $evidencia = $request->evidence;
         $cap = $this->eval($idretoactual); //se valida el capitulo
        //obtener el reto correspondiente:
        $reto = Challenge::find($idretoactual);
        $contar1 = DB::table('videos')->where('id_user', $usuario)->where('id_challenge', $idretoactual)->count();
        if($contar1 != 0){
            $retosig = $reto->subchapter_id;
            return redirect('playerchallenge/' .$retosig);
        }
        else{
        DB::table('videos')->insert([
            'evidence'     => $evidencia,
            'id_user'      => $usuario,
            'id_challenge' => $idretoactual,
        ]);




        // ======================= PUNTAJES EN RETOS JUGADOS vs SUBCAPITULOS ========================
        //cantidad puntos S en el subcapitulo
        $subchapterspoint = DB::table('subchapters')->where('id', $reto->subchapter_id)->pluck('s_point'); 
        $subchapterpoint = $subchapterspoint[0];
        
        //cantidad de Retos en el subcapitulo actual
        $challengesin = DB::table('challenges')->where('subchapter_id', $reto->subchapter_id)->count();        
        $challenges = DB::table('challenges')->where('subchapter_id', $reto->subchapter_id)
                                            ->where('id', $idretoactual)->get();


        $i_point = 0;
        $g_point = 0;
        foreach ($challenges as $challenge) {
            $i_point = $challenge->i_point;
            $g_point = $challenge->g_point;
        }                                                 

        //cantidad puntos para retos
        $retospts = $subchapterpoint / $challengesin;
        
    
        //guardar campos en la tabla pivote CHALLENGE_USER, forzando campos que no estan en el guardado inmediato anterior
        $retos = new Challenge;
        $retos->users()->attach($usuario, [
            'start' => $datetime,
            'end' => $datetime,
            'result_api' => '0',
            's_point' => $retospts,
            'i_point' => $i_point,
            'g_point' => $g_point,
            'challenge_id' => $idretoactual
            ]);
                
        //========================== TOTAL PUNTOS S DEL USUARIO - JUGADOR =======================
        $sum_spoints = 0; //puntos S
        $sum_ipoints = 0; //puntos I
        $sum_gpoints = 0; //puntos G
        
        //puntos S
        $userspoints = DB::table('challenge_user')->where('user_id', $userauthid)->pluck('s_point');
        for ($i=0; $i < count($userspoints); $i++) { 
            //suma de puntos S, retos jugados por el usuario
            $sum_spoints = $sum_spoints + $userspoints[$i];          
            //ACTUALIZAR puntaje del jugador
        }
        //puntos I
        $userspointi = DB::table('challenge_user')->where('user_id', $userauthid)->pluck('i_point');
        for ($i=0; $i < count($userspointi); $i++) { 
            //suma de puntos I, retos jugados por el usuario
            $sum_ipoints = $sum_ipoints + $userspointi[$i];          
            //ACTUALIZAR puntaje del jugador
        }
        //puntos G
        $userspointi = DB::table('challenge_user')->where('user_id', $userauthid)->pluck('g_point');
        for ($i=0; $i < count($userspointi); $i++) { 
            //suma de puntos S, retos jugados por el usuario
            $sum_gpoints = $sum_gpoints + $userspointi[$i];          
            //ACTUALIZAR puntaje del jugador
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


        // =========== actualizar puntos S, I, G del USERS:
        User::where('id', $userauthid)->update(['s_point' => $winpoints, 'i_point' => $sum_ipoints, 'g_point' => $sum_gpoints]);
        
        //actualizar puntos S de CHALLENGES:
        challenge::where('id', $idretoactual)->update(['s_point' => $retospts]);        

        //========  Actualizar insignias del jugador  =======//
        $insignias = Insignia::all();
        $insigniauser = User::find($userauthid);
  

        //asignar valor en caso de no haber ninguna insignia
        $insigniapopup = 0;
        $insigniawon = '';
        $insignianamewon = '';
        $insigniadescwon = '';

         //obtener y recorrer todas las insignias
         //====================================validar insignias
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

            //===================== verificar si tiene insignia ===============//
             //veirifcar si el reto tiene una recompensa
             if($reto->id_grupo != 1){
                //tiene recompensa
               $search = DB::table('gifts')
                         ->where('id_grupo', $reto->id_grupo)
                         ->where('avatar_id', $userplayer->avatar_id)
                         ->select('gifts.id as idin', 'gifts.imagen', 'gifts.name', 'avatarchange as avatar')
                         ->first();
                //validar que esta insignia no este rpetida
                $validarin = DB::table('gift_user')->where('user_id', $userauthid)->where('gift_id', $search->idin)->get();
                if ($validarin->isEmpty()) {                        
                    DB::table('gift_user')->insert([
                        'gift_id' => $search->idin,
                        'user_id' => $userplayer->id,
                        // Agrega más columnas y valores según corresponda
                    ]);
                    //una insignia nueva
                    //====================aqui se debe actualizar el usuario =========================
                    $usuact =User::findOrfail($userplayer->id);
                    $usuact->imgavat = $search->avatar; //guarda la direccion del avatar
                    $usuact->save();
                    //=========================================================
                    $recompensapopup = 1;
                    $recompensawon = $search->imagen;
                    $recompensanamewon = $search->name;
                }else{
                    $recompensapopup = 0;
                }
               
            }
            //====================== Actualizar RECOMPENSAS del jugador  ===============//
            //========================================================================//
        

        //======= Enviar confirmacion via EMAIL al jefe de area del reto terminado por el usuadio                
        //====================POPUP al terminar ultimo reto del tema:
        //verificar si esta en el ultimo RETO del TEMA al que le pertenece
        $subcapitulo_reto_temas = DB::table('subchapters')
                                ->join('challenges', 'subchapters.id', '=', 'challenges.subchapter_id')  
                                ->select('subchapter_id', DB::raw('COUNT(subchapter_id) as cantidad_retos_tema') )     
                                ->where('subchapters.id', $reto->subchapter_id) 
                                ->groupBy('subchapter_id')
                                ->first();
   
        $subcapitulo_reto = DB::table('subchapters')
                                ->join('challenges', 'subchapters.id', '=', 'challenges.subchapter_id')
                                ->join('challenge_user', 'challenges.id', '=', 'challenge_user.challenge_id')  

                                ->select( DB::raw('COUNT(challenge_user.user_id) as cantidad_retos_terminados'))     
                                ->where('subchapters.id', $reto->subchapter_id)
                                ->where('challenge_user.user_id', $userauthid) 
                                ->first();


        if ($insigniapopup == 0 && $recompensapopup == 0 && $leveluppopup == 0 || $subcapitulo_reto_temas->cantidad_retos_tema == $subcapitulo_reto->cantidad_retos_terminados) {
            $passretouppopup =  1;
        } else {
            $passretouppopup =  0;
        }

        $pt_s = $retospts;
         //############################
        $count = DB::table('insigniacap')->where('capitulo', $cap)->count();
           if($count != 0){
             $rinsignia = $this->valinsig($cap, $userauthid); 
           }else{
             $rinsignia = "";
           }
         //validar mensaje de finalizacion 
        $mensajefinal = $this->mensaje($cap, $userauthid);
        
        //========== validar el numero de capitulo que sigue si este reto es el final =============
        if($subcapitulo_reto_temas->cantidad_retos_tema == $subcapitulo_reto->cantidad_retos_terminados){
            $validarSiguiente = 1;
            $capsiguiente = $cap + 1; //sumar un valor al capitulo
        }

        return view('player.finishquiz')->with('puntos_s', $pt_s)
                                        ->with('puntos_i', $i_point)
                                        ->with('puntos_g', $g_point)
                                        ->with('retos', $reto)
                                        ->with('subcapitulo', $reto->subchapter_id)
                                        ->with('leveluppopup', $leveluppopup)
                                        ->with('insigniapopup', $insigniapopup)
                                        ->with('insigniawon', $insigniawon)
                                        ->with('insignianamewon', $insignianamewon)
                                        ->with('insigniadescwon', $insigniadescwon)
                                        ->with('recompensapopup', $recompensapopup)
                                        ->with('passretouppopup', $passretouppopup)
                                        ->with('recompensawon', $recompensawon)
                                        ->with('recompensanamewon', $recompensanamewon)
                                        ->with('inscap', $rinsignia)
                                        ->with('mensaje', $mensajefinal)
                                        ->with('validarSiguiente', $validarSiguiente)
                                        ->with('capsiguiente', $capsiguiente)
                                        ->with('cap', $cap);
         }
    }



    public function playupfotos(Request $request, $id){
        $validarSiguiente = 0; // validar el estado del capitulo siguiente
        $capsiguiente = 0;

        $rules = [
            'evidence' => 'required|min:120',           
            'image' => 'required',           
        ];         
        $messages = [
            'evidence.required' => 'Es necesario registras como fue tu experiencia en este reto.',
            'evidence.min' => 'Trata con un poco mas de palabras para relatar tu experiencia.',            
            'image.required' => 'Sube Una Fotografia sobre lo solicitado en el reto.',
        ];         
        $this->validate($request, $rules, $messages);

        $userauthid = Auth::user()->id;
        $datetime = Carbon::now();       

        //obtener los datos del jugador
        $userplayer = User::find($userauthid);

        //proceso guardar archivo material para el reto
       /* if ($request->hasFile('image')) {            
            $thefilename = $request->file('image')->getClientOriginalName();
            $pathmaterial = $thefilename;
            $request->file('image')->storeAs('gamefoto', $thefilename);
        }else {
            $pathmaterial ="default.png";
        }*/
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $val = "foto" . time() . "." . $file->guessExtension();
            $ruta = public_path("imgoutdoor/" . $val);
            // Crear una instancia de la imagen y redimensionarla si es necesario
            $img = Image::make($file->getRealPath());

            // Redimensionar la imagen si es necesario
            $img->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Optimizar la imagen ajustando la calidad (70% en este ejemplo) y manteniendo la extensión original
            $img->encode($file->guessExtension(), 80);

            // Guardar la imagen optimizada en la ruta especificada
            $img->save($ruta);
            $pathmaterial = $val;
        }

        //obtener las respuestas elegidas por el jugador
        $usuario = $request->usuario;
        $idretoactual = $request->reto;
        $evidencia = $request->evidence;
        $videour = $request->video;
        $cap = $this->eval($idretoactual); //se valida el capitulo
        //obtener el reto correspondiente:
        $reto = Challenge::find($idretoactual);
        $contar1 = DB::table('pictures')->where('id_user', $usuario)->where('id_challenge', $idretoactual)->count(); 
        if($contar1 != 0){
            $retosig = $reto->subchapter_id;
            return redirect('playerchallenge/' .$retosig);
        }
        else{
        DB::table('pictures')->insert([
            'evidence'     => $evidencia,
            'image'        => $pathmaterial,
            'id_user'      => $usuario,
            'video'        => $videour,
            'id_challenge' => $idretoactual,
        ]);

        // ======================= PUNTAJES EN RETOS JUGADOS vs SUBCAPITULOS ========================
        //cantidad puntos S en el subcapitulo
        $subchapterspoint = DB::table('subchapters')->where('id', $reto->subchapter_id)->pluck('s_point'); 
        $subchapterpoint = $subchapterspoint[0];
        
        //cantidad de Retos en el subcapitulo actual
        $challengesin = DB::table('challenges')->where('subchapter_id', $reto->subchapter_id)->count();
        $challenges = DB::table('challenges')->where('subchapter_id', $reto->subchapter_id)
                                            ->where('id', $idretoactual)->get();

        //cantidad puntos para retos
        $retospts = $subchapterpoint / $challengesin;               
        

        $i_point = 0;
        $g_point = 0;
        foreach ($challenges as $challenge) {
            $i_point = $challenge->i_point;
            $g_point = $challenge->g_point;
        }     

        //guardar campos en la tabla pivote CHALLENGE_USER, forzando campos que no estan en el guardado inmediato anterior
        $retos = new Challenge;
        $retos->users()->attach($usuario, [
            'start' => $datetime,
            'end' => $datetime,
            'result_api' => '0',
            's_point' => $retospts,
            'i_point' => $i_point,
            'g_point' => $g_point,
            'challenge_id' => $idretoactual
            ]);
                
        //========================== TOTAL PUNTOS S DEL USUARIO - JUGADOR =======================
        $sum_spoints = 0; //puntos S
        $sum_ipoints = 0; //puntos I
        $sum_gpoints = 0; //puntos G
        
        //puntos S
        $userspoints = DB::table('challenge_user')->where('user_id', $userauthid)->pluck('s_point');
        for ($i=0; $i < count($userspoints); $i++) { 
            //suma de puntos S, retos jugados por el usuario
            $sum_spoints = $sum_spoints + $userspoints[$i];          
            //ACTUALIZAR puntaje del jugador
        }
        //puntos I
        $userspointi = DB::table('challenge_user')->where('user_id', $userauthid)->pluck('i_point');
        for ($i=0; $i < count($userspointi); $i++) { 
            //suma de puntos I, retos jugados por el usuario
            $sum_ipoints = $sum_ipoints + $userspointi[$i];          
            //ACTUALIZAR puntaje del jugador
        }
        //puntos G
        $userspointi = DB::table('challenge_user')->where('user_id', $userauthid)->pluck('g_point');
        for ($i=0; $i < count($userspointi); $i++) { 
            //suma de puntos S, retos jugados por el usuario
            $sum_gpoints = $sum_gpoints + $userspointi[$i];          
            //ACTUALIZAR puntaje del jugador
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


        // ========= actualizar puntos S, I, G del USERS:
        User::where('id', $userauthid)->update(['s_point' => $winpoints, 'i_point' => $sum_ipoints, 'g_point' => $sum_gpoints]);
        
        //actualizar puntos S de CHALLENGES:
        challenge::where('id', $idretoactual)->update(['s_point' => $retospts]);        

        //========  Actualizar insignias del jugador  =======//
        $insignias = Insignia::all();
        $insigniauser = User::find($userauthid);
        $insigniauser->s_point;
        $insigniauser->i_point;
        $insigniauser->g_point;


        //asignar valor en caso de no haber ninguna insignia
        $insigniapopup = 0;
        $insigniawon = '';
        $insignianamewon = '';
        $insigniadescwon = '';

        //====================================insignias buscar =====================

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

             //======================Encontrar recompensa ======================//
             //veirifcar si el reto tiene una recompensa
             if($reto->id_grupo != 1){
                //tiene recompensa
               $search = DB::table('gifts')
                         ->where('id_grupo', $reto->id_grupo)
                         ->where('avatar_id', $userplayer->avatar_id)
                         ->select('gifts.id as idin', 'gifts.imagen', 'gifts.name', 'avatarchange as avatar')
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
                    //=====================================================================
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

         //====================POPUP al terminar ultimo reto del tema:
        //verificar si esta en el ultimo RETO del TEMA al que le pertenece
        $subcapitulo_reto_temas = DB::table('subchapters')
                                ->join('challenges', 'subchapters.id', '=', 'challenges.subchapter_id')  
                                ->select('subchapter_id', DB::raw('COUNT(subchapter_id) as cantidad_retos_tema') )     
                                ->where('subchapters.id', $reto->subchapter_id) 
                                ->groupBy('subchapter_id')
                                ->first();

        $subcapitulo_reto = DB::table('subchapters')
                                ->join('challenges', 'subchapters.id', '=', 'challenges.subchapter_id')
                                ->join('challenge_user', 'challenges.id', '=', 'challenge_user.challenge_id')  
                                ->select( DB::raw('COUNT(challenge_user.user_id) as cantidad_retos_terminados'))     
                                ->where('subchapters.id', $reto->subchapter_id)
                                ->where('challenge_user.user_id', $userauthid) 
                                ->first();

        if ($insigniapopup == 0 && $recompensapopup == 0 && $leveluppopup == 0 || $subcapitulo_reto_temas->cantidad_retos_tema == $subcapitulo_reto->cantidad_retos_terminados) {
            $passretouppopup =  1;
        } else {
            $passretouppopup =  0;
        }
   
        $pt_s = $retospts;
        //###############################
        $count = DB::table('insigniacap')->where('capitulo', $cap)->count();
        if($count != 0){
             $rinsignia = $this->valinsig($cap, $userauthid); 
        }else{
             $rinsignia = "";
        }
        //##############################
        //validar mensaje de finalizacion 
        $mensajefinal = $this->mensaje($cap, $userauthid);

         //========== validar el numero de capitulo que sigue si este reto es el final =============
        if($subcapitulo_reto_temas->cantidad_retos_tema == $subcapitulo_reto->cantidad_retos_terminados){
            $validarSiguiente = 1;
            $capsiguiente = $cap + 1; //sumar un valor al capitulo
        }

        return view('player.finishquiz')->with('puntos_s', $pt_s)
                                        ->with('puntos_i', $i_point)
                                        ->with('puntos_g', $g_point)
                                        ->with('retos', $reto)
                                        ->with('subcapitulo', $reto->subchapter_id)
                                        ->with('leveluppopup', $leveluppopup)
                                        ->with('insigniapopup', $insigniapopup)
                                        ->with('insigniawon', $insigniawon)
                                        ->with('insignianamewon', $insignianamewon)
                                        ->with('insigniadescwon', $insigniadescwon)
                                        ->with('recompensapopup', $recompensapopup)
                                        ->with('passretouppopup', $passretouppopup)
                                        ->with('recompensawon', $recompensawon)
                                        ->with('cap', $cap)
                                        ->with('inscap', $rinsignia)
                                        ->with('mensaje', $mensajefinal)
                                        ->with('validarSiguiente', $validarSiguiente)
                                        ->with('capsiguiente', $capsiguiente)
                                        ->with('recompensanamewon', $recompensanamewon);
        }
    }




    public function playlectura(Request $request, $id){
        $validarSiguiente = 0; // validar el estado del capitulo siguiente
        $capsiguiente = 0;

        $rules = [
            'evidence' => 'required|min:120',           
        ];         
        $messages = [
            'evidence.required' => 'Es necesario registras como fue tu experiencia en este reto.',
            'evidence.min' => 'Trata con un poco mas de palabras para relatar tu experiencia.',            
        ];         
        $this->validate($request, $rules, $messages);

        $userauthid = Auth::user()->id;
        $datetime = Carbon::now();       

        //obtener los datos del jugador
        $userplayer = User::find($userauthid);

        //obtener las respuestas elegidas por el jugador
        $usuario = $request->usuario;
        $idretoactual = $request->reto;
        $evidencia = $request->evidence;
        $cap = $this->eval($idretoactual); //se valida el capitulo
        //obtener el reto correspondiente:
        $reto = Challenge::find($idretoactual);
        $contar1 = DB::table('readings')->where('id_user', $usuario)->where('id_challenge', $idretoactual)->count();
        if($contar1 != 0){
            $retosig = $reto->subchapter_id;
            return redirect('playerchallenge/' .$retosig);
        }
        else{
        DB::table('readings')->insert([
            'evidence'     => $evidencia,
            'id_user'      => $usuario,
            'id_challenge' => $idretoactual,
        ]);

        // ======================= PUNTAJES EN RETOS JUGADOS vs SUBCAPITULOS ========================
        //cantidad puntos S en el subcapitulo
        $subchapterspoint = DB::table('subchapters')->where('id', $reto->subchapter_id)->pluck('s_point'); 
        $subchapterpoint = $subchapterspoint[0];
        
        //cantidad de Retos en el subcapitulo actual
        $challengesin = DB::table('challenges')->where('subchapter_id', $reto->subchapter_id)->count();
        $challenges = DB::table('challenges')->where('subchapter_id', $reto->subchapter_id)
                                                ->where('id', $idretoactual)->get();

        //cantidad puntos para retos
        $retospts = $subchapterpoint / $challengesin;
        
        

        $i_point = 0;
        $g_point = 0;
        foreach ($challenges as $challenge) {
            $i_point = $challenge->i_point;
            $g_point = $challenge->g_point;
        }     

        //guardar campos en la tabla pivote CHALLENGE_USER, forzando campos que no estan en el guardado inmediato anterior
        $retos = new Challenge;
        $retos->users()->attach($usuario, [
            'start' => $datetime,
            'end' => $datetime,
            'result_api' => '0',
            's_point' => $retospts,
            'i_point' => $i_point,
            'g_point' => $g_point,
            'challenge_id' => $idretoactual
            ]);
                
        //========================== TOTAL PUNTOS S DEL USUARIO - JUGADOR =======================
        $sum_spoints = 0; //puntos S
        $sum_ipoints = 0; //puntos I
        $sum_gpoints = 0; //puntos G
        
        //puntos S
        $userspoints = DB::table('challenge_user')->where('user_id', $userauthid)->pluck('s_point');
        for ($i=0; $i < count($userspoints); $i++) { 
            //suma de puntos S, retos jugados por el usuario
            $sum_spoints = $sum_spoints + $userspoints[$i];          
            //ACTUALIZAR puntaje del jugador
        }
        //puntos I
        $userspointi = DB::table('challenge_user')->where('user_id', $userauthid)->pluck('i_point');
        for ($i=0; $i < count($userspointi); $i++) { 
            //suma de puntos I, retos jugados por el usuario
            $sum_ipoints = $sum_ipoints + $userspointi[$i];          
            //ACTUALIZAR puntaje del jugador
        }
        //puntos G
        $userspointi = DB::table('challenge_user')->where('user_id', $userauthid)->pluck('g_point');
        for ($i=0; $i < count($userspointi); $i++) { 
            //suma de puntos S, retos jugados por el usuario
            $sum_gpoints = $sum_gpoints + $userspointi[$i];          
            //ACTUALIZAR puntaje del jugador
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


        // ======== actualizar puntos S, I, G del USERS:
        User::where('id', $userauthid)->update(['s_point' => $winpoints, 'i_point' => $sum_ipoints, 'g_point' => $sum_gpoints]);
        
        //actualizar puntos S de CHALLENGES:
        challenge::where('id', $idretoactual)->update(['s_point' => $retospts]);        

        //========  Actualizar insignias del jugador  =======//
        $insignias = Insignia::all();
        $insigniauser = User::find($userauthid);

        //asignar valor en caso de no haber ninguna insignia
        $insigniapopup = 0;
        $insigniawon = '';
        $insignianamewon = '';
        $insigniadescwon = '';

         //===========================================validar si tiene insignias =====================

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

            //=======================Buscar recompensa ============================//
            //veirifcar si el reto tiene una recompensa
             if($reto->id_grupo != 1){
                //tiene recompensa
               $search = DB::table('gifts')
                         ->where('id_grupo', $reto->id_grupo)
                         ->where('avatar_id', $userplayer->avatar_id)
                         ->select('gifts.id as idin', 'gifts.imagen', 'gifts.name', 'avatarchange as avatar')
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
                    //====================================================================
                    //una insignia nueva
                    $recompensapopup = 1;
                    $recompensawon = $search->imagen;
                    $recompensanamewon = $search->name;
                }else{
                    $recompensapopup = 0;
                }
               
            }

        //====================POPUP al terminar ultimo reto del tema:
        //verificar si esta en el ultimo RETO del TEMA al que le pertenece
        $subcapitulo_reto_temas = DB::table('subchapters')
                                ->join('challenges', 'subchapters.id', '=', 'challenges.subchapter_id')  
                                ->select('subchapter_id', DB::raw('COUNT(subchapter_id) as cantidad_retos_tema') )     
                                ->where('subchapters.id', $reto->subchapter_id) 
                                ->groupBy('subchapter_id')
                                ->first();

        $subcapitulo_reto = DB::table('subchapters')
                                ->join('challenges', 'subchapters.id', '=', 'challenges.subchapter_id')
                                ->join('challenge_user', 'challenges.id', '=', 'challenge_user.challenge_id')  
                                ->select( DB::raw('COUNT(challenge_user.user_id) as cantidad_retos_terminados'))     
                                ->where('subchapters.id', $reto->subchapter_id)
                                ->where('challenge_user.user_id', $userauthid) 
                                ->first();


        if ($insigniapopup == 0 && $recompensapopup == 0 && $leveluppopup == 0 || $subcapitulo_reto_temas->cantidad_retos_tema == $subcapitulo_reto->cantidad_retos_terminados) {
            $passretouppopup =  1;
        } else {
            $passretouppopup =  0;
        }

        $pt_s = $retospts;
        //################################
        $count = DB::table('insigniacap')->where('capitulo', $cap)->count();
         if($count != 0){
             $rinsignia = $this->valinsig($cap, $userauthid); 
          }else{
             $rinsignia = "";
          }
        //#######################################
        //validar mensaje de finalizacion 
        $mensajefinal = $this->mensaje($cap, $userauthid);

        //========== validar el numero de capitulo que sigue si este reto es el final =============
        if($subcapitulo_reto_temas->cantidad_retos_tema == $subcapitulo_reto->cantidad_retos_terminados){
            $validarSiguiente = 1;
            $capsiguiente = $cap + 1; //sumar un valor al capitulo
        }

        return view('player.finishquiz')->with('puntos_s', $pt_s)
                                        ->with('puntos_i', $i_point)
                                        ->with('puntos_g', $g_point)
                                        ->with('retos', $reto)
                                        ->with('subcapitulo', $reto->subchapter_id)
                                        ->with('leveluppopup', $leveluppopup)
                                        ->with('insigniapopup', $insigniapopup)
                                        ->with('insigniawon', $insigniawon)
                                        ->with('insignianamewon', $insignianamewon)
                                        ->with('insigniadescwon', $insigniadescwon)
                                        ->with('recompensapopup', $recompensapopup)
                                        ->with('passretouppopup', $passretouppopup)
                                        ->with('recompensawon', $recompensawon)
                                        ->with('cap', $cap)
                                        ->with('inscap', $rinsignia)
                                        ->with('mensaje', $mensajefinal)
                                        ->with('validarSiguiente', $validarSiguiente)
                                        ->with('capsiguiente', $capsiguiente)
                                        ->with('recompensanamewon', $recompensanamewon);
        }
    }



    public function playoutdoor(Request $request, $id){
        //return $request;
        $validarSiguiente = 0; // validar el estado del capitulo siguiente
        $capsiguiente = 0;

        $rules = [
            'evidence' => 'required|min:120',           
        ];         
        $messages = [
            'evidence.required' => 'Es necesario registras como fue tu experiencia en este reto.',
            'evidence.min' => 'Trata con un poco mas de palabras para relatar tu experiencia.',            
        ];         
        $this->validate($request, $rules, $messages);

        $userauthid = Auth::user()->id;
        $datetime = Carbon::now(); 
        
        //obtener los datos del jugador
        $userplayer = User::find($userauthid);

        //proceso guardar archivo material para el reto
        /*if ($request->hasFile('material')) {  
            $file = $request->file('material');         
            $thefilename = $request->file('material')->getClientOriginalName();
            $pathmaterial = $thefilename;
            $request->file('material')->storeAs('gameoutdoor', $thefilename);
        }*/

        if ($request->hasFile('material')) {
            $file = $request->file('material');
            $val = "outdoor" . time() . "." . $file->guessExtension();
            $ruta = public_path("imgoutdoor/" . $val);
            // Crear una instancia de la imagen y redimensionarla si es necesario
            $img = Image::make($file->getRealPath());

            // Redimensionar la imagen si es necesario
            $img->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Optimizar la imagen ajustando la calidad (70% en este ejemplo) y manteniendo la extensión original
            $img->encode($file->guessExtension(), 80);

            // Guardar la imagen optimizada en la ruta especificada
            $img->save($ruta);
            $pathmaterial = $val;

        }

        //obtener las respuestas elegidas por el jugador
        $usuario = $request->usuario;
        $idretoactual = $request->reto;
        $evidencia = $request->evidence;
        $video = $request->linkvideo;
        $cap = $this->eval($idretoactual); //se valida el capitulo
        //obtener el reto correspondiente:
        $reto = Challenge::find($idretoactual);
        $contar1 = DB::table('outdoors')->where('id_user', $usuario)->where('id_challenge', $idretoactual)->count();
        if($contar1 != 0){
            $retosig = $reto->subchapter_id;
            return redirect('playerchallenge/' .$retosig);
        }
        else{
        DB::table('outdoors')->insert([
            'evidence'     => $evidencia,
            'image'        => $pathmaterial,
            'video'        => $video,
            'id_user'      => $usuario,
            'id_challenge' => $idretoactual,
        ]);

        // ======================= PUNTAJES EN RETOS JUGADOS vs SUBCAPITULOS ========================
        //cantidad puntos S en el subcapitulo
        $subchapterspoint = DB::table('subchapters')->where('id', $reto->subchapter_id)->pluck('s_point'); 
        $subchapterpoint = $subchapterspoint[0];
        
        //cantidad de Retos en el subcapitulo actual
        $challengesin = DB::table('challenges')->where('subchapter_id', $reto->subchapter_id)->count();    
        $challenges = DB::table('challenges')->where('subchapter_id', $reto->subchapter_id)
                                            ->where('id', $idretoactual)->get();
        
        //cantidad puntos para retos
        $retospts = $subchapterpoint / $challengesin;
        
        $i_point = 0;
        $g_point = 0;
        foreach ($challenges as $challenge) {
            $i_point = $challenge->i_point;
            $g_point = $challenge->g_point;
        }     

        //guardar campos en la tabla pivote CHALLENGE_USER, forzando campos que no estan en el guardado inmediato anterior
        $retos = new Challenge;
        $retos->users()->attach($usuario, [
            'start' => $datetime,
            'end' => $datetime,
            'result_api' => '0',
            's_point' => $retospts,
            'i_point' => $i_point,
            'g_point' => $g_point,
            'challenge_id' => $idretoactual
            ]);
                
        //========================== TOTAL PUNTOS S DEL USUARIO - JUGADOR =======================
        $sum_spoints = 0; //puntos S
        $sum_ipoints = 0; //puntos I
        $sum_gpoints = 0; //puntos G
        
        //puntos S
        $userspoints = DB::table('challenge_user')->where('user_id', $userauthid)->pluck('s_point');
        for ($i=0; $i < count($userspoints); $i++) { 
            //suma de puntos S, retos jugados por el usuario
            $sum_spoints = $sum_spoints + $userspoints[$i];          
            //ACTUALIZAR puntaje del jugador
        }
        //puntos I
        $userspointi = DB::table('challenge_user')->where('user_id', $userauthid)->pluck('i_point');
        for ($i=0; $i < count($userspointi); $i++) { 
            //suma de puntos I, retos jugados por el usuario
            $sum_ipoints = $sum_ipoints + $userspointi[$i];          
            //ACTUALIZAR puntaje del jugador
        }
        //puntos G
        $userspointi = DB::table('challenge_user')->where('user_id', $userauthid)->pluck('g_point');
        for ($i=0; $i < count($userspointi); $i++) { 
            //suma de puntos S, retos jugados por el usuario
            $sum_gpoints = $sum_gpoints + $userspointi[$i];          
            //ACTUALIZAR puntaje del jugador
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


        // ================== actualizar puntos S, I, G del USERS:
        User::where('id', $userauthid)->update(['s_point' => $winpoints, 'i_point' => $sum_ipoints, 'g_point' => $sum_gpoints]);
        
        //actualizar puntos S de CHALLENGES:
        challenge::where('id', $idretoactual)->update(['s_point' => $retospts]);        

        //========  Actualizar insignias del jugador  =======//
        $insignias = Insignia::all();
        $insigniauser = User::find($userauthid);

        //asignar valor en caso de no haber ninguna insignia
        $insigniapopup = 0;
        $insigniawon = '';
        $insignianamewon = '';
        $insigniadescwon = '';

        //===============================validar insignia============================
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

             //======================validar recompensa ==============================//
              //veirifcar si el reto tiene una recompensa
             if($reto->id_grupo != 1){
                //tiene recompensa
               $search = DB::table('gifts')
                         ->where('id_grupo', $reto->id_grupo)
                         ->where('avatar_id', $userplayer->avatar_id)
                         ->select('gifts.id as idin', 'gifts.imagen', 'gifts.name', 'avatarchange as avatar')
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
                    //=========================================================
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
        //====================POPUP al terminar ultimo reto del tema:
        //verificar si esta en el ultimo RETO del TEMA al que le pertenece
        $subcapitulo_reto_tema = DB::table('subchapters')
                            ->join('challenges', 'subchapters.id', '=', 'challenges.subchapter_id')  
                            ->select('subchapter_id', DB::raw('COUNT(subchapter_id) as cantidad_retos_tema') )     
                            ->where('subchapters.id', $reto->subchapter_id) 
                            ->groupBy('subchapter_id')
                            ->first();

        $subcapitulo_reto = DB::table('subchapters')
                        ->join('challenges', 'subchapters.id', '=', 'challenges.subchapter_id')
                        ->join('challenge_user', 'challenges.id', '=', 'challenge_user.challenge_id')  
                        ->select( DB::raw('COUNT(challenge_user.user_id) as cantidad_retos_terminados'))     
                        ->where('subchapters.id', $reto->subchapter_id)
                        ->where('challenge_user.user_id', $userauthid) 
                        ->first();

        

        if ($insigniapopup == 0 && $recompensapopup == 0 && $leveluppopup == 0 || $subcapitulo_reto_tema->cantidad_retos_tema == $subcapitulo_reto->cantidad_retos_terminados) {
            $passretouppopup =  1;
        } else {
            $passretouppopup =  0;
        }

        
        $pt_s = $retospts;
        //#####################################
       $count = DB::table('insigniacap')->where('capitulo', $cap)->count();
        if($count != 0){
             $rinsignia = $this->valinsig($cap, $userauthid); 
        }else{
             $rinsignia = "";
        }
        //########################################3
       //validar mensaje de finalizacion 
       $mensajefinal = $this->mensaje($cap, $userauthid); 

        //========== validar el numero de capitulo que sigue si este reto es el final =============
        if($subcapitulo_reto_tema->cantidad_retos_tema == $subcapitulo_reto->cantidad_retos_terminados){
            $validarSiguiente = 1;
            $capsiguiente = $cap + 1; //sumar un valor al capitulo
        }

        return view('player.finishquiz')->with('puntos_s', $pt_s)
                                        ->with('puntos_i', $i_point)
                                        ->with('puntos_g', $g_point)
                                        ->with('retos', $reto)
                                        ->with('subcapitulo', $reto->subchapter_id)
                                        ->with('leveluppopup', $leveluppopup)
                                        ->with('insigniapopup', $insigniapopup)
                                        ->with('insigniawon', $insigniawon)
                                        ->with('insignianamewon', $insignianamewon)
                                        ->with('insigniadescwon', $insigniadescwon)
                                        ->with('recompensapopup', $recompensapopup)
                                        ->with('passretouppopup', $passretouppopup)
                                        ->with('recompensawon', $recompensawon)
                                        ->with('cap', $cap)
                                        ->with('inscap', $rinsignia)
                                        ->with('mensaje', $mensajefinal)
                                        ->with('validarSiguiente', $validarSiguiente)
                                        ->with('capsiguiente', $capsiguiente)
                                        ->with('recompensanamewon', $recompensanamewon);
        }
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
        $request->usuario;
        $request->reto;
        $request->material;
        $request->evidencia;
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
