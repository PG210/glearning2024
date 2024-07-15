<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Gift;

class AwardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $status="";
        
       // $reconocimientos = Gift::all();
        $reconocimientos = Gift::join('avatars', 'avatar_id', '=', 'avatars.id')
                         ->join('gruprecompensas', 'gifts.id_grupo', '=', 'gruprecompensas.id')
                         ->select('gifts.id', 'gifts.name',  'gifts.imagen', 'gifts.s_point', 
                          'gifts.i_point', 'gifts.g_point', 'gifts.description', 
                          'avatars.description as desavatar', 'avatars.sexo', 'nombre', 'tipo', 'descrip')
                         ->get();
        return view('admin.reconocimientos')->with('reconocimientos', $reconocimientos)
                                            ->with('status', $status);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $avatar = DB::table('avatars')->select('id', 'name')->get();
        return view('admin.RecompensasCreate')->with('avatars', $avatar);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status="";
        
        $rules = [
            'name' => 'required|unique:gifts|max:255',
            'spoints' => 'required',
            'ipoints' => 'required',
            'gpoints' => 'required',
            'descripcion' => 'required',
        ];         
        $messages = [
            'name.required' => 'Debes ingresar un Nombre para la Recompensa',
            'name.unique' => 'Esta Recompensa ya existe',
            'name.max' => 'El Nombre no puede exceder la cantidad de 255 caracteres',
            'spoints.required' => 'Ingresa un Puntaje S para continuar',
            'ipoints.required' => 'Ingresa un Puntaje I para continuar',
            'gpoints.required' => 'Ingresa un Puntaje G para continuar',
            'descripcion.required' => 'Ingresa una descripcion para la Recompensa',
        ];         
        $this->validate($request, $rules, $messages);

        //proceso guardar imagen de la insignia
        if ($request->hasFile('imagen')) {            
            $thefilename = $request->file('imagen')->getClientOriginalName();
            $pathfile = 'storage/'.$thefilename;
            $request->file('imagen')->storeAs('/', $thefilename);
        }else {
            $pathfile ="storage/default.png";
        }
        
        //
        $reconocimiento = new Gift;
        $reconocimiento->name = $request->name;
        $reconocimiento->imagen = $pathfile;
        $reconocimiento->s_point = $request->spoints;
        $reconocimiento->i_point = $request->ipoints;
        $reconocimiento->g_point = $request->gpoints;
        $reconocimiento->description = $request->descripcion;
        $reconocimiento->avatar_id = $request->avatarid; //esta linea se agrego
        $reconocimiento->save();
        
        $reconocimientos = Gift::all();
        return view('admin.reconocimientos')->with('reconocimientos', $reconocimientos)
                                            ->with('status', $status);
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
        
       // $recompensa = Gift::find($id);
        $recompensa = DB::table('gifts')->where('gifts.id', $id)
                       ->join('gruprecompensas', 'gifts.id_grupo', '=', 'gruprecompensas.id')
                       ->select('gifts.id', 'gifts.name', 'gifts.imagen', 'gifts.avatarchange', 's_point', 'i_point', 'g_point', 'description',
                          'avatar_id', 'id_grupo', 'nombre', 'tipo', 'descrip')
                       ->first();
         
         $grupo = DB::table('gruprecompensas')->get();
       
        return view('admin.reconocimientosEdit')->with('grup', $grupo)->with('recompensas', $recompensa);
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
        $status="";
        //obtener y guardar el archivo imagen (debe crearse un link a la carpeta storage=>public con php artisan storage:link)
        

        if ($request->hasFile('imagen')) {  
            //proceso guardar imagen de la insignia
            if ($request->hasFile('imagen')) {            
                $thefilename = $request->file('imagen')->getClientOriginalName();
                $pathfile = 'storage/'.$thefilename;
                $request->file('imagen')->storeAs('/', $thefilename);
            }else {
                $pathfile ="storage/default.png";
            }
        }else {                        
            $pathfile = $request->imagennoupdate;
        }
        
        //guaradar avatar
        if ($request->hasFile('avatar')) {            
            $ruta = $request->file('avatar')->getClientOriginalName();
            $rutavatar = 'storage/avatar2023/'.$ruta;
            $request->file('avatar')->storeAs('avatar2023/', $ruta);
        }
       //end guaradaravatar

        $reconocimiento = Gift::find($id);

        $reconocimiento->name = $request->name; 
        $reconocimiento->imagen = $pathfile;
        if($request->hasFile('avatar')){
          $reconocimiento->avatarchange = $rutavatar;
        }
        $reconocimiento->s_point = $request->spoints;
        $reconocimiento->i_point = $request->ipoints;
        $reconocimiento->g_point = $request->gpoints;
        $reconocimiento->description = $request->desc;
        $reconocimiento->id_grupo = $request->tipo;// se agrego este campo
        $reconocimiento->save();

        //$reconocimientos = Gift::all(); 
        $reconocimientos = Gift::join('avatars', 'avatar_id', '=', 'avatars.id')
                         ->join('gruprecompensas', 'gifts.id_grupo', '=', 'gruprecompensas.id')
                         ->select('gifts.id', 'gifts.name',  'gifts.imagen', 'gifts.s_point', 
                          'gifts.i_point', 'gifts.g_point', 'gifts.description', 
                          'avatars.description as desavatar', 'avatars.sexo', 'nombre', 'tipo', 'descrip')
                         ->get();
        return view('admin.reconocimientos')->with('reconocimientos', $reconocimientos)
                                    ->with('status', $status); 

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gift = Gift::find($id);
        
        $status="";
        $count=0;
        
        $count+=count($gift->users);
        
        if ($count>0) {
            $status = 'Recompensa esta relacionada, Imposible eliminar';
        } else {
            Gift::destroy($id);
            $status = 'Eliminado correctamente';
        }
                
        $reconocimientos = Gift::all();
        return view('admin.reconocimientos')->with('reconocimientos', $reconocimientos)
                                            ->with('status', $status);

    }
}
