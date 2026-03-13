<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$user = DB::table('users')->first();

if ($user) {
    echo "Available Admin User:\n";
    echo "=====================\n";
    echo "ID: {$user->id}\n";
    echo "Name: {$user->name}\n";
    echo "Email: {$user->email}\n";
    echo "\nTry logging in with:\n";
    echo "Username/Email: {$user->email}\n";
    echo "Password: (check your setup or try 'admin123' or 'password')\n";
} else {
    echo "No users found!\n";
}
