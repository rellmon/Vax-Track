<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduledReport extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'report_type',
        'frequency',
        'recipients',
        'filters',
        'next_run_date',
        'last_run_date',
        'active',
        'created_by_user_id',
    ];

    protected $casts = [
        'recipients' => 'array',
        'filters' => 'array',
        'next_run_date' => 'datetime',
        'last_run_date' => 'datetime',
        'active' => 'boolean',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('report_type', $type);
    }

    /**
     * Get reports due for execution
     */
    public static function getDueReports()
    {
        return self::active()
            ->where('next_run_date', '<=', now())
            ->get();
    }

    /**
     * Get frequency options
     */
    public static function getFrequencies()
    {
        return [
            'daily' => 'Daily',
            'weekly' => 'Weekly',
            'monthly' => 'Monthly',
            'quarterly' => 'Quarterly',
        ];
    }

    /**
     * Get report type options
     */
    public static function getReportTypes()
    {
        return [
            'financial' => 'Financial Report',
            'audit' => 'Audit Log Summary',
            'inventory' => 'Inventory Report',
            'coverage' => 'Vaccination Coverage',
            'vaccines' => 'Vaccine Statistics',
        ];
    }
}
