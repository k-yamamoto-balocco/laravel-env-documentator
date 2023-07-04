<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Presenter;

use Symfony\Component\Console\Helper\Table;

class ArtisanConsoleDefaultPresenter implements PresenterInterface
{
    public function __construct(
        private ArtisanConsoleDefaultConverter $converter,
        private Table $symfonyTableHelper,
    ) {
    }

    public function __invoke()
    {
        $this->render(
            $this->converter->convertToHeader(),
            $this->converter->convertToRows()
        );
    }

    public function render(array $header, array $rows)
    {
        $this->symfonyTableHelper->setHeaders($header);
        $this->symfonyTableHelper->setRows($rows);
        $this->symfonyTableHelper->setStyle('default');
        $this->symfonyTableHelper->render();
    }
}
