<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Decryption;

use GitBalocco\LaravelEnvDocumentator\Config\Config;
use GitBalocco\LaravelEnvDocumentator\Config\Destination;
use GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations;
use Illuminate\Encryption\Encrypter as LaravelEncrypter;
use Illuminate\Support\Collection;
use RuntimeException;

class Handler
{
    private Collection $messages;

    public function __construct(
        private Config $config,
    ) {
        $this->messages = new Collection();
    }

    public function __invoke(): TableOfEnvItemsAndDestinations
    {
        $result = [];
        foreach ($this->config as $destination) {
            try {
                //各環境の情報を複合
                $decrypter = new Decrypter($this->createEncrypter($destination));
                $envFileContent = $this->readFile($destination->getEncryptedFilePath());
                $result[$destination->getName()] = $decrypter->__invoke($envFileContent);
            } catch (RuntimeException $e) {
                $this->messages->put($destination->getName(), $e->getMessage());
            }
        }
        return new TableOfEnvItemsAndDestinations($result);
    }

    public function getMessages(): Collection
    {
        return $this->messages;
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
