<?php

namespace App\Http\Controllers\Perfil;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Session;
use App\PosUsuModel\SubcapUser;//se agrego esta parte
use App\PosUsuModel\GrupadminModel;//se agrego esta parte
use App\Avatar;

class PerfilController extends Controller
{
    public function index(){
        $idusu=auth()->id();
        $usu = DB::table('users')->where('users.id', '=', $idusu)
              ->join('avatars', 'users.avatar_id', '=', 'avatars.id')
              ->select('users.id as userid', 'users.firstname', 'users.lastname', 'users.username', 'users.sexo', 'users.email', 'users.avatar_id', 
                       'avatars.id', 'avatars.name', 'avatars.description', 'avatars.img', 'users.cedula')
              ->get();
        $avatar=DB::table('avatars')->where('avatars.sexo', '=', 'Femenino')->get();
        $avatarm=DB::table('avatars')->where('avatars.sexo', '=', 'Masculino')->get();
        //return $usu;
        return view('perfilusu')->with('usu', $usu)->with('avatar', $avatar)->with('avatarm', $avatarm);
    }

    public function actu(Request $request, $id){
        $avat = DB::table('avatars')->where('id', $request->input('avat'))->select('img')->get();
        $p =  $request->input('pass');
        if($p!=null){
            $usuact =User::findOrfail($id);
            $usuact->firstname = $request->input('nombre');
            $usuact->lastname = $request->input('apellido');
            $usuact->sexo = $request->input('genero');
            $usuact->username = $request->input('usuario');
            $usuact->email = $request->input('email');
            $usuact->cedula = $request->input('ced');
            $usuact->avatar_id = $request->input('avat');
            $usuact->imgavat = $avat[0]->img; //guarda la direccion del avatar
            $usuact->password=Hash::make($p);
            $usuact->save();
            return redirect('/home');
        }else{
            $usuact =User::findOrfail($id);
            $usuact->firstname = $request->input('nombre');
            $usuact->lastname = $request->input('apellido');
            $usuact->sexo = $request->input('genero');
            $usuact->username = $request->input('usuario');
            $usuact->email = $request->input('email');
            $usuact->cedula = $request->input('ced');
            $usuact->avatar_id = $request->input('avat');
            $usuact->imgavat = $avat[0]->img; //guarda la direccion del avatar
            $usuact->save();
            return redirect('/home');
        }

    }
     
    // funcion para elegir el avatar
    public function saveCiborg($id){
       $avat = Avatar::where('id', $id)->first(); //buscar el avatar
       $idusu = auth()->id();
       $usuact =User::findOrfail($idusu);
       $usuact->sexo = $avat->sexo;
       $usuact->avatar_id = $avat->id;
       $usuact->imgavat = $avat->img; //guarda la direccion del avatar
       $usuact->save();
       return redirect('/home');
    }
 
     //actualizar desde el admin
    public function actuadmin($id){
        $usu = DB::table('users')->where('users.id', '=', $id)
              ->join('avatars', 'users.avatar_id', '=', 'avatars.id')
              ->join('grupos', 'users.id_grupo', '=', 'grupos.id')
              ->select('users.id as userid', 'users.firstname', 'users.lastname', 'users.username', 'users.sexo', 'users.email','users.admin', 'users.avatar_id', 
                       'avatars.id', 'avatars.name', 'avatars.description', 'avatars.img', 'grupos.descrip as grupo', 'users.id_grupo as idgrupo', 'users.cedula')
              ->get();
        $avatar=DB::table('avatars')->where('avatars.sexo', '=', 'Femenino')->get();
        $avatarm=DB::table('avatars')->where('avatars.sexo', '!=', 'Femenino')->get();
        $grupos =DB::table('grupos')->select('id as idgrup', 'descrip')->get();
        //Consultar si el usuario tiene agregado grupos
        $addgrupos = DB::table('grupadmin')->where('idusu', $id)->get();
        //return $usu;
        return view('admin.vistaperfil')->with('addgrupos', $addgrupos)->with('usu', $usu)->with('avatar', $avatar)->with('avatarm', $avatarm)->with('grupos', $grupos);
    }

    //actualizar perfil de usuario desde el admin
   public function actualizarusuadmin(Request $request, $id){

        $gr = $request->input('grupo');
        $gruposid = $request->idarchivo; //guarda los datos de check
        $avat = DB::table('avatars')->where('id', $request->input('avat'))->select('img')->get(); //consultar el avatar para sacar la dirccion

        $actu =User::findOrfail($id);
        $actu->firstname = $request->input('nombre');
        $actu->lastname = $request->input('apellido');
        $actu->sexo = $request->input('genero');
        $actu->username = $request->input('usuario');
        $actu->email = $request->input('email');
        $actu->avatar_id = $request->input('avat');
        $actu->admin = $request->input('rol');
        $actu->imgavat = $avat[0]->img;//direccion del avatar
        $actu->admin = $request->input('gruporol');
        if($request->passw != Null){
            $actu->password=Hash::make($request->passw);
        }
        $actu->cedula = $request->input('ced');
        //###################################
        if ($actu->id_grupo == $gr){
            $actu->id_grupo = $gr;
        }else{
            SubcapUser::where('user_id', $id)->delete();
            //validar que el grupo nuevo ya tenga capitulos asignados
            $capitulos = DB::table('subchapter_user')
                        ->join('users', 'subchapter_user.user_id', '=', 'users.id')
                        ->join('grupos', 'users.id_grupo', '=', 'grupos.id')
                        ->select('grupos.id as idgrup', 'grupos.descrip', 'subchapter_user.chapter_id')
                        ->where('grupos.id', $gr)
                        ->distinct('chapter_id')
                        ->get();
             if(!empty($capitulos)){
                foreach($capitulos as $c){
                        $AddCap = new SubcapUser();
                        $AddCap->order = $c->chapter_id; // este es el capitulo
                        $AddCap->chapter_id = $c->chapter_id;
                        $AddCap->subchapter_id = 1;
                        $AddCap->user_id = $id;
                        $AddCap->estado = 0;
                        $AddCap ->save();
                    }
                }
             $actu->id_grupo = $gr;
           }
        //#####################################
        $actu->save();
        //===================== guardar los grupos ====================
          if(!is_null($gruposid)){
            DB::table('grupadmin')->where('idusu', $id)->delete();
            foreach ($gruposid as $valor){
                $ver = DB::table('grupadmin')->where('idusu', $id)->where('idgrupo', $valor)->count();
                if($ver == 0){
                    $Add = new GrupadminModel();
                    $Add->idusu = $id;
                    $Add->idgrupo = $valor;
                    $Add->save();
                }
               
              }
          }
        //======================================================
        Session::flash('datreg', 'Usuario actualizado exitosamente!');
        return back();
   }
  //#####################################################
    //funcion que lleva a perfil
   public function perfilhomedos(){
        $idusu=auth()->id();
        $usu = DB::table('users')->where('users.id', '=', $idusu)
            ->join('avatars', 'users.avatar_id', '=', 'avatars.id')
            ->select('users.id as userid', 'users.firstname', 'users.lastname', 'users.username', 'users.sexo', 'users.cedula', 'users.email', 'users.avatar_id', 
                    'avatars.id', 'avatars.name', 'avatars.description', 'avatars.img')
            ->get();
        $avatar=DB::table('avatars')->where('avatars.sexo', '=', 'Femenino')->get();
        $avatarm=DB::table('avatars')->where('avatars.sexo', '=', 'Masculino')->get();
        //return $usu;
        return view('grupos.perfilusu')->with('usu', $usu)->with('avatar', $avatar)->with('avatarm', $avatarm);
    }
  //#####################################################
  //deshabilitar usuarios
   public function deshabilitar($id){
    $user = User::find($id);
    if($user->estado == 1){
        $user->estado = 0;
    }else{
        $user->estado = 1;
    }
    $user->save();
    return back();
   }
   //#########################
    public function detinsignia($id){
       if (Auth::check()) {
       $usu =  Auth::user()->id;
       $val = DB::table('insigcap_user')->where('insigcap_user.insigid', $id)->where('insigcap_user.userid', $usu)->count();
       if( $val != 0){
         $info = DB::table('insigcap_user')
                ->join('users', 'insigcap_user.userid', '=', 'users.id')
                ->join('insigniacap', 'insigcap_user.insigid', '=', 'insigniacap.id')
                ->where('insigcap_user.insigid', $id)
                ->where('insigcap_user.userid', $usu)
                ->select('insigcap_user.id', 'insigcap_user.insigid as idinsig',
                     'users.firstname as usuname', 'users.lastname as usuape', 'users.cedula', 'insigniacap.nombre as name', 
                     'insigniacap.url as imagen', 'insigniacap.descripcion as description', 'insigcap_user.created_at', 'insigniacap.horas')
           ->get();
          
           return view('grupos.vistains')->with('info', $info);
        }else{
           return redirect('https://glearning.com.co/');
       }
     }else{
        return redirect('https://glearning.com.co/');
     }
   }
   //aqui validarla inignia que viene desde la vista de recompensas

   public function insigniaVisu($id){
    $val = DB::table('insigcap_user')->where('insigcap_user.id', $id)->count();
    if($val != 0){
    $info = DB::table('insigcap_user')
           ->join('users', 'insigcap_user.userid', '=', 'users.id')
           ->join('insigniacap', 'insigcap_user.insigid', '=', 'insigniacap.id')
           ->where('insigcap_user.id', $id)
           ->select('insigcap_user.id', 'insigcap_user.insigid as idinsig',
                     'users.firstname as usuname', 'users.lastname as usuape', 'users.cedula', 'insigniacap.nombre as name', 
                     'insigniacap.url as imagen', 'insigniacap.descripcion as description', 'insigcap_user.created_at', 'insigniacap.horas')
           ->get();
           //return $info;
     return view('grupos.vistains')->with('info', $info);
     }else{
       return redirect('https://glearning.com.co/login');
     }
   }
//######################################################################
    public function vistamaterial(){
    $user=auth()->id();
    $tTareas = DB::table('challenges')
                ->join('subchapters', 'challenges.subchapter_id', '=', 'subchapters.id')
                ->selectRaw('subchapters.chapter_id as cap, COUNT(challenges.id) as tareas')
                ->groupBy('subchapters.chapter_id')
                ->get();
    $tareasuser = DB::table('challenge_user')
                ->join('challenges', 'challenge_user.challenge_id', '=', 'challenges.id')
                ->join('subchapters', 'challenges.subchapter_id', '=', 'subchapters.id')
                ->join('chapters', 'subchapters.chapter_id', '=', 'chapters.id')
                ->where('challenge_user.user_id', $user)
                ->selectRaw('challenge_user.user_id as idusu, subchapters.chapter_id, COUNT(challenge_user.challenge_id) as valor, chapters.name, chapters.title')
                ->groupBy('challenge_user.user_id', 'subchapters.chapter_id', 'chapters.name', 'chapters.title')
                ->get();
      if(isset($tareasuser) && count($tareasuser) == 0){
            $buscar = [];
            $al = [];
            $niveles =[];
      }else{
          foreach($tTareas as $t1){
            $conta = 0;
            foreach($tareasuser as $t2){
            if($t1->cap == $t2->chapter_id){
                $sum = $t1->tareas - $t2->valor;
                $conta = $conta+1;
                $item = [
                'usuario' => $t2->idusu,
                'capitulo' => $t2->chapter_id,
                'nombre' => $t2->name,
                'titulo' => $t2->title,
                'tcom' => $t2->valor,
                'tfaltan' => $sum,
                'ttotal' => $t1->tareas,
                'nivel' => $conta
                ];
                $al[] = $item;
               }
            }
         }
        $niveles = collect($al)->groupBy('usuario')->map(function ($items) {
                return count($items);
             });
     }
    
    return view('grupos.vistamat')->with('ninfo', $al);
   }

//=================== funcion para vista e registrar avatars
public function regavatar(){
     $avatar = DB::table('avatars')->get();
     return view('admin.viewavatar')->with('avatar', $avatar);
   }

public function actuAvatar(Request $request){
   // nombre genero descrip idusu avat
   if ($request->hasFile('avat')) {  
        $file = $request->file('avat');//guarda la variable id en un file
        $nameruta = $file->getClientOriginalName();
        //$limpiarnombre = str_replace(array("#",".",";"," "), '', $name);
        //$val = $limpiarnombre.".".$file->guessExtension();//renombra el archivo subido
        $ruta = public_path("storage/avatar2023/".$nameruta);//ruta para guardar el archivo pdf/ es la carpeta
        copy($file, $ruta);
    }
     $Act = Avatar::findOrFail($request->idusu);
     $Act->name = $request->nombre; 
     $Act->description = $request->descrip;
     $Act->sexo = $request->genero;
     if ($request->hasFile('avat')) { 
        $Act->img = "storage/avatar2023/".$nameruta;
     }
     $Act->save();
     return back();
   }

//##############################################
}






