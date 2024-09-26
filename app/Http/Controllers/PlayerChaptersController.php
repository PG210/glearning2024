<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subchapter;
use App\Chapter;
use App\Challenge;
use App\User;
use DB;
use Auth;

class PlayerChaptersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userauthid = Auth::user()->id;            
        
        $capitulos = DB::select("call chapterSecuence($userauthid)");

        // return response()->json($arraymostrar);
        return response()->json($capitulos);
        return view('home');
    }

    public function pasarchapter($id)
    {
        // ====================== PUNTAJES S EN CAPITULOS vs SUBCAPITULOS ==========================
        //cantidad puntos maximos de un capitulo
        $chapter = 100;

        //cantidad de subcapitulos en el capitulo actual
        $subchapters = DB::table('subchapters')->where('chapter_id', $id)->count();
        
        if ($subchapters != 0) {            
            $points = $chapter / $subchapters;
        }else {
            $points = 0;
        }

        //cantidad puntos para subcapitulos

        //asignar y actualizar puntos a cada subcapitulo del capitulo elegido
        $updatepts = Subchapter::where('chapter_id', $id)->update(['s_point' => $points]);

        //volver a la vista presentando los subcapitulos del capitulo
        $capitulos = Chapter::find($id);
        return view('player.capitulos')->with('capitulos', $capitulos);
    }

    //FUNCION INVOCADA AL SELECCIONAR UN SUBCAPITULO 
    public function pasarchallenge(Request $request, $id)
    {
        /*Capturar las variables para validar si es el capitulo final */
        $validarSiguiente = 0;// validar el estado del capitulo siguiente
       
        $userauthid = Auth::user()->id;
    
        //obtener subcapitulos con el chapter_id del subcapitulo
        $subcapitulos = Subchapter::where('id', $id)->first();
        $capitulos = Chapter::find($subcapitulos->chapter_id);

        //obtener retos del subcapitulo por parametro
        $retos = Challenge::where('subchapter_id', $id)
                            ->where('gametype', 1)->get();
        
        //===== obtiene los retos del subcapitulos SIN JUGAR
        $retospending = DB::table('challenges as i')
                        ->select('i.*')
                        ->leftJoin('challenge_user as q', function ($join) use($userauthid) {
                            $join->on('q.challenge_id', '=', 'i.id')
                                    ->where('q.user_id', '=', $userauthid);
                        })
                        ->where('i.subchapter_id', '=', $id)
                        ->whereNull('q.challenge_id')
                        ->first();
                        // dd($retospending);
       $retospendientes = $retospending;
       $retp = $retospending; 
       
               
        //==== Retos que YA HAN SIDO jugados
        $retosfinish = DB::table('challenge_user')
                        ->join('challenges', 'challenge_user.challenge_id', '=', 'challenges.id')
                        ->where('challenge_user.user_id', '=', $userauthid)
                        ->where('challenges.subchapter_id', '=', $id)
                        ->get();
                        
        $videohidden = "hidden";
         //calcular los retos pendientes
           $tareasusu = DB::table('challenge_user')
                    ->join('challenges', 'challenge_user.challenge_id', '=', 'challenges.id')
                    ->join('subchapters', 'challenges.subchapter_id', '=', 'subchapters.id')
                    ->where('subchapters.chapter_id', $capitulos->id)
                    ->where('challenge_user.user_id', '=', $userauthid)
                    ->selectRaw('subchapters.chapter_id as cap, challenges.id as idt, challenges.name')
                    ->get();
           //return $tareasusu->count(); //total de tareas echas
           $tareacap = DB::table('challenges')
                    ->join('subchapters', 'challenges.subchapter_id', '=', 'subchapters.id')
                    ->where('subchapters.chapter_id', $capitulos->id)
                    ->selectRaw('subchapters.chapter_id as cap, challenges.id as idt, challenges.name')
                    ->get();
           // return $tareacap->count(); //total de tareas por capitulo

        $v = $subcapitulos->name;
             //fin retos pendientes
        $cap = $capitulos->id;
        $capsiguiente = $cap; //controlar los capitulos que aumenten siempre y cuando no sobre pase los asignados

        //total de tareas pendientes
        $tareaspendientes = $tareacap->count() - $tareasusu->count();

         //obtener el grado de capitulo mas alto asignado
         $capmax = DB::table('subchapter_user')->where('user_id', $userauthid)->max('chapter_id');
         
        if($tareaspendientes == 0 && $capsiguiente < $capmax){
            $capsiguiente = $cap + 1;
        }
      
        return view('player.capitulos')->with('retos', $retos)
                                        ->with('capitulos', $capitulos)
                                        ->with('subcapitulos', $subcapitulos)
                                        ->with('retospendientes', $retospendientes)
                                        ->with('retosfinish', $retosfinish)
                                        ->with('videohidden', $videohidden)
                                        ->with('tareasusu', $tareasusu)
                                        ->with('retp', $retp)
                                        ->with('v', $v)
                                        ->with('cap', $cap)
                                        ->with('capsiguiente', $capsiguiente)
                                        ->with('tareaspendientes', $tareaspendientes)
                                        ->with('tareacap', $tareacap);
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
