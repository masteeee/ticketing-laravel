<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TicketUserSubmitted extends Notification
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
            ->subject('Tiket Anda Berhasil Dikirim')
            ->greeting('Halo, ' . $this->ticket->contact_name)
            ->line('Tiket Anda telah berhasil dikirim.')
            ->line('Kode INV: ' . $this->ticket->invoice_id)
            ->line('Simpan kode ini untuk cek status dan balasan dari admin.')
            ->line('Cara cek status:')
            ->line('1. Klik tombol "View Ticket" di navbar website.')
            ->line('2. Masukkan kode INV dan email Anda.')
            ->action('Cek Tiket', url(route('ticket.view.form', [], false)))
            ->line('Terima kasih telah menggunakan layanan kami.');
    }
} 