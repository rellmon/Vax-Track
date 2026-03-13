<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';

// Bootstrap Laravel
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Database Cleanup - Keeping Vaccines & Admin Account\n";
echo "===================================================\n\n";

try {
    // Find admin account (typically the first user or user with admin role)
    $adminUser = DB::table('users')->orderBy('id')->first();
    
    if (!$adminUser) {
        echo "ERROR: No admin user found!\n";
        exit(1);
    }
    
    echo "Preserving Admin User: {$adminUser->name} (ID: {$adminUser->id})\n";
    echo "Preserving All Vaccines\n\n";
    
    // Start deleting
    $deleted = [];
    
    // Delete SMS-related records
    $count = DB::table('sms_logs')->delete();
    echo "✓ Deleted $count SMS logs\n";
    $deleted['sms_logs'] = $count;
    
    $count = DB::table('sms_otps')->delete();
    echo "✓ Deleted $count SMS OTPs\n";
    $deleted['sms_otps'] = $count;
    
    // Delete payment records
    $count = DB::table('payments')->delete();
    echo "✓ Deleted $count payment records\n";
    $deleted['payments'] = $count;
    
    // Delete vaccine records (for children)
    $count = DB::table('vaccine_records')->delete();
    echo "✓ Deleted $count vaccine records\n";
    $deleted['vaccine_records'] = $count;
    
    // Delete schedules
    $count = DB::table('schedules')->delete();
    echo "✓ Deleted $count schedules\n";
    $deleted['schedules'] = $count;
    
    // Delete children
    $count = DB::table('children')->delete();
    echo "✓ Deleted $count children\n";
    $deleted['children'] = $count;
    
    // Delete parent guardians
    $count = DB::table('parent_guardians')->delete();
    echo "✓ Deleted $count parent guardians\n";
    $deleted['parent_guardians'] = $count;
    
    // Delete audit logs
    $count = DB::table('audit_logs')->delete();
    echo "✓ Deleted $count audit logs\n";
    $deleted['audit_logs'] = $count;
    
    // Delete users except admin
    $deletedUsers = DB::table('users')->where('id', '!=', $adminUser->id)->delete();
    echo "✓ Deleted $deletedUsers non-admin users\n";
    $deleted['users'] = $deletedUsers;
    
    // Verify preservations
    echo "\n" . str_repeat("=", 50) . "\n";
    echo "VERIFICATION:\n";
    echo "=============\n";
    
    $vaccineCount = DB::table('vaccines')->count();
    echo "✓ Vaccines preserved: $vaccineCount\n";
    
    $userCount = DB::table('users')->count();
    echo "✓ Admin users preserved: $userCount\n";
    
    $clinicCount = DB::table('clinic_settings')->count();
    echo "✓ Clinic settings preserved: $clinicCount\n";
    
    echo "\n" . str_repeat("=", 50) . "\n";
    echo "CLEANUP COMPLETE!\n";
    echo "=============\n";
    
    $totalDeleted = array_sum($deleted);
    echo "Total records deleted: $totalDeleted\n";
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
