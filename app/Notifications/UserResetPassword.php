<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Services\MicrosoftGraphService;

class UserResetPassword extends Notification
{
    use Queueable;

    protected $token;

    /* para el servicio de envio de mensaje */
    protected $graphService;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        //
        $this->token = $token;
        $this->graphService = app(MicrosoftGraphService::class); // Obtener la instancia del servicio
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
          // URL de restablecimiento
          $resetUrl = url('/password/reset/' . $this->token);
          $content = view('mails.reset', [
                        'url' => $resetUrl
                    ])->render();
          // Enviar el correo usando el servicio graphService
          $this->graphService->sendMail(
              'Solicitud de Restablecimiento de Contraseña',
              $content,
              $notifiable->email
          );
        return null;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        
        return null; // Esto evita que Laravel intente enviar otro correo
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
