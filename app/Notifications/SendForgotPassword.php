<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendForgotPassword extends Notification
{
    use Queueable;
    protected $data;
    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $email = [
            'email' => $this->data['email'],
            'token' => $this->data['token'],
            'subject_body' => 'Hallo, ' . $this->data['email'] . ' berikut link untuk reset password anda',
            'greeting_email' => 'Seseorang telah meminta untuk mereset kata sandi untuk akun Anda. Klik tombol di bawah ini untuk mereset kata sandi Anda. Jika Anda tidak meminta reset kata sandi, abaikan email ini.',
            'button_text' => 'Reset Password',
            'foot_text' => 'Email ini berlaku selama 10 menit. Jika Anda tidak mereset kata sandi Anda, abaikan email ini.',
        ];
        return (new MailMessage)
            ->subject('Password reset request')
            ->view('mails.forgot-password', ['data' => $email]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
