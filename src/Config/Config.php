<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Config;

use Generator;
use GitBalocco\LaravelEnvDocumentator\Exceptions\ConfigurationNotFoundException;
use GitBalocco\LaravelEnvDocumentator\Exceptions\InvalidConfigurationException;
use GitBalocco\LaravelEnvDocumentator\Path;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
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

    /**
     * @param Path $path
     * @param array $applicationConfig
     * @throws ConfigurationNotFoundException
     */
    public function __construct(Path $path, array $applicationConfig)
    {
        $defaultConfigPath = $path->getDefaultConfig();
        if (!file_exists($defaultConfigPath)) {
            throw new ConfigurationNotFoundException();
        }
        $arrayDefaultConfig = require $defaultConfigPath;
        $this->config = array_merge($arrayDefaultConfig, $applicationConfig);
    }

    /**
     * getDestinations
     * TODO:Config Validatorによるvalidationに差し替える
     * @return string[]
     * @throws InvalidConfigurationException
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function getDestinations(): array
    {
        if (!array_key_exists('destinations', $this->config)) {
            throw new InvalidConfigurationException("'destinations' is required");
        }
        if (!is_array($this->config['destinations'])) {
            throw new InvalidConfigurationException('destinations must be array');
        }
        if (count($this->config['destinations']) === 0) {
            throw new InvalidConfigurationException('destinations should have string value');
        }
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
        //ここで統合して返却する感じ？
        foreach ($this->getDestinations() as $destinationName) {
            yield new Destination(
                $destinationName,
                $this->getPaths()[$destinationName],
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
     * @todo ConfigConvertorに移動する
     * @see \Illuminate\Foundation\Console\EnvironmentDecryptCommand::parseKey
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    private function parseKey($key): string
    {
        $prefix = 'base64:';
        if (Str::startsWith($key, $prefix)) {
            $key = base64_decode(Str::after($key, $prefix));
        }
        return $key;
    }

    private function getCipherOfDestination(string $destinationName): string
    {
        return strtolower($this->config['ciphers'][$destinationName] ?? $this->getDefaultCipher());
    }
}
