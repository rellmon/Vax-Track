<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicSetting extends Model
{
    protected $table = 'clinic_settings';

    protected $fillable = [
        'clinic_name',
        'phone',
        'email',
        'address',
        'city',
        'province',
        'postal_code',
        'timezone',
        'operating_hours',
        'consultation_fee',
        'vaccine_service_fee',
        'bank_details',
        'website',
        'facebook_url',
        'emergency_phone',
        'description',
        'logo_url',
    ];

    protected $casts = [
        'operating_hours' => 'array',
    ];

    /**
     * Get single clinic setting by key
     */
    public static function getSetting($key, $default = null)
    {
        $setting = self::first();
        return $setting ? ($setting[$key] ?? $default) : $default;
    }

    /**
     * Update or create clinic settings
     */
    public static function updateSettings(array $data)
    {
        $setting = self::first() ?? new self();
        $setting->fill($data);
        $setting->save();
        return $setting;
    }

    /**
     * Check if clinic is open on given day/time
     */
    public function isOpenAt($dayOfWeek, $time)
    {
        $hours = $this->operating_hours;
        $dayName = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][$dayOfWeek];
        
        if (!isset($hours[$dayName])) {
            return false;
        }

        $dayHours = $hours[$dayName];
        if (!$dayHours['is_open']) {
            return false;
        }

        $open = strtotime($dayHours['open_time']);
        $close = strtotime($dayHours['close_time']);
        $checkTime = strtotime($time);

        return $checkTime >= $open && $checkTime <= $close;
    }
}
