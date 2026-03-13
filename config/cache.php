<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Cache Store
    |--------------------------------------------------------------------------
    |
    | This option controls the default cache store that will be used by the
    | framework when performing cache operations.
    |
    */

    'default' => env('CACHE_STORE', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Cache Key Prefix
    |--------------------------------------------------------------------------
    |
    | When utilizing the APC, database, memcached, Redis, or DynamoDB cache
    | stores there might be other applications utilizing the same cache. For
    | that reason, you may prefix every cache key in order to avoid collides.
    |
    */

    'prefix' => env('CACHE_PREFIX', 'laravel_cache_'),

    /*
    |--------------------------------------------------------------------------
    | Cache Stores
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the cache "stores" for your application as
    | well as their drivers. You may even define multiple stores for the
    | same driver. This is how you can group types of items to your stores.
    |
    | Drivers: "array", "database", "file", "memcached", "redis", "dynamodb"
    |
    */

    'stores' => [

        'database' => [
            'driver' => 'database',
            'connection' => null,
            'table' => 'cache',
        ],

    ],

];
