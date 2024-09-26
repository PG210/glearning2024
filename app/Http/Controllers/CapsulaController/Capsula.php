<?php

namespace App\Http\Controllers\CapsulaController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

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

   

}
