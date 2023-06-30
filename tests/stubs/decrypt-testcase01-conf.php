<?php

declare(strict_types=1);

return [
    //one-dimensional array of string.Each item must be deployment destination name.
    'destinations' => [
        'nice',
    ],
    //encrypted .env file paths of each destination.
    'paths' => [
        'nice' => 'tests/stubs/decrypt-testcase01-encrypted',
    ],
    'keys' => [
        'nice' => 'base64:XeBq7lovblPOI/7Xfnkhf0EnhFffSjNYNE37eLDI4cM=',
    ],
    'ciphers' => [
        'nice' => 'AES-256-CBC',
    ],
];