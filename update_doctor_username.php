<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

// Update the doctor user account
$user = \App\Models\User::where('username', 'samsomclinic')->first();

if ($user) {
    $user->update([
        'name' => 'Dr. Samson Clinic',
        'username' => 'samsonclinic',
        'email' => 'doctor@samsonclinic.ph',
    ]);
    echo "✅ Doctor account updated successfully!\n";
    echo "   Name: " . $user->name . "\n";
    echo "   Username: " . $user->username . "\n";
    echo "   Email: " . $user->email . "\n";
} else {
    echo "❌ Doctor account not found with username 'samsomclinic'\n";
    echo "Checking for any users:\n";
    \App\Models\User::all()->each(function ($u) {
        echo "  - " . $u->username . " (role: " . $u->role . ")\n";
    });
}
