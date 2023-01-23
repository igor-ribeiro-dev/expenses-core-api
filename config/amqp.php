<?php

return [
    'default' => env('AMQP_CONNECTION', 'rabbitmq'),
    'connections' => [
        'rabbitmq' => [
            'host' => env('AMQP_HOST', 'localhost'),
            'port' => env('AMQP_PORT', 5672),
            'user' => env('AMQP_USER', 'guest'),
            'password' => env('AMQP_PASSWORD', 'guest'),
        ]
    ]
];