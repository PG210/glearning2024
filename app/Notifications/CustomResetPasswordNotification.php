<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class CustomResetPasswordNotification extends Notification
{
    public $token;

    /**
     * Create a new notification instance.
     *
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Determine the delivery channels for the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail']; // Indica que el canal a utilizar es el correo
    }

    /**
     * Get the reset password notification mail representation.
     *
     * @param mixed $notifiable
     * @return void
     */
    public function toMail($notifiable)
    {
        // Generar la URL de restablecimiento de contraseña
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        // Renderizar el contenido del correo con la vista Blade
        $content = view('mails.reset', [
            'nombre' => $notifiable->name,
            'url' => $resetUrl
        ])->render();

        // Enviar el correo usando el servicio graphService
        $result = app('App\Services\GraphService')->sendMail(
            'Restablecer Contraseña',
            $content,
            $notifiable->email
        );

        if ($result['status'] !== 'success') {
            \Log::error('Error al enviar el correo de restablecimiento', ['error' => $result['message']]);
        }
    }
}
