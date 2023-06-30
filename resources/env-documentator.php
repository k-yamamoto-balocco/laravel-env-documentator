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
    ]
];