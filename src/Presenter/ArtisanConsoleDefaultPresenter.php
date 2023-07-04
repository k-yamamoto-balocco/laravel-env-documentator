<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Presenter;

use Illuminate\Console\OutputStyle;
use Symfony\Component\Console\Helper\Table;

class ArtisanConsoleDefaultPresenter extends AbstractPresenter implements PresenterInterface
{
    public function __construct(
        private ArtisanConsoleDefaultConverter $converter,
        private OutputStyle $output,
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
        $table = new Table($this->output);
        $table->setHeaders($header)->setRows($rows)->setStyle('default');
        $table->render();
    }
}
