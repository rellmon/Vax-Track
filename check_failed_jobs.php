<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$db = $app->make('db');

$failed = $db->table('failed_jobs')->latest('id')->limit(1)->get();

foreach ($failed as $job) {
    echo "=== Latest Failed Job ===\n";
    echo "UUID: " . $job->uuid . "\n";
    echo "Queue: " . $job->queue . "\n";
    echo "Failed At: " . $job->failed_at . "\n";
    echo "\n=== Exception ===\n";
    echo $job->exception . "\n";
}

if ($failed->isEmpty()) {
    echo "No failed jobs found\n";
}
