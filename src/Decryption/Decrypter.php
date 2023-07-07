<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Decryption;

use Dotenv\Dotenv;
use Illuminate\Encryption\Encrypter;

class Decrypter
{
    public function __construct(private Encrypter $encrypter)
    {
    }

    public function __invoke(?string $encryptedString): array
    {
        //ファイルが存在しない場合の分岐
        if (is_null($encryptedString)) {
            return [];
        }
        $decryptedString = $this->encrypter->decryptString($encryptedString);
        $string = unserialize($decryptedString);


        return Dotenv::parse($string);
    }
}
