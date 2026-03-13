<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$db = $app['db'];

$count = $db->table('schedules')->count();
echo "Total schedules: $count\n";

$latest = $db->table('schedules')->latest('id')->first();
if ($latest) {
    echo "Latest schedule ID: {$latest->id}, Date: {$latest->appointment_date}\n";
    
    $child = $db->table('children')->find($latest->child_id);
    $vaccine = $db->table('vaccines')->find($latest->vaccine_id);
    echo "Child: {$child->first_name} {$child->last_name}\n";
    echo "Vaccine: {$vaccine->name}\n";
}
