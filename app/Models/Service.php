<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Service extends Model
{
    protected $fillable = [
        'name',
        'department_id',
        'description',
    ];

    /**
     * Validation rules for the Service model
     */
    public static function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'department_id' => 'required|exists:departments,id',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Validation rules for creating a Service with unique name per department
     */
    public static function createRules($departmentId)
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('services')->where(function ($query) use ($departmentId) {
                    return $query->where('department_id', $departmentId);
                })
            ],
            'department_id' => 'required|exists:departments,id',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Validation rules for updating a Service with unique name per department
     */
    public static function updateRules($id, $departmentId)
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('services')->where(function ($query) use ($departmentId) {
                    return $query->where('department_id', $departmentId);
                })->ignore($id)
            ],
            'department_id' => 'required|exists:departments,id',
            'description' => 'nullable|string',
        ];
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
