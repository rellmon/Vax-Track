<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

// Simulate a doctor session
session(['doctor_id' => 1, 'doctor_name' => 'Dr. Samson Cruz']);

try {
    // Get a child and vaccine
    $child = \App\Models\Child::findOrFail(7);
    $vaccine = \App\Models\Vaccine::findOrFail(1);
    
    echo "Creating vaccine record for child: {$child->full_name}\n";
    echo "Vaccine: {$vaccine->name}\n";
    
    // Try to create a vaccine record
    $record = \App\Models\VaccineRecord::create([
        'child_id' => $child->id,
        'vaccine_id' => $vaccine->id,
        'date_given' => '2026-01-23',
        'dose_number' => 3,
        'notes' => 'Test record',
        'administered_by' => 'Dr. Achas',
    ]);
    
    echo "✅ Vaccine record created successfully!\n";
    echo "ID: " . $record->id . "\n";
    echo "Date Given: " . $record->date_given . "\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
