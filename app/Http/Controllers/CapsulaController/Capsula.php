<?php

namespace App\Http\Controllers\CapsulaController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Models\CapsulaModel;

//prueba de correo
use App\Services\MicrosoftGraphService;
use App\Models\Token;
use App\Jobs\SendMailJob; // Importa el job


class Capsula extends Controller
{

    protected $graphService;

    public function __construct(MicrosoftGraphService $graphService)
    {
        $this->graphService = $graphService;
    }

    private function sendMail($destino, $data, $descrip, $valor)
    {
        // Renderiza la vista Blade con el contenido HTML
        $content = view('mails.avance', [
            'datos' => $data, // valores para la vista de correo
            'val' => $valor
        ])->render();

        // Despacha el job a la cola
        SendMailJob::dispatch($descrip, $content, $destino);
        return true; // Puedes ajustar la respuesta según necesites
    }

    public function capsula($param1){
        $idlog = auth()->user()->id; //usuario logeado
        //$param1 = $request->query('data');
        $user = User::findOrFail($idlog);
        $valor = $param1;
        return response()->json(['valor' => $valor, 'user' => $user], 200);
    }

    //subir archivo de capsula
    public function formularioZip(){
        $rutas = CapsulaModel::all();
        return view('admin.archivo')->with('rutas', $rutas);
    }
   
    public function subirFile(Request $request)
    {
        if ($request->hasFile('uploadedfile')) {
            $category = new CapsulaModel();
            $file = $request->file('uploadedfile');
            
            // Obtiene el nombre original y lo limpia
            $name = $file->getClientOriginalName();
            $limpiarnombre = str_replace(['#', '.', ';', ' '], '', $name);
            $val = $limpiarnombre . "." . $file->guessExtension();
            
            // Define la ruta de destino para el archivo zip
            $ruta = public_path("capsulas/" . $val);
            
            // Guarda el archivo zip en la ruta especificada
            $file->move(public_path("capsulas"), $val);
            
            // Ruta de la carpeta donde se descomprimirá el archivo
            $rutaDescompresion = public_path("capsulas/" . $limpiarnombre);
            
            // Crea la carpeta de destino si no existe
            if (!file_exists($rutaDescompresion)) {
                mkdir($rutaDescompresion, 0755, true);
            }
            
            // Descomprime el archivo
            $zip = new \ZipArchive();
            if ($zip->open($ruta) === TRUE) {
                $zip->extractTo($rutaDescompresion);
                $zip->close();
                
                // Borra el archivo .zip después de descomprimir
                unlink($ruta);
            } else {
                return back()->withErrors(['msg' => 'No se pudo descomprimir el archivo.']);
            }
            
            // Guarda los datos en la base de datos
            $category->descripcion = $request->input('descrip');
            $category->ruta = $limpiarnombre; // Puedes guardar la ruta o el nombre del directorio descomprimido
            $category->save();
        }
        
        return back()->with('success', 'Archivo subido y descomprimido correctamente.');
    }
    

}
