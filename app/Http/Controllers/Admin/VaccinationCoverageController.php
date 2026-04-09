<?php

namespace App\Http\Controllers\Admin;

use App\Models\VaccinationCoverageStat;
use App\Models\Vaccine;
use App\Models\VaccineRecord;
use App\Models\Child;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VaccinationCoverageController
{
    /**
     * Coverage dashboard
     */
    public function dashboard(Request $request)
    {
        $from = $request->query('from', now()->subMonths(1)->format('Y-m-d'));
        $to = $request->query('to', now()->format('Y-m-d'));

        $overallCoverage = VaccinationCoverageStat::getOverallCoverage($from, $to);
        $vaccineCoverage = $this->getVaccineCoverageData($from, $to);
        $ageGroupCoverage = $this->getAgeGroupCoverage($from, $to);

        return view('admin.vaccination-coverage.dashboard', [
            'from' => $from,
            'to' => $to,
            'overallCoverage' => $overallCoverage,
            'vaccineCoverage' => $vaccineCoverage,
            'ageGroupCoverage' => $ageGroupCoverage,
        ]);
    }

    /**
     * Get per-vaccine coverage data
     */
    private function getVaccineCoverageData($from, $to)
    {
        return VaccinationCoverageStat::whereBetween('report_date', [$from, $to])
            ->with('vaccine')
            ->selectRaw('vaccine_id, 
                        SUM(target_population) as total_target,
                        SUM(vaccinated_count) as total_vaccinated,
                        AVG(coverage_percentage) as avg_coverage')
            ->groupBy('vaccine_id')
            ->orderByDesc('total_vaccinated')
            ->get();
    }

    /**
     * Get age group coverage statistics
     */
    private function getAgeGroupCoverage($from, $to)
    {
        $children = Child::all();
        $records = VaccineRecord::whereBetween('date_given', [$from, $to])->get();

        $groups = [
            '0-6m' => ['min' => 0, 'max' => 6, 'total' => 0, 'vaccinated' => 0],
            '6m-1y' => ['min' => 6, 'max' => 12, 'total' => 0, 'vaccinated' => 0],
            '1-2y' => ['min' => 12, 'max' => 24, 'total' => 0, 'vaccinated' => 0],
            '2-5y' => ['min' => 24, 'max' => 60, 'total' => 0, 'vaccinated' => 0],
            '5+y' => ['min' => 60, 'max' => 999, 'total' => 0, 'vaccinated' => 0],
        ];

        foreach ($children as $child) {
            $ageMonths = $child->dob ? now()->diffInMonths($child->dob) : 0;
            
            foreach ($groups as $key => $group) {
                if ($ageMonths >= $group['min'] && $ageMonths < $group['max']) {
                    $groups[$key]['total']++;
                    
                    $vaccinated = $records->where('child_id', $child->id)->count() > 0;
                    if ($vaccinated) {
                        $groups[$key]['vaccinated']++;
                    }
                }
            }
        }

        return collect($groups)->map(fn($g) => [
            'group' => $g,
            'coverage' => $g['total'] > 0 ? ($g['vaccinated'] / $g['total']) * 100 : 0,
        ]);
    }

    /**
     * Detailed vaccine report
     */
    public function vaccine(Request $request, Vaccine $vaccine)
    {
        $from = $request->query('from', now()->subMonths(3)->format('Y-m-d'));
        $to = $request->query('to', now()->format('Y-m-d'));

        $stats = VaccinationCoverageStat::byVaccine($vaccine->id)
            ->byDateRange($from, $to)
            ->orderBy('report_date')
            ->get();

        $records = VaccineRecord::where('vaccine_id', $vaccine->id)
            ->whereBetween('date_given', [$from, $to])
            ->with('child')
            ->paginate(50);

        return view('admin.vaccination-coverage.vaccine', [
            'vaccine' => $vaccine,
            'from' => $from,
            'to' => $to,
            'stats' => $stats,
            'records' => $records,
        ]);
    }

    /**
     * Public health report
     */
    public function publicHealth(Request $request)
    {
        $from = $request->query('from', now()->subMonths(12)->format('Y-m-d'));
        $to = $request->query('to', now()->format('Y-m-d'));

        $vaccines = Vaccine::active()->get();
        $coverageData = [];

        foreach ($vaccines as $vaccine) {
            $stats = VaccinationCoverageStat::byVaccine($vaccine->id)
                ->byDateRange($from, $to)
                ->selectRaw('SUM(target_population) as target, SUM(vaccinated_count) as vaccinated')
                ->first();

            if ($stats && $stats->target > 0) {
                $coverageData[] = [
                    'vaccine' => $vaccine->name,
                    'target' => $stats->target,
                    'vaccinated' => $stats->vaccinated,
                    'coverage' => ($stats->vaccinated / $stats->target) * 100,
                ];
            }
        }

        return view('admin.vaccination-coverage.public-health', [
            'from' => $from,
            'to' => $to,
            'coverageData' => $coverageData,
        ]);
    }

    /**
     * Export coverage report
     */
    public function export(Request $request)
    {
        $from = $request->query('from', now()->subMonths(1)->format('Y-m-d'));
        $to = $request->query('to', now()->format('Y-m-d'));

        $data = VaccinationCoverageStat::whereBetween('report_date', [$from, $to])
            ->with('vaccine')
            ->orderBy('report_date')
            ->get();

        $csv = "Report Date,Vaccine,Target Population,Vaccinated Count,Coverage %\n";
        foreach ($data as $stat) {
            $csv .= "{$stat->report_date},{$stat->vaccine->name},{$stat->target_population},"
                . "{$stat->vaccinated_count},{$stat->coverage_percentage}\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="vaccination-coverage-' . now()->format('Y-m-d') . '.csv"');
    }

    /**
     * API: Get coverage summary
     */
    public function summary()
    {
        $overallCoverage = VaccinationCoverageStat::getOverallCoverage();
        
        return response()->json($overallCoverage);
    }
}
