<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\NotyModel;
use App\User;
use App\Jobs\SendMailJob;

class EnviarRecordatorios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recordatorios:enviar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar correo de recordatorios';

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
         //mensajes de tipo 1 son de recordatorio a ingresar a la plataforma
         $mensajes = NotyModel::where('activo', 1)->where('tipo', 1)
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

        if (!$mensajes) return;

        $subject = "Notificación de ausencia";
        \Log::info("Enviando mensaje de ausencia: {$mensajes}");
        
        // Aquí se debe vincular la logica desde cuando quiere que envie el correo
        $usuarios = User::select('firstname', 'lastname', 'admin', 'email', 'estado')->where('admin', 0)->where('estado', 1)->whereDate('last_login', '<=', now()->subDays($mensajes->tiempo))->get();
        
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
