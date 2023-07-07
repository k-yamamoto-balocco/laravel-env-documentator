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
        //'staging' => 'aes-256-cbc',
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
            //secret in default .env.example
            'APP_KEY' => null,
            'DB_PASSWORD' => null,
            'REDIS_PASSWORD' => null,
            'MAIL_PASSWORD' => null,
            'AWS_SECRET_ACCESS_KEY' => null,
            'PUSHER_APP_SECRET' => null,
            //setting item for this package
            'ENV_DOCUMENTATOR_DEFAULT_KEY' => null,
        ]
    ],

    //結果表示時に、.envファイルの情報に加えて表示するメタ情報。基本的に自由に追加可能。
    //metadata 以下に追加した項目については、m オプションで指定することで結果に出力することができる。
    //複数指定したい場合は , 区切り
    //php artisan env:documentator -m description,type,format
    'metadata' => [
        //各設定項目についての簡単な説明
        'description' => [
            //APP
            'APP_NAME' => 'アプリケーション名',
            'APP_ENV' => 'デプロイ環境名(production,staging,develop,testing)',
            'APP_KEY' => 'https://readouble.com/laravel/9.x/ja/encryption.html',
            'APP_DEBUG' => 'https://readouble.com/laravel/9.x/ja/configuration.html#debug-mode',
            'APP_URL' => 'アプリケーションURL',
            //LOG
            'LOG_CHANNEL' => 'https://readouble.com/laravel/9.x/ja/logging.html#available-channel-drivers',
            'LOG_DEPRECATIONS_CHANNEL' => 'https://readouble.com/laravel/9.x/ja/logging.html#logging-deprecation-warnings',
            'LOG_LEVEL' => 'https://readouble.com/laravel/9.x/ja/logging.html#log-levels',
            //DATABASE
            'DB_CONNECTION' => 'php artisan tinker --execute="dd(array_keys(config(\"database.connections\")));"',
            'DB_HOST' => 'Ip address,hostname,FQDN of database server.',
            'DB_PORT' => 'データベースのポート番号',
            'DB_DATABASE' => 'データベース名',
            'DB_USERNAME' => 'データベースユーザ名',
            'DB_PASSWORD' => 'DB_USERNAMEのパスワード',
            //DRIVERS
            "BROADCAST_DRIVER" => "https://readouble.com/laravel/9.x/ja/broadcasting.html",
            "CACHE_DRIVER" => "https://readouble.com/laravel/9.x/ja/cache.html",
            "FILESYSTEM_DISK" => "https://readouble.com/laravel/9.x/ja/filesystem.html",
            "QUEUE_CONNECTION" => "https://readouble.com/laravel/9.x/ja/queues.html",
            "SESSION_DRIVER" => "https://readouble.com/laravel/9.x/ja/session.html",
            "SESSION_LIFETIME" => "セッション有効期限（分）",
            //MEMCACHED
            "MEMCACHED_HOST" => "Ip address,hostname,FQDN of MEMCACHED server.",
            //REDIS
            "REDIS_HOST" => "Ip address,hostname,FQDN of REDIS server.",
            "REDIS_PASSWORD" => "redisサーバのパスワード",
            "REDIS_PORT" => "redisサーバのポート番号（6379）",
            //MAIL
            "MAIL_MAILER" => "https://readouble.com/laravel/9.x/ja/mail.html",
            "MAIL_HOST" => "",
            "MAIL_PORT" => "smtpサーバのポート番号（587,2525）",
            "MAIL_USERNAME" => "smtpサーバのユーザ名",
            "MAIL_PASSWORD" => "MAIL_USERNAMEのパスワード",
            "MAIL_ENCRYPTION" => "暗号化方式",
            "MAIL_FROM_ADDRESS" => "差出人メールアドレス",
            "MAIL_FROM_NAME" => "差出人名",
            //AWS
            'AWS_ACCESS_KEY_ID' => 'https://docs.aws.amazon.com/ja_jp/sdk-for-php/v3/developer-guide/guide_credentials_environment.html',
            'AWS_SECRET_ACCESS_KEY' => 'https://docs.aws.amazon.com/ja_jp/sdk-for-php/v3/developer-guide/guide_credentials_environment.html',
            'AWS_DEFAULT_REGION' => 'https://readouble.com/laravel/9.x/ja/filesystem.html#s3-driver-configuration',
            'AWS_BUCKET' => 'S3バケット名',
            'AWS_USE_PATH_STYLE_ENDPOINT' => '(true/false)',
            //PUSHER
            'PUSHER_APP_ID' => '',
            'PUSHER_APP_KEY' => '',
            'PUSHER_APP_SECRET' => '',
            'PUSHER_HOST' => '',
            'PUSHER_PORT' => '',
            'PUSHER_SCHEME' => '',
            'PUSHER_APP_CLUSTER' => '',
            //VITE
            'VITE_PUSHER_APP_KEY' => '',
            'VITE_PUSHER_HOST' => '',
            'VITE_PUSHER_PORT' => '',
            'VITE_PUSHER_SCHEME' => '',
            'VITE_PUSHER_APP_CLUSTER' => '',
        ],
        //Laravel インストール時点で.env.exampleに用意されている項目であるか
        'laravels' => [
            //APP
            'APP_NAME' => 'yes',
            'APP_ENV' => 'yes',
            'APP_KEY' => 'yes',
            'APP_DEBUG' => 'yes',
            'APP_URL' => 'yes',
            //LOG
            'LOG_CHANNEL' => 'yes',
            'LOG_DEPRECATIONS_CHANNEL' => 'yes',
            'LOG_LEVEL' => 'yes',
            //DATABASE
            'DB_CONNECTION' => 'yes',
            'DB_HOST' => 'yes',
            'DB_PORT' => 'yes',
            'DB_DATABASE' => 'yes',
            'DB_USERNAME' => 'yes',
            'DB_PASSWORD' => 'yes',
            //DRIVERS
            'BROADCAST_DRIVER' => 'yes',
            'CACHE_DRIVER' => 'yes',
            'FILESYSTEM_DISK' => 'yes',
            'QUEUE_CONNECTION' => 'yes',
            'SESSION_DRIVER' => 'yes',
            'SESSION_LIFETIME' => 'yes',
            //MEMCACHED
            'MEMCACHED_HOST' => 'yes',
            //REDIS
            'REDIS_HOST' => 'yes',
            'REDIS_PASSWORD' => 'yes',
            'REDIS_PORT' => 'yes',
            //MAIL
            'MAIL_MAILER' => 'yes',
            'MAIL_HOST' => 'yes',
            'MAIL_PORT' => 'yes',
            'MAIL_USERNAME' => 'yes',
            'MAIL_PASSWORD' => 'yes',
            'MAIL_ENCRYPTION' => 'yes',
            'MAIL_FROM_ADDRESS' => 'yes',
            'MAIL_FROM_NAME' => 'yes',
            //AWS
            'AWS_ACCESS_KEY_ID' => 'yes',
            'AWS_SECRET_ACCESS_KEY' => 'yes',
            'AWS_DEFAULT_REGION' => 'yes',
            'AWS_BUCKET' => 'yes',
            'AWS_USE_PATH_STYLE_ENDPOINT' => 'yes',
            //PUSHER
            'PUSHER_APP_ID' => 'yes',
            'PUSHER_APP_KEY' => 'yes',
            'PUSHER_APP_SECRET' => 'yes',
            'PUSHER_HOST' => 'yes',
            'PUSHER_PORT' => 'yes',
            'PUSHER_SCHEME' => 'yes',
            'PUSHER_APP_CLUSTER' => 'yes',
            //VITE
            'VITE_PUSHER_APP_KEY' => 'yes',
            'VITE_PUSHER_HOST' => 'yes',
            'VITE_PUSHER_PORT' => 'yes',
            'VITE_PUSHER_SCHEME' => 'yes',
            'VITE_PUSHER_APP_CLUSTER' => 'yes',
        ],
    ],
];