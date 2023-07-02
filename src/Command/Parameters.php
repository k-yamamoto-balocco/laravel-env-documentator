<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Command;

use GitBalocco\LaravelEnvDocumentator\Config\Config;

class Parameters
{
    private ?string $additional = null;

    public function __construct(private Config $config, ?string $additional)
    {
        $this->additional = $additional;
    }

    public function getAdditional(): array
    {
        //指定なしの場合
        if (is_null($this->additional)) {
            return [];
        }
        if ($this->additional === 'all') {
            return $this->config->getAdditionalColumns();
        }
    }
}