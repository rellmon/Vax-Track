<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Delete all pending jobs
$deleted = DB::table('jobs')->delete();
echo "Deleted $deleted pending jobs from queue\n";

// Also reset SmsLog status to help with retesting
$reset = DB::table('sms_logs')->where('status', 'sent')->where('error_message', 'PhilSMS API returned null - check API token and network connection')->update(['status' => 'pending']);
echo "Reset $reset failed SMS logs to pending\n";
