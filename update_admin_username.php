<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

// Update the admin user email to samsoncruz
DB::table('users')->where('id', 1)->update([
    'email' => 'samsoncruz'
]);

$user = DB::table('users')->find(1);

echo "Admin account updated!\n";
echo "=====================\n";
echo "Email/Username: {$user->email}\n";
echo "Name: {$user->name}\n";
echo "\nYou can now login with:\n";
echo "Username: samsoncruz\n";
echo "Password: admin123\n";
