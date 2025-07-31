<?php

// app/Models/Ticket.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'department_id',
        'contact_name',
        'service_id',
        'email',
        'phone',
        'subject',
        'description',
        'customer_email',
        'invoice_id',
        'attachment',
        'status',
        'handled_by',
    ];

        public function department()
        {
            return $this->belongsTo(Department::class);
        }
        public function conversations()
        {
            return $this->hasMany(TicketConversation::class);
        }
        public function handler()
        {
         return $this->belongsTo(User::class, 'handled_by');
        }
        public function service()
        {
            return $this->belongsTo(Service::class);
        }
        public function assigned()
        {
         return $this->belongsTo(User::class, 'assigned_to');
        }
}
