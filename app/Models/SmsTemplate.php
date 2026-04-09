<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmsTemplate extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'message',
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
     * Get available variables for SMS templates
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
            'otp_code' => 'OTP code',
            'amount' => 'Payment amount',
        ];
    }
}
