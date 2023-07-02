<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Presenter;

use GitBalocco\LaravelEnvDocumentator\Config\Config;
use GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations;
use GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\ValueFilterHandlerInterface;
use Illuminate\Console\OutputStyle;
use Symfony\Component\Console\Helper\Table;

class ArtisanConsoleDefaultPresenter extends AbstractPresenter implements PresenterInterface
{
    public function __construct(
        TableOfEnvItemsAndDestinations $tableOfEnvItemsAndDestinations,
        private Config $config,
        private ValueFilterHandlerInterface $valueFilterHandler,
        private OutputStyle $output
    ) {
        parent::__construct($tableOfEnvItemsAndDestinations);
    }


    public function __invoke()
    {
        $this->render(
            $this->createHeader(),
            $this->createRows()
        );
    }

    public function render(array $header, array $rows)
    {
        $table = new Table($this->output);
        $table->setHeaders($header)->setRows($rows)->setStyle('default');
        $table->render();
    }

    private function createHeader(): array
    {
        return array_merge(
            ['name'],
            $this->config->getAdditionalColumns(),
            $this->getTableOfEnvItemsAndDestinations()->getDestinations()
        );
    }

    /**
     * createRows
     * 表示データの作成
     * @return array
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    private function createRows(): array
    {
        $rows = [];

        //additional

        foreach ($this->getTableOfEnvItemsAndDestinations()->getEnvItemNames() as $itemName) {
            $additional = [];
            foreach ($this->config->getAdditionalColumns() as $columnName) {
                $additionalValue = $this->config->getAdditionalValue($columnName, $itemName);
                $additional[] = $additionalValue;
            }


            $values = $this->getTableOfEnvItemsAndDestinations()->table()->pluck($itemName)->toArray();
            foreach ($values as $key => $value) {
                $values[$key] = $this->valueFilterHandler->__invoke($itemName, $value);
            }
            $row = array_merge(
                [$itemName],
                $additional,
                $values
            );
            $rows[] = $row;
        }

        return $rows;
    }
}
