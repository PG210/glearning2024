<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Notificacion extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $nombre;
    public $mensaje;

    public $cap;

    public function __construct($nombre, $cap, $mensaje)
    {
        $this->nombre = $nombre;
        $this->cap = $cap;
        $this->mensaje = $mensaje;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.notifi')
        ->with(['nombre' => $this->nombre, 'cap' => $this->cap, 'mensaje' => $this->mensaje]);
    }
}

