<?php
require 'bootstrap/app.php';
$user = App\Models\User::where('role', 'doctor')->first();
if ($user) {
    App\Models\SmsOtp::generateAndSend($user->email, 'doctor', $user->id, 'password_reset');
    echo 'Test done';
} else {
    echo 'No doctor user found';
}
