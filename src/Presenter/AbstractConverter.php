<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Presenter;

use GitBalocco\LaravelEnvDocumentator\Config\Config;
use GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations;
use GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\ValueFilterHandlerInterface;

abstract class AbstractConverter implements PresenterInterface
{
    public function __construct(
        private TableOfEnvItemsAndDestinations $tableOfEnvItemsAndDestinations,
        private Config $config,
        private ValueFilterHandlerInterface $valueFilterHandler,
    ) {
    }

    /**
     * @return Config
     */
    protected function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * @return ValueFilterHandlerInterface
     */
    protected function getValueFilterHandler(): ValueFilterHandlerInterface
    {
        return $this->valueFilterHandler;
    }

    /**
     * @return TableOfEnvItemsAndDestinations
     */
    protected function getTableOfEnvItemsAndDestinations(): TableOfEnvItemsAndDestinations
    {
        return $this->tableOfEnvItemsAndDestinations;
    }


}
