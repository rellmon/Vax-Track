<?php

return [
    'default' => env('QUEUE_CONNECTION', 'database'),

    'connections' => [
        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
            'after_commit' => false,
        ],

        'sync' => [
            'driver' => 'sync',
        ],
    ],

    'batches' => [
        'database' => [
            'driver' => 'database',
            'table' => 'job_batches',
        ],
    ],

    'failed' => [
        'database' => [
            'driver' => 'database',
            'table' => 'failed_jobs',
        ],
    ],
];
