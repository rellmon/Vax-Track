<?php
require "bootstrap/app.php";
$user = \App\Models\User::where("role", "doctor")->first();
\App\Models\SmsOtp::generateAndSend($user->email, "doctor", $user->id, "password_reset");
echo "Done";
