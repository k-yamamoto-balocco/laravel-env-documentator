<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter;

use GitBalocco\LaravelEnvDocumentator\Config\Config;

class SecretFilter implements ValueFilterInterface
{
    public const DEFAULT_REPLACEMENT = '********';

    public function __construct(private Config $config)
    {
    }

    public function __invoke(string $key, mixed $value): mixed
    {
        $secrets = $this->config->getSecrets();

        if ($secrets[$key]) {
            return $secrets[$key];
        }
        //default
        return self::DEFAULT_REPLACEMENT;
    }

    public function validate(string $key, mixed $value): bool
    {
        if (is_null($value)) {
            return false;
        }
        if ($value === '') {
            return false;
        }
        $secrets = $this->config->getSecrets();
        return array_key_exists($key, $secrets);
    }
}