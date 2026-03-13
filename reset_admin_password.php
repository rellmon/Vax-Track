<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Reset password to "admin123" (hashed)
$hashedPassword = Hash::make('admin123');

DB::table('users')->where('id', 1)->update([
    'password' => $hashedPassword
]);

$user = DB::table('users')->find(1);

echo "Admin account credentials reset!\n";
echo "================================\n";
echo "Username: {$user->email}\n";
echo "Password: admin123 (newly hashed)\n";
echo "\nTry logging in now.\n";
echo "If it still doesn't work, check:\n";
echo "1. Make sure you're using the email field as username\n";
echo "2. Try without any extra spaces\n";
