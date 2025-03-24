<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class sendVerificationAfterRegister extends Notification
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
            'subject_body' => 'Hallo, ' . $this->data['email'] . ' terima kasih sudah bergabung dengan kami',
            'greeting_email' => 'Silahkan aktivasi akun anda dengan menekan tombol dibawah ini. Dan mulailah menggunakan Al Lail App.',
            'button_text' => 'Aktivasi Akun',
            'foot_text' => 'Email aktivasi berlaku selama 10 menit.',
        ];
        return (new MailMessage)
            ->subject('Activation account')
            ->view('mails.register-success', ['data' => $email]);
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
