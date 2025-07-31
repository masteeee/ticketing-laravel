<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'description',
        'logo_url',
        'external_id',
    ]; 
    public function services()
{
    return $this->hasMany(Service::class);
}
}