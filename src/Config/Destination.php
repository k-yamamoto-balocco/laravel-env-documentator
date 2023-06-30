<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Config;

class Destination
{
    public function __construct(
        private string $name,
        private string $encryptedFilePath,
        private string $encryptionKey,
        private ?string $cypher
    ) {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEncryptedFilePath(): string
    {
        return $this->encryptedFilePath;
    }

    /**
     * @return string
     */
    public function getEncryptionKey(): string
    {
        return $this->encryptionKey;
    }

    /**
     * @return string|null
     */
    public function getCypher(): ?string
    {
        return $this->cypher;
    }
}