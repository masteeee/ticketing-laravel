<?php

namespace App\Services;

use App\Models\User;
use App\Models\Notification;
use App\Models\Ticket;
use App\Mail\MentionNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MentionService
{
    /**
     * Parse mentions from message text
     * Format: @username or @name
     */
    public function parseMentions($message)
    {
        $mentions = [];
        preg_match_all('/@(\w+)/', $message, $matches);
        
        if (!empty($matches[1])) {
            foreach ($matches[1] as $username) {
                $user = User::where('name', 'LIKE', '%' . $username . '%')
                           ->orWhere('email', 'LIKE', '%' . $username . '%')
                           ->first();
                
                if ($user) {
                    $mentions[] = $user;
                }
            }
        }
        
        return $mentions;
    }

    /**
     * Create notifications for mentioned users
     */
    public function createMentionNotifications($message, $ticket, $conversation, $mentionedBy)
    {
        $mentions = $this->parseMentions($message);
        
        foreach ($mentions as $mentionedUser) {
            // Skip if mentioning yourself
            if ($mentionedUser->id === $mentionedBy->id) {
                continue;
            }
            
            // Create notification
            $notification = Notification::create([
                'type' => 'mention',
                'user_id' => $mentionedUser->id,
                'ticket_id' => $ticket->id,
                'conversation_id' => $conversation->id,
                'mentioned_by' => $mentionedBy->id,
                'message' => "Anda disebutkan oleh {$mentionedBy->name} dalam tiket #{$ticket->id}",
                'is_read' => false,
            ]);
            
            // Send email notification
            try {
                Mail::to($mentionedUser->email)->send(new MentionNotification(
                    $mentionedUser,
                    $mentionedBy,
                    $ticket,
                    $message
                ));
            } catch (\Exception $e) {
                Log::error('Failed to send mention notification email: ' . $e->getMessage());
            }
        }
        
        return $mentions;
    }

    /**
     * Get users for mention suggestions
     */
    public function getMentionSuggestions($query = '')
    {
        return User::where('name', 'LIKE', '%' . $query . '%')
                   ->orWhere('email', 'LIKE', '%' . $query . '%')
                   ->limit(10)
                   ->get(['id', 'name', 'email']);
    }
} 