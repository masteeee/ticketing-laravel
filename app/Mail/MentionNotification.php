<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Ticket;

class MentionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $mentionedUser;
    public $mentionedBy;
    public $ticket;
    public $conversationMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(User $mentionedUser, User $mentionedBy, Ticket $ticket, $conversationMessage)
    {
        $this->mentionedUser = $mentionedUser;
        $this->mentionedBy = $mentionedBy;
        $this->ticket = $ticket;
        $this->conversationMessage = $conversationMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Anda disebutkan dalam tiket #' . $this->ticket->id,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.mention-notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
