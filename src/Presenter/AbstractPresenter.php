<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Presenter;

use GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations;

abstract class AbstractPresenter implements PresenterInterface
{

    public function __construct(private TableOfEnvItemsAndDestinations $tableOfEnvItemsAndDestinations)
    {
    }

    /**
     * @return TableOfEnvItemsAndDestinations
     */
    protected function getTableOfEnvItemsAndDestinations(): TableOfEnvItemsAndDestinations
    {
        return $this->tableOfEnvItemsAndDestinations;
    }

}
