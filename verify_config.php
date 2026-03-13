<?php
echo "=== DATABASE & CONFIGURATION VERIFICATION ===\n\n";

// Check .env
echo ".ENV CONFIGURATION:\n";
$envPath = "database/database.sqlite";
echo "✓ Database path: $envPath\n";
echo "✓ Database file exists: " . (file_exists($envPath) ? "YES" : "NO") . "\n";

if (file_exists($envPath)) {
    try {
        $db = new PDO("sqlite:$envPath");
        $result = $db->query("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name");
        $tables = $result->fetchAll(PDO::FETCH_COLUMN);
        echo "✓ Total tables: " . count($tables) . "\n\n";
        
        echo "DATABASE TABLES:\n";
        foreach ($tables as $table) {
            echo "  - $table\n";
        }
        
        // Check specific tables for data
        echo "\n=== DATA RECORDS ===\n";
        $checkTables = ['users', 'parent_guardians', 'children', 'vaccines', 'audit_logs', 'clinic_settings'];
        foreach ($checkTables as $tbl) {
            if (in_array($tbl, $tables)) {
                $count = $db->query("SELECT COUNT(*) FROM $tbl")->fetchColumn();
                echo "$tbl: $count records\n";
            }
        }
        
    } catch (Exception $e) {
        echo "✗ Database error: " . $e->getMessage() . "\n";
    }
} else {
    echo "✗ Database file not found at: " . realpath($envPath) . "\n";
}

echo "\n=== EMAIL CONFIGURATION ===\n";
echo "MAIL_MAILER: " . (getenv('MAIL_MAILER') ?: "NOT SET") . "\n";
echo "MAIL_HOST: " . (getenv('MAIL_HOST') ?: "NOT SET") . "\n";
echo "MAIL_USERNAME: " . (getenv('MAIL_USERNAME') ? "SET" : "NOT SET") . "\n";
echo "MAIL_PASSWORD: " . (getenv('MAIL_PASSWORD') ? "SET" : "NOT SET") . "\n";
echo "MAIL_FROM_NAME: " . (getenv('MAIL_FROM_NAME') ?: "NOT SET") . "\n";

echo "\n=== QUEUE CONFIGURATION ===\n";
echo "QUEUE_CONNECTION: " . (getenv('QUEUE_CONNECTION') ?: "NOT SET") . "\n";

echo "\n=== SESSION CONFIGURATION ===\n";
echo "SESSION_DRIVER: " . (getenv('SESSION_DRIVER') ?: "NOT SET") . "\n";
echo "SESSION_LIFETIME: " . (getenv('SESSION_LIFETIME') ?: "NOT SET") . " minutes\n";

echo "\n=== VERIFICATION COMPLETE ===\n";
