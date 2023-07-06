<?php

declare(strict_types=1);

return [
    /**
     * default_key:必須。.envを暗号化したときのキーを指定する。
     * パッケージが復号処理を行う際のデフォルト値として利用される。
     * @see \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DefaultKeyValidator::definition()
     */
    'default_key' => env('ENV_DOCUMENTATOR_DEFAULT_KEY'),

    /**
     * default_cipher:必須。.envを暗号化したときの暗号化方式を指定する。
     * パッケージが復号処理を行う際のデフォルト値として利用される。
     * @see \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DefaultCipherValidator::definition()
     * @see \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\CipherValidator::definition()
     */
    'default_cipher' => 'aes-256-cbc',

    /**
     * destinations:必須。このアプリケーションのデプロイ先名称を配列として定義する。
     * required. One dimensional array of string. Each item must be deployment destination name.
     * @see \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DestinationValidator::definition()
     */
    'destinations' => [
        'production',
        'staging',
        'develop',
        'testing'
    ],
    /**
     * paths:任意。各デプロイ先名称ごとの、暗号化された.envファイルのパスを設定する。
     * 指定しない場合、デフォルト値は ".env.[DestinationName].encrypted" となる。
     * optional.
     * encrypted .env file paths of each destination.
     * @see \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\PathsValidator::definition()
     */
    'paths' => [
        //'production' => '.env.production.encrypted',
        //'staging' => '.env.staging.encrypted',
        //'develop' => '.env.develop.encrypted',
        //'testing' => '.env.testing.encrypted'
    ],
    /**
     * keys:任意。各デプロイ先名称ごとの、.envを暗号化したときのキーを指定する。
     * この項目で指定しない場合、default_keyで復号される。
     * @see \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\KeysValidator::definition()
     */
    'keys' => [
        //'production' => env('ENV_DOCUMENTATOR_PRODUCTION_KEY'),
        //'staging' => env('ENV_DOCUMENTATOR_STAGING_KEY'),
        //'develop' => env('ENV_DOCUMENTATOR_DEVELOP_KEY'),
        //'testing' => env('ENV_DOCUMENTATOR_TESTING_KEY'),
    ],
    /**
     * ciphers:任意。各デプロイ先名称ごとの、.envを暗号化したときの暗号化方式を指定する。
     * この項目で指定されていない項目はdefault_cipherで復号される
     * @see \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\CipherValidator::definition()
     */
    'ciphers' => [
        'staging' => 'aes-256-cbc',
    ],

    //結果表示時に、値に対して適用されるフィルタの設定。
    'filters' => [
        /**
         * secret filter
         * コマンド実行結果に表示しない項目を設定する。
         * keyは非表示項目名、valueは置換文字列。
         * valueがnullの場合、******** に置換される。
         * @see \GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\SecretFilter::__invoke()
         */
        'secrets' => [
            'APP_KEY' => null,
            'DB_PASSWORD' => null,
            'REDIS_PASSWORD' => null,
            'MAIL_PASSWORD' => null,
            'AWS_SECRET_ACCESS_KEY' => null,
            'PUSHER_APP_SECRET' => null,
        ]
    ],

    //結果表示時に、.envファイルの情報に加えて表示するメタ情報。基本的に自由に追加可能。
    //metadata 以下に追加した項目については、m オプションで指定することで結果に出力することができる。
    //複数指定したい場合は , 区切り
    //php artisan env:documentator -m description,type,format
    'metadata' => [
        //以下に、キー名
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