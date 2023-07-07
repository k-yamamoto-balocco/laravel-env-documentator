<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Presenter;

use GitBalocco\LaravelEnvDocumentator\Command\CommandParameters\MetadataOption;
use GitBalocco\LaravelEnvDocumentator\Config\Config;
use GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations;
use GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\ValueFilterHandlerInterface;
use JetBrains\PhpStorm\Pure;

class ArtisanConsoleDefaultConverter extends AbstractConverter
{
    #[Pure] public function __construct(
        TableOfEnvItemsAndDestinations $tableOfEnvItemsAndDestinations,
        Config $config,
        ValueFilterHandlerInterface $valueFilterHandler,
        private MetadataOption $metadataOption,
    ) {
        parent::__construct($tableOfEnvItemsAndDestinations, $config, $valueFilterHandler);
    }

    #[Pure] public function convertToHeader(): array
    {
        return array_merge(
            ['name'],
            $this->metadataOption->visibleMetadataColumns(),
            $this->getTableOfEnvItemsAndDestinations()->getDestinations()
        );
    }

    public function convertToRows(): array
    {
        $rows = [];

        foreach ($this->getTableOfEnvItemsAndDestinations()->getEnvItemNames() as $itemName) {
            $row = array_merge(
                [$itemName],
                $this->createMetadataValuesOfRow($itemName),
                $this->createValuesOfRow($itemName),
            );
            $rows[] = $row;
        }
        return $rows;
    }

    private function createMetadataValuesOfRow(string $itemName): array
    {
        $metadata = [];
        foreach ($this->metadataOption->visibleMetadataColumns() as $columnName) {
            $metadataValue = $this->getConfig()->getMetadataValue($columnName, $itemName);
            $metadata[] = $metadataValue;
        }
        return $metadata;
    }

    private function createValuesOfRow(string $itemName): array
    {
        $values = $this->getTableOfEnvItemsAndDestinations()->getTable()->pluck($itemName)->toArray();
        foreach ($values as $key => $value) {
            $values[$key] = $this->getValueFilterHandler()->__invoke($itemName, $value);
        }
        return $values;
    }
}
