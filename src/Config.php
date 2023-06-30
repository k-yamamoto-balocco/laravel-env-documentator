<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator;

use GitBalocco\LaravelEnvDocumentator\Exceptions\ConfigurationNotFoundException;
use GitBalocco\LaravelEnvDocumentator\Exceptions\InvalidConfigurationException;

/**
 * Config
 *
 * @package GitBalocco\LaravelEnvDocumentator
 */
class Config
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
}
