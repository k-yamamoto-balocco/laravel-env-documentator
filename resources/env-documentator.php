<?php

declare(strict_types=1);

return [
    'default_key' => env('ENV_DOCUMENTATOR_DEFAULT_KEY'),
    'default_cipher' => 'AES-256-CBC',
    //各環境毎のkeyを設定する場合、以下に追記
    'keys' => [
        'staging' => 'base64:GxICYOKlvKIulZHv++NgCW5kHgoSwm4KfCx7PU9gfg4=',
    ],
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
    ],

    //メタ情報（自由に追加可能）
    'metadata' => [
        //このレベルに追加すると、表示時の列が1つ増える
        'description' => [
            'LOG_CHANNEL' => ''
        ],
        'type' => [
            'APP_NAME' => 'string',
            'APP_ENV' => 'string',
            'APP_DEBUG' => 'bool'
        ],
        'format' => [
            'APP_ENV' => 'production,staging,develop,testing',
            'LOG_CHANNEL' => 'https://readouble.com/laravel/8.x/ja/logging.html#available-channel-drivers'
        ],
    ],
];