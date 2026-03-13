<?php
echo "=== VACCTRACK SYSTEM PHASE VERIFICATION ===\n\n";

// Check Phase I
echo "PHASE I - SECURITY & COMPLIANCE:\n";
echo "✓ Auditable Trait: " . (file_exists("app/Traits/Auditable.php") ? "EXISTS" : "MISSING") . "\n";
echo "✓ AuditLog Model: " . (file_exists("app/Models/AuditLog.php") ? "EXISTS" : "MISSING") . "\n";

// Check models have traits  
$models = ["Child", "VaccineRecord", "Schedule", "Payment", "Vaccine"];
foreach ($models as $model) {
    $file = "app/Models/$model.php";
    $content = file_exists($file) ? file_get_contents($file) : "";
    $hasAuditable = strpos($content, "Auditable") !== false;
    $hasSoftDeletes = strpos($content, "SoftDeletes") !== false;
    echo "  - $model: Auditable=" . ($hasAuditable ? "✓" : "✗") . " SoftDeletes=" . ($hasSoftDeletes ? "✓" : "✗") . "\n";
}

echo "\nPHASE II - EMAIL DELIVERY:\n";
echo "✓ PasswordResetOtp Mailable: " . (file_exists("app/Mail/PasswordResetOtp.php") ? "EXISTS" : "MISSING") . "\n";
echo "✓ Email template: " . (file_exists("resources/views/emails/password-reset-otp.blade.php") ? "EXISTS" : "MISSING") . "\n";

echo "\nPHASE III - 6 ADVANCED FEATURES:\n";
echo "1. SMS Queue: " . (file_exists("app/Jobs/SendSmsJob.php") ? "EXISTS" : "MISSING") . "\n";
echo "2. Welcome Emails: " . (file_exists("app/Mail/ParentWelcome.php") ? "EXISTS" : "MISSING") . "\n";
echo "3. Appointment Reminders: " . (file_exists("app/Console/Commands/SendAppointmentReminders.php") ? "EXISTS" : "MISSING") . "\n";
echo "4. Clinic Settings: " . (file_exists("app/Models/ClinicSetting.php") ? "EXISTS" : "MISSING") . "\n";
echo "5. Dashboard: " . (file_exists("app/Http/Controllers/DoctorController.php") ? "EXISTS" : "MISSING") . "\n";
echo "6. REST API: " . (file_exists("app/Http/Controllers/Api/ApiController.php") ? "EXISTS" : "MISSING") . "\n";

echo "\n=== DATABASE TABLES ===\n";
try {
    $db = new PDO('sqlite:database.sqlite');
    $result = $db->query("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name");
    $tables = $result->fetchAll(PDO::FETCH_COLUMN);
    echo "Total tables: " . count($tables) . "\n";
    foreach ($tables as $table) {
        echo "  - $table\n";
    }
} catch (Exception $e) {
    echo "Database check failed: " . $e->getMessage() . "\n";
}

echo "\n=== VERIFICATION COMPLETE ===\n";
