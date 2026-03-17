<?php

return [

    'default' => env('BROADCAST_DRIVER', 'log'),

    'connections' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY', '1b21acbbff60be10bbd2'),
            'secret' => env('PUSHER_APP_SECRET', '94e6d63a1e0f77689478'),
            'app_id' => env('PUSHER_APP_ID', '2081791'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER', 'ap2'),
                'useTLS' => true,
            ],
        ],

        'ably' => [
            'driver' => 'ably',
            'key' => env('ABLY_KEY'),
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

];
