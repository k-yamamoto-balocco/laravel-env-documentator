<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Decryption;

use Illuminate\Support\Str;

class Base64KeyParser
{
    public function __invoke(string $key): string
    {
        $prefix = 'base64:';
        if (Str::startsWith($key, $prefix)) {
            $key = base64_decode(Str::after($key, $prefix));
        }
        return $key;
    }
}
