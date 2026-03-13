<?php
require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;

$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Recent 10 SMS Records:\n";
echo str_repeat("=", 100) . "\n";

$recentSms = DB::table('sms_logs')
    ->orderBy('updated_at', 'desc')
    ->limit(10)
    ->get(['id', 'phone_number', 'status', 'message', 'error_message', 'updated_at']);

foreach ($recentSms as $sms) {
    echo sprintf(
        "ID: %4d | Status: %-8s | Phone: %s | Updated: %s\n",
        $sms->id,
        $sms->status,
        $sms->phone_number,
        $sms->updated_at
    );
    if ($sms->error_message) {
        echo "         ERROR: " . $sms->error_message . "\n";
    }
}

echo "\n" . str_repeat("=", 100) . "\n";
echo "SMS Status Summary:\n";

$statusSummary = DB::table('sms_logs')
    ->selectRaw('status, COUNT(*) as count')
    ->where('updated_at', '>=', now()->subDay())
    ->groupBy('status')
    ->get();

foreach ($statusSummary as $row) {
    echo "  " . ucfirst($row->status) . ": " . $row->count . "\n";
}
