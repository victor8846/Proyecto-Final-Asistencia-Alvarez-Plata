<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserCredentials extends Notification
{
    use Queueable;

    private $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Bienvenido al Sistema de Control INCOS - Credenciales de Acceso')
            ->view('vendor.notifications.email-credentials', [
                'name' => $notifiable->name,
                'email' => $notifiable->email,
                'password' => $this->password,
                'url' => url('/login')
            ]);
    }
}
