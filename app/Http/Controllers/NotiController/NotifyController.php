<?php

namespace App\Http\Controllers\NotiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotyModel;

class NotifyController extends Controller
{
    public function index(){
      $data = NotyModel::all();
      $opciones = [
          1 => 'Inactividad en la plataforma',
          2 => 'Uso de la plataforma',
          3 => 'Notificación para votar',
      ];

      $frecuencia = [5, 7, 15, 20, 30];

      $diasemana = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
    ];
      return view('admin.notify', compact('data', 'opciones', 'frecuencia', 'diasemana'));
    }

    //registrar
    public function recordatorio(Request $request){
        try{
            $mensaje = new NotyModel();
            $mensaje->tipo = $request->tipo;
            $mensaje->tiempo = $request->tem;
            $mensaje->dia = $request->dia;
            $mensaje->hora = $request->hora;
            $mensaje->contenido = $request->contenido;
            $mensaje->save();
    
            return back()->with('success', 'Mensaje guardado correctamente.');
    
        }catch(\Exception $e){
    
          return back()->with('error', 'Hubo un problema al guardar el mensaje.');
    
        }
    
      }

    //borrar mensaje
      // borrar mensajes
  public function deleteMensaje(Request $request){
    
    $mensaje = NotyModel::find($request->idmen);
    if ($mensaje) {
        $mensaje->delete();
        return back()->with('success', 'Mensaje eliminado correctamente.');
    }
    return back()->with('error', 'Hubo un problema al eliminar el mensaje.');
  }

    //activar o desacivar mensajes
  public function activeMensaje(Request $request){
        #== actualizar estado
        $mensaje = NotyModel::find($request->id);
        if ($mensaje) {
           $mensaje->activo = $request->estado;
           $mensaje->save();
   
           return response()->json(['message' => 'Estado actualizado correctamente.']);
       }
   
       return response()->json(['message' => 'No se encontró la notificación.'], 404);
  }

  //update recordatorio
  public function upRecordatorio(Request $request){

    $mensaje = NotyModel::find($request->idup);
    if ($mensaje) {
        $mensaje->tipo = $request->tipoup;
        $mensaje->tiempo = $request->temup;
        $mensaje->dia = $request->diaup;
        $mensaje->hora = $request->horaup;
        $mensaje->contenido = $request->contenidoup;
        $mensaje->save();

        return back()->with('success', 'Mensaje actualizado correctamente.');
    }
    
    return back()->with('error', 'Hubo un problema al actualizar el mensaje.');

  }


}
