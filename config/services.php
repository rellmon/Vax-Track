<?php

return [
    'philsms' => [
        'api_token' => env('PHIL_SMS_API_TOKEN', 'dev-token'),
        'sender_name' => env('PHIL_SMS_SENDER_NAME', 'VaccTrack'),
    ],
];
