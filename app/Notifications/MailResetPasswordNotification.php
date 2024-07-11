<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MailResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;
    public $email;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $email)
    {
        //
        $this->token = $token;
        $this->email = $email;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $link = url("reset-password/$this->token?email=$this->email" );

        return (new MailMessage)
                    ->greeting('Saludos')
                    ->subject('Restablecimiento de contraseña')
                    ->line('Estás recibiendo este correo electrónico porque recibimos una solicitud de restablecimiento de contraseña para tu cuenta.')
                    ->action('Restablecer contraseña', $link)
                    ->line('Este enlace caducará en ' . config('auth.passwords.users.expire') . ' minutos.')
                    ->line('Si no solicitó un restablecimiento de contraseña, no es necesario realizar ninguna otra acción.')
                    ->line('Por favor no responder a este correo.');
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
