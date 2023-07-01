<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Presenter;

use GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations;
use GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\ValueFilterHandlerInterface;
use Illuminate\Console\OutputStyle;
use Symfony\Component\Console\Helper\Table;

class ArtisanConsoleDefaultPresenter extends AbstractPresenter implements PresenterInterface
{
    public function __construct(
        TableOfEnvItemsAndDestinations $tableOfEnvItemsAndDestinations,
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
        $table->setHeaders((array)$header)->setRows($rows)->setStyle('default');
        $table->render();
    }

    private function createHeader(): array
    {
        return array_merge(['name'], $this->getTableOfEnvItemsAndDestinations()->getDestinations());
    }

    private function createRows(): array
    {
        $rows = [];
        foreach ($this->getTableOfEnvItemsAndDestinations()->getEnvItemNames() as $itemName) {
            $values = $this->getTableOfEnvItemsAndDestinations()->table()->pluck($itemName)->toArray();
            foreach ($values as $key => $value) {
                $values[$key] = $this->valueFilterHandler->__invoke($itemName, $value);
            }


            $row = array_merge(
                [$itemName],
                $values
            );
            $rows[] = $row;
        }

        return $rows;
    }
}
