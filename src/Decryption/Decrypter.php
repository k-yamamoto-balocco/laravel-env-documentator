<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Decryption;

use Illuminate\Encryption\Encrypter;

class Decrypter
{
    public function __construct(private Encrypter $encrypter)
    {
    }

    public function __invoke(string $encryptedString)
    {
        $decryptedString=$this->encrypter->decryptString($encryptedString);

        return unserialize($decryptedString);
    }
}