<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TicketSubmitted extends Notification
{
    protected $ticket;

    public function __construct($ticket)
    {
        $this->ticket = $ticket;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Ticket Baru Masuk')
                    ->line('Ada tiket baru dari: ' . $this->ticket->contact_name)
                    ->line('Subjek: ' . $this->ticket->subject)
                    ->action('Lihat Tiket', url('/admin/tickets'))
                    ->line('Silakan ditindaklanjuti.');
    }
}
