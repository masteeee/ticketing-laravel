<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TicketUserReplied extends Notification
{
    protected $ticket;
    protected $message;

    public function __construct($ticket, $message)
    {
        $this->ticket = $ticket;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Balasan Baru pada Tiket Anda')
            ->greeting('Halo, ' . $this->ticket->contact_name)
            ->line('Ada balasan baru dari admin/staff pada tiket Anda.')
            ->line('Kode INV: ' . $this->ticket->invoice_id)
            ->line('Isi balasan:')
            ->line($this->message)
            ->action('Lihat Tiket', url(route('ticket.public.detail', ['inv' => $this->ticket->invoice_id, 'email' => $this->ticket->email], false)))
            ->line('Silakan login ke halaman cek tiket untuk membalas atau melihat detail.');
    }
} 