<?php

// app/Models/Ticket.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'department_id',
        'contact_name',
        'service_name',
        'email',
        'phone',
        'subject',
        'description',
        'customer_email',
        'invoice_id',
        'attachment',
    ];
}
