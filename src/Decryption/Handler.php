<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Decryption;

use GitBalocco\LaravelEnvDocumentator\Config\Config;
use GitBalocco\LaravelEnvDocumentator\Config\Destination;
use GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations;
use Illuminate\Encryption\Encrypter as LaravelEncrypter;

class Handler
{
    public function __construct(private Config $config)
    {
    }

    public function __invoke(): TableOfEnvItemsAndDestinations
    {
        $result = [];
        foreach ($this->config as $destination) {
            //各環境の情報を複合
            $decrypter = new Decrypter($this->createEncrypter($destination));
            $envFileContent = $this->readFile($destination->getEncryptedFilePath());
            $result[$destination->getName()] = $decrypter->__invoke($envFileContent);
        }
        return new TableOfEnvItemsAndDestinations($result);
    }

    private function createEncrypter(Destination $destination): LaravelEncrypter
    {
        if (is_null($destination->getCypher())) {
            return new LaravelEncrypter($destination->getEncryptionKey());
        }
        return new LaravelEncrypter($destination->getEncryptionKey(), $destination->getCypher());
    }

    private function readFile(string $path): ?string
    {
        if (!is_file($path)) {
            return null;
        }
        return file_get_contents($path);
    }
}
