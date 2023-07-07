<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Config;

use Generator;
use GitBalocco\LaravelEnvDocumentator\Decryption\Base64KeyParser;
use GitBalocco\LaravelEnvDocumentator\Exceptions\InvalidConfigurationException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config as ConfigFacade;
use IteratorAggregate;
use Traversable;

/**
 * Config
 *
 * @package GitBalocco\LaravelEnvDocumentator
 */
class Config implements IteratorAggregate
{
    private array $config;
    private Base64KeyParser $base64KeyParser;

    public function __construct()
    {
        $this->base64KeyParser = new Base64KeyParser();
        $this->config = ConfigFacade::get('env-documentator');
    }

    /**
     * getDestinations
     * @return string[]
     * @throws InvalidConfigurationException
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function getDestinations(): array
    {
        return $this->config['destinations'];
    }

    /**
     * @return string[]
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function getPaths(): array
    {
        return $this->config['paths'];
    }

    /**
     * getIterator
     *
     * @return Generator<Destination>|Destination[]
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function getIterator(): Traversable
    {
        foreach ($this->getDestinations() as $destinationName) {
            yield new Destination(
                $destinationName,
                $this->path($destinationName),
                $this->getKeyOfDestination($destinationName),
                $this->getCipherOfDestination($destinationName)
            );
        }
    }

    public function getSecrets(): array
    {
        return $this->config['filters']['secrets'] ?? [];
    }

    public function getMetadataColumns(): array
    {
        return $this->getMetadata()->keys()->toArray();
    }

    public function getMetadataValue(string $columnName, string $itemName): ?string
    {
        $metadata = $this->getMetadata();
        $value = data_get($metadata, implode('.', [$columnName, $itemName]));
        //値チェック

        return (string)$value;
    }

    public function getDefaultKey(): string
    {
        return $this->config['default_key'] ?? '';
    }

    public function getDefaultCipher(): string
    {
        return $this->config['default_cipher'] ?? '';
    }

    /**
     * @param string $destinationName
     * @return string
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    private function path(string $destinationName): string
    {
        return $this->getPaths()[$destinationName] ?? '.env.' . $destinationName . '.encrypted';
    }

    private function getKeyOfDestination(string $destinationName): string
    {
        $key = $this->config['keys'][$destinationName] ?? $this->getDefaultKey();
        return $this->parseKey($key);
    }

    private function getMetadata(): Collection
    {
        return new Collection($this->config['metadata'] ?? []);
    }

    /**
     * parseKey
     * @param $key
     * @return string
     * @see \Illuminate\Foundation\Console\EnvironmentDecryptCommand::parseKey
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    private function parseKey($key): string
    {
        return $this->base64KeyParser->__invoke($key);
    }

    private function getCipherOfDestination(string $destinationName): string
    {
        return strtolower($this->config['ciphers'][$destinationName] ?? $this->getDefaultCipher());
    }
}
