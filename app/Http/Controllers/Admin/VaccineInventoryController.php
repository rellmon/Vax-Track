<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vaccine;
use App\Models\VaccineRecord;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VaccineInventoryController extends Controller
{
    /**
     * Display inventory dashboard
     */
    public function dashboard(Request $request)
    {
        $lowStockThreshold = $request->threshold ?? 10;

        // Core inventory stats
        $stats = [
            'total_vaccines' => Vaccine::count(),
            'active_vaccines' => Vaccine::where('active', true)->count(),
            'low_stock_count' => Vaccine::where('active', true)
                ->where('stock', '<', $lowStockThreshold)
                ->count(),
            'total_stock_value' => Vaccine::selectRaw('SUM(stock * price) as value')
                ->where('active', true)
                ->first()
                ->value ?? 0,
        ];

        // Low stock alerts
        $lowStockVaccines = Vaccine::where('active', true)
            ->where('stock', '<', $lowStockThreshold)
            ->orderBy('stock')
            ->get();

        // Out of stock
        $outOfStockVaccines = Vaccine::where('active', true)
            ->where('stock', '<=', 0)
            ->get();

        // All vaccines with usage statistics
        $thirtyDaysAgo = now()->subDays(30)->toDateTimeString();
        $sevenDaysAgo = now()->subDays(7)->toDateTimeString();
        
        $allVaccines = Vaccine::leftJoin('vaccine_records', 'vaccines.id', '=', 'vaccine_records.vaccine_id')
            ->selectRaw("vaccines.*")
            ->selectRaw("COALESCE(COUNT(vaccine_records.id), 0) as total_used")
            ->selectRaw("COALESCE(SUM(CASE WHEN vaccine_records.created_at >= '{$thirtyDaysAgo}' THEN 1 ELSE 0 END), 0) as used_30days")
            ->selectRaw("COALESCE(SUM(CASE WHEN vaccine_records.created_at >= '{$sevenDaysAgo}' THEN 1 ELSE 0 END), 0) as used_7days")
            ->groupBy('vaccines.id')
            ->orderBy('vaccines.name')
            ->get();

        // Top used vaccines (last 30 days)
        $topUsedVaccines = VaccineRecord::selectRaw('vaccine_id, vaccines.name, COUNT(*) as usage_count')
            ->join('vaccines', 'vaccine_records.vaccine_id', '=', 'vaccines.id')
            ->where('vaccine_records.created_at', '>=', now()->subDays(30))
            ->groupBy('vaccine_id', 'vaccines.name')
            ->orderByRaw('COUNT(*) DESC')
            ->limit(10)
            ->get();

        // Stock trend (last 30 days)
        $dateFormat = DB::connection()->getDriverName() === 'mysql' 
            ? "DATE_FORMAT(created_at, '%Y-%m-%d')" 
            : "strftime('%Y-%m-%d', created_at)";
        
        $stockTrend = VaccineRecord::selectRaw("$dateFormat as date, COUNT(*) as count")
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Vaccines by category
        $categories = Vaccine::selectRaw('type, COUNT(*) as count, SUM(stock) as total_stock')
            ->groupBy('type')
            ->get();

        // Cost analysis
        $costAnalysis = [
            'total_stock_cost' => Vaccine::selectRaw('SUM(stock * price) as total')
                ->where('active', true)
                ->first()
                ->total ?? 0,
            'usage_cost_30d' => VaccineRecord::selectRaw('SUM(vaccines.price) as total')
                ->join('vaccines', 'vaccine_records.vaccine_id', '=', 'vaccines.id')
                ->where('vaccine_records.created_at', '>=', now()->subDays(30))
                ->first()
                ->total ?? 0,
        ];

        return view('admin.vaccine-inventory.dashboard', compact(
            'stats',
            'lowStockVaccines',
            'outOfStockVaccines',
            'allVaccines',
            'topUsedVaccines',
            'stockTrend',
            'categories',
            'costAnalysis',
            'lowStockThreshold'
        ));
    }

    /**
     * Show vaccine details
     */
    public function show(Vaccine $vaccine)
    {
        $usage = VaccineRecord::where('vaccine_id', $vaccine->id)
            ->count();

        $recentUsage = VaccineRecord::where('vaccine_id', $vaccine->id)
            ->with('child')
            ->latest('created_at')
            ->limit(20)
            ->get();

        $pendingSchedules = Schedule::where('vaccine_id', $vaccine->id)
            ->where('status', 'Scheduled')
            ->count();

        return view('admin.vaccine-inventory.show', compact('vaccine', 'usage', 'recentUsage', 'pendingSchedules'));
    }

    /**
     * Update stock level
     */
    public function updateStock(Request $request, Vaccine $vaccine)
    {
        $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $oldStock = $vaccine->stock;
        $vaccine->update(['stock' => $request->stock]);

        return back()->with('success', "Stock updated from {$oldStock} to {$request->stock}");
    }

    /**
     * Alert for low stock
     */
    public function lowStockAlert(Request $request)
    {
        $threshold = $request->threshold ?? 10;

        $products = Vaccine::where('active', true)
            ->where('stock', '<', $threshold)
            ->orderBy('stock')
            ->get();

        return response()->json([
            'threshold' => $threshold,
            'alert_count' => $products->count(),
            'products' => $products->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'stock' => $p->stock,
                'price' => $p->price,
                'stock_value' => $p->stock * $p->price,
            ])
        ]);
    }

    /**
     * Get inventory report
     */
    public function inventoryReport(Request $request)
    {
        $thirtyDaysAgo = now()->subDays(30)->toDateTimeString();
        
        $vaccines = Vaccine::leftJoin('vaccine_records', 'vaccines.id', '=', 'vaccine_records.vaccine_id')
            ->selectRaw("vaccines.*")
            ->selectRaw("COALESCE(COUNT(vaccine_records.id), 0) as total_used")
            ->selectRaw("COALESCE(SUM(CASE WHEN vaccine_records.created_at >= '{$thirtyDaysAgo}' THEN 1 ELSE 0 END), 0) as used_30days")
            ->groupBy('vaccines.id')
            ->get();

        $csvHeader = "Vaccine ID,Name,Type,Manufacturer,Stock,Price,Stock Value,Total Used,Used (30 Days),Active\n";
        $csvData = '';

        foreach ($vaccines as $v) {
            $stockValue = $v->stock * $v->price;
            $active = $v->active ? 'Yes' : 'No';
            $csvData .= "\"{$v->id}\",\"{$v->name}\",\"{$v->type}\",\"{$v->manufacturer}\",\"{$v->stock}\",\"{$v->price}\",\"{$stockValue}\",\"{$v->total_used}\",\"{$v->used_30days}\",\"{$active}\"\n";
        }

        return response()
            ->streamDownload(
                function () use ($csvHeader, $csvData) {
                    echo $csvHeader . $csvData;
                },
                'vaccine-inventory-' . now()->format('Y-m-d-His') . '.csv'
            );
    }

    /**
     * Get inventory summary API
     */
    public function summary()
    {
        return response()->json([
            'total_vaccines' => Vaccine::count(),
            'active_vaccines' => Vaccine::where('active', true)->count(),
            'total_stock' => Vaccine::selectRaw('SUM(stock) as total')->where('active', true)->first()->total ?? 0,
            'low_stock' => Vaccine::where('active', true)->where('stock', '<', 10)->count(),
            'out_of_stock' => Vaccine::where('active', true)->where('stock', '<=', 0)->count(),
        ]);
    }
}
