<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Update username and reset password
$hashedPassword = Hash::make('admin123');

DB::table('users')->where('id', 1)->update([
    'username' => 'samsonclinic',
    'password' => $hashedPassword
]);

$user = DB::table('users')->find(1);

echo "Admin credentials updated!\n";
echo "==========================\n";
echo "Username: {$user->username}\n";
echo "Email: {$user->email}\n";
echo "Password: admin123 (hashed)\n";
echo "\nLogin credentials:\n";
echo "Username: samsonclinic\n";
echo "Password: admin123\n";
echo "Role: doctor\n";
