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
        $this->symfonyTableHelper->setHeaders($this->converter->convertToHeader());
        $this->symfonyTableHelper->setRows($this->converter->convertToRows());
        $this->symfonyTableHelper->setStyle('default');
        $this->symfonyTableHelper->render();
    }
}
