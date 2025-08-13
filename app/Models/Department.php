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

    /**
     * Validation rules for the Department model
     */
    public static function rules()
    {
        return [
            'name' => 'required|string|max:100|unique:departments,name',
            'description' => 'nullable|string',
            'logo_url' => 'nullable|url',
            'external_id' => 'nullable|string',
        ];
    }

    /**
     * Validation rules for updating a Department
     */
    public static function updateRules($id)
    {
        return [
            'name' => 'required|string|max:100|unique:departments,name,' . $id,
            'description' => 'nullable|string',
            'logo_url' => 'nullable|url',
            'external_id' => 'nullable|string',
        ];
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}