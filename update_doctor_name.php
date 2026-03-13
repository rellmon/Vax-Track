<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

$user = \App\Models\User::where('username', 'samsonclinic')->first();
if ($user) {
    $user->update(['name' => 'Dr. Samson Cruz']);
    echo "✅ Doctor name updated to: " . $user->name . "\n";
} else {
    echo "❌ User not found\n";
}
