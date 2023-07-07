<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Decryption;

use Illuminate\Foundation\Console\EnvironmentDecryptCommand;
use Illuminate\Support\Str;

class Base64KeyParser
{
    /**
     * __invoke
     * @see EnvironmentDecryptCommand::parseKey()
     * @param string $key
     * @return string
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function __invoke(string $key): string
    {
        $prefix = 'base64:';
        if (Str::startsWith($key, $prefix)) {
            $key = base64_decode(Str::after($key, $prefix));
        }
        return $key;
    }
}
