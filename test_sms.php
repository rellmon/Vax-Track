<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$logs = \App\Models\SmsLog::latest()->take(5)->get();

echo "\n=== Recent SMS Logs ===\n";
foreach ($logs as $log) {
    echo sprintf(
        "ID: %d | Phone: %s | Status: %s | Error: %s\n",
        $log->id,
        $log->phone_number,
        $log->status,
        $log->error_message ?? 'none'
    );
}
echo "\n";
?>
