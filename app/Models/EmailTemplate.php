<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTemplate extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'subject',
        'body',
        'variables',
        'type',
        'active',
    ];

    protected $casts = [
        'variables' => 'array',
        'active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get all available variable placeholders
     */
    public static function getAvailableVariables()
    {
        return [
            'child_name' => 'Child name',
            'parent_name' => 'Parent/Guardian name',
            'vaccine_name' => 'Vaccine name',
            'appointment_date' => 'Appointment date',
            'appointment_time' => 'Appointment time',
            'clinic_name' => 'Clinic name',
            'clinic_phone' => 'Clinic phone',
            'clinic_address' => 'Clinic address',
            'amount' => 'Payment amount',
            'balance' => 'Outstanding balance',
        ];
    }
}
