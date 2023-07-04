<?php

declare(strict_types=1);

return [
    //必須
    'default_key' => env('ENV_DOCUMENTATOR_DEFAULT_KEY'),
    //必須
    'default_cipher' => 'AES-256-CBC',
    //必須 one-dimensional array of string.Each item must be deployment destination name.
    'destinations' => [
        'production',
        'staging',
        'develop',
        'testing'
    ],
    //任意 指定しない場合 .env.[destination name].encrypted となる encrypted .env file paths of each destination.
    'paths' => [
        'production' => '.env.production.encrypted',
        'staging' => '.env.staging.encrypted',
        'develop' => '.env.develop.encrypted',
        'testing' => '.env.testing.encrypted'
    ],
    //任意 各環境毎のkeyを設定する場合、以下に追記　指定しない場合、default_keyで復号される
    'keys' => [
        //例
        'production' => env('ENV_DOCUMENTATOR_PRODUCTION_KEY'),
        'staging' => env('ENV_DOCUMENTATOR_STAGING_KEY'),
        'develop' => env('ENV_DOCUMENTATOR_DEVELOP_KEY'),
        'testing' => env('ENV_DOCUMENTATOR_TESTING_KEY'),
    ],
    //任意 各環境毎のcipherを設定する場合、以下に追記　指定しない場合、default_cipherで復号される
    'ciphers' => [
        'staging' => 'AES-256-CBC',
    ],

    //以下の項目は結果に表示しない。置換したい文字列を指定することも可能。デフォルトは ********
    'filters' => [
        'secrets' => [
            'APP_KEY' => null,
            'DB_PASSWORD' => null,
            'REDIS_PASSWORD' => null,
            'MAIL_PASSWORD' => null,
            'AWS_SECRET_ACCESS_KEY' => null,
            'PUSHER_APP_SECRET' => null,
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