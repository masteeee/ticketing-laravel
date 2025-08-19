<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];

    /**
     * Validation rules for the Role model
     */
    public static function rules()
    {
        return [
            'name' => 'required|string|max:50|unique:roles,name',
        ];
    }

    /**
     * Validation rules for updating a Role
     */
    public static function updateRules($id)
    {
        return [
            'name' => 'required|string|max:50|unique:roles,name,' . $id,
        ];
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }
} 