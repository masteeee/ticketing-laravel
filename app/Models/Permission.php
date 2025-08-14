<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name'];

    /**
     * Validation rules for the Permission model
     */
    public static function rules()
    {
        return [
            'name' => 'required|string|max:100|unique:permissions,name',
        ];
    }

    /**
     * Validation rules for updating a Permission
     */
    public static function updateRules($id)
    {
        return [
            'name' => 'required|string|max:100|unique:permissions,name,' . $id,
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }
} 