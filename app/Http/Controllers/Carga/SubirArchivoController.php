<?php

namespace App\Http\Controllers\Carga;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Session\SessionManager;
use App\Archivos\Cargarchivo;


use App\User;
use App\Position;
use App\Area;
use DB;
use App\AreaPModel\AreaPos;
use App\PosUsuModel\PosUsu;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\PosUsuModel\SubcapUser;//se agrego esta parte
use App\PosUsuModel\GruposModel;

class SubirArchivoController extends Controller
{
    //

    public function index(Request $request, SessionManager $sessionManager){

      
        //$request->file('archivo')->store('public');
        //dd("subido y guardado");

            if($request->hasFile('uploadedfile')){
                
                $category = new Cargarchivo();
               
                $file = $request->file('uploadedfile');//guarda la variable id en un file
                $name = $file->getClientOriginalName();
                $limpiarnombre = str_replace(array("#",".",";"," "), '', $name);
                $val = $limpiarnombre.".".$file->guessExtension();//renombra el archivo subido
                $ruta = public_path("csv/".$val);//ruta para guardar el archivo pdf/ es la carpeta

                
                if($file->guessExtension()=="txt"){
                  
                 copy($file, $ruta);
                 $category->descripcion = $request->input('nombre');
                 $category->ruta = $val;//ingresa el nombre de la ruta a la base de datos
                 $category->save();//guarda los datos
                    //$lines = file($rut);
                    //$utf= array_map('utf8_encode', $lines);
                    //$array =array_map('str_getcsv', $utf);


                    //$sessionManager->flash('mensaje', '');
                    return redirect()->route('cargamasiva')->with('mensaje', 'Archivo cargado con exito');
                }
             
                else{
                    return redirect()->route('cargamasiva')->with('mensaje', 'Archivo no fue cargado');
                }
              
        }
    }

    public function cargar(){
      // $rut = public_path('csv/usuarioscsv.txt');
      // $lines = file($rut);
       //$utf= array_map('utf8_encode', $lines);
        //$array = array_map('str_getcsv', $utf); //datos normalizados
       
           // $msj='';
            $listado = Cargarchivo::all();
                return view('admin.lista_archivos', compact('listado'));
            
        
    }
   
   //registrar los usuarios de la carga masiva
   public function registrar($file_name){
    $rut = public_path('csv/' . $file_name);
    $lines = file($rut);

    $utf = array_map('utf8_encode', $lines);
    $array = array_map('str_getcsv', $utf);

    // Validar que el documento esté completo
    $tam = sizeof($array);

    if ($tam <= 1) {
        $msj = "Lo sentimos! El archivo debe tener todos los campos completos o verifique que este delimitado por comas.";
        return back()->with('mensaje', $msj);
    }
      for ($k = 1; $k < $tam; ++$k) {
        if (count($array[$k]) < 11) {
            $msj = "Lo sentimos! El archivo debe tener todos los campos completos o verifique que este delimitado por comas.";
            return back()->with('mensaje', $msj);
        }
    }

    $usuariosExistentes = [];
    $usuariosFaltantes = [];
    //====================
    DB::transaction(function () use ($array, &$usuariosExistentes) {
        for ($i = 1; $i < sizeof($array); ++$i) {
           $usern = strtolower($array[$i][6]);
           $userem = strtolower($array[$i][2]);
           $idgrupo = $array[$i][10];
           $idavat = $array[$i][9];
             // validar que los campos esten completos
    if (empty($array[$i][0]) || empty($array[$i][1]) || empty($array[$i][2]) || empty($array[$i][3]) || empty($array[$i][4]) || empty($array[$i][5])  || empty($array[$i][6]) || empty($array[$i][7]) || empty($array[$i][8]) || empty($array[$i][9]) || empty($array[$i][10]) || empty($array[$i][11])) 
              {
                $usuariosExistentes[] = [
                    'email' => $userem ." " ."Usuario no registrado, revisar los campos",
                ];
                continue; // Saltar a la siguiente fila si alguno de los campos requeridos está vacío
            }
       // validar el grupo si existe 
            $grupo = GruposModel::where('id', $idgrupo)->count();
            $avatar = DB::table('avatars')->where('id', $idavat)->count();
            if ($grupo == 0 || $avatar == 0) 
              {
                $usuariosExistentes[] = [
                    'email' => $userem ." " ."Usuario no registrado, revisar el grupo o avatar",
                ];
                continue; // Saltar a la siguiente fila si alguno de los campos requeridos está vacío
            }
            $userExists = User::where('username', $usern)->orWhere('email', $userem)->exists();
          if ($userExists) {
                $usuariosExistentes[] = [
                    'email' => $userem,
                ];
            } else {
                $category = new User();
                $category->firstname = $array[$i][0];
                $category->lastname = $array[$i][1];
                $category->avatar_id = $array[$i][9];
                $category->sexo = $array[$i][3];
                $category->username = $usern;
                $category->email = $userem;
                $category->cedula = $array[$i][11];
                $category->id_grupo = is_numeric($array[$i][10]) ? $array[$i][10] : 1;
                $category->password = Hash::make($array[$i][7]);
                $category->save();

                // Registrar los datos en la tabla área
                $ev = "Evolucion";
                $area = Area::where('name', $ev)->first();
                $position = Position::where('name', $ev)->first();
                $category->areas()->attach($area->id);
                $category->positions()->attach($position->id);
            }
        }
    }); 
    $msj = "¡Usuarios Registrados Éxitosamente!";
    if (!empty($usuariosExistentes)) {
        $msj .= " Algunos usuarios ya existían en la base de datos: ";
     }
  
     return back()->with('mensaje', $msj)->with('usuariosExistentes', $usuariosExistentes)->with('usuariosFaltantes', $usuariosFaltantes);
   }
   //end registro

  public function eliminar($id){
    //$category = new Cargarchivo();
    $elim = Cargarchivo::findOrfail($id);
    $nom=$elim->ruta;
    $elim->delete();
    $msj="¡Archivo Eliminado: ".$nom.", Eliminado con exito!";
    return back()->with('mensaje',$msj);
  }
       

}
