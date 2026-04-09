<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VaccinationCoverageStat extends Model
{
    protected $table = 'vaccination_coverage_stats';
    
    protected $fillable = [
        'vaccine_id',
        'report_date',
        'target_population',
        'vaccinated_count',
        'coverage_percentage',
        'demographics',
    ];

    protected $casts = [
        'report_date' => 'date',
        'demographics' => 'array',
    ];

    public function vaccine(): BelongsTo
    {
        return $this->belongsTo(Vaccine::class);
    }

    public function scopeByVaccine($query, $vaccineId)
    {
        return $query->where('vaccine_id', $vaccineId);
    }

    public function scopeByDateRange($query, $from, $to)
    {
        return $query->whereBetween('report_date', [$from, $to]);
    }

    /**
     * Calculate overall coverage statistics
     */
    public static function getOverallCoverage($from = null, $to = null)
    {
        $query = self::query();
        
        if ($from && $to) {
            $query->byDateRange($from, $to);
        }
        
        $stats = $query->get();
        
        $totalPopulation = $stats->sum('target_population');
        $totalVaccinated = $stats->sum('vaccinated_count');
        
        return [
            'total_population' => $totalPopulation,
            'total_vaccinated' => $totalVaccinated,
            'coverage_percentage' => $totalPopulation > 0 ? ($totalVaccinated / $totalPopulation) * 100 : 0,
            'vaccine_count' => $stats->count(),
        ];
    }
}
