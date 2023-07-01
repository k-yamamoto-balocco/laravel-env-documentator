<?php

declare(strict_types=1);

return [
    //one-dimensional array of string.Each item must be deployment destination name.
    'destinations' => [
        'production',
        'staging',
        'develop',
        'testing'
    ],
    //encrypted .env file paths of each destination.
    'paths' => [
        'production' => '.env.production.encrypted',
        'staging' => '.env.staging.encrypted',
        'develop' => '.env.develop.encrypted',
        'testing' => '.env.testing.encrypted'
    ],
    'keys' => [
        'staging' => 'base64:XeBq7lovblPOI/7Xfnkhf0EnhFffSjNYNE37eLDI4cM=',
    ],
    'ciphers' => [
        'staging' => 'AES-256-CBC',
    ],

    //以下の項目は結果に表示しない。置換したい文字列を指定することも可能。デフォルトは ********
    'filters' => [
        'secrets' => [
            'APP_KEY' => '********',
            'DB_PASSWORD',
            'REDIS_PASSWORD',
            'MAIL_PASSWORD',
            'AWS_SECRET_ACCESS_KEY',
            'PUSHER_APP_SECRET',
        ]
    ]
];