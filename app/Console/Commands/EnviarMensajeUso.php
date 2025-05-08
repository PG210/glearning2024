<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\NotyModel;
use App\User;
use App\Jobs\SendMailJob;
use DB;
class EnviarMensajeUso extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mensaje:uso';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $hoy = now()->dayOfWeekIso; // 1 para lunes, 2 para martes, etc.
        $horaActual = now()->format('H:i'); // Ej: 14:30
        $fecha = now(); //fecha completa

        //$horaInicio = now()->subMinutes(2)->format('H:i');
        //$horaFin = now()->addMinutes(2)->format('H:i');

        //mensajes de tipo 2 son de recordatorio a reconocer en plataforma
        $mensajes = NotyModel::where('activo', 1)->where('tipo', 2)
           ->where('dia', $hoy)
           ->where(function ($query) use ($fecha) {
               $query->whereNull('ultimoenvio') // Nunca se ha enviado
                     ->orWhereRaw(
                         "DATEDIFF(?, ultimoenvio) >= tiempo", [$fecha] // Se han cumplido los días desde el último envío
                     );
           })
           ->whereRaw("LEFT(hora, 5) = ?", [$horaActual])
           ->inRandomOrder()
           ->first();
       
           \Log::info("Enviando mensaje de recordatorio: {$mensajes}");

            $subject = "Mensaje de recordatorio";
           
            if (!$mensajes) 
                return;

            // Aquí se debe vincular la logica desde cuando quiere que envie el correo
            $usuarios = User::select('firstname', 'lastname', 'admin', 'email', 'estado')->where('admin', 0)->where('estado', 1)->get();

            foreach ($usuarios as $usuario) {

                $content = view('mails.mensaje', ['datos' => $mensajes, 'usuario' => $usuario, 'subject' => $subject])->render();
                 // Mostrar en consola
                $this->info("Enviando mensaje a: {$usuario->email}");
                SendMailJob::dispatch($subject, $content, $usuario->email);
                
            }

            // Guardar la nueva fecha de envío
            $mensajes->ultimoenvio = $fecha;
            $mensajes->save();
    }
}
