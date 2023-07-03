<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Command;

use GitBalocco\LaravelEnvDocumentator\Command\CommandParameters\MetadataOption;
use GitBalocco\LaravelEnvDocumentator\Config\Config;
use GitBalocco\LaravelEnvDocumentator\Decryption\Handler;
use GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations;
use GitBalocco\LaravelEnvDocumentator\Path;
use GitBalocco\LaravelEnvDocumentator\Presenter\ArtisanConsoleDefaultPresenter;
use GitBalocco\LaravelEnvDocumentator\Presenter\PresenterInterface;
use GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\Handler as ValueFilterHandler;
use GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\NullFilter;
use GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\SecretFilter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config as ConfigFacade;

class EnvDocumentatorCommand extends Command
{
    protected $signature = 'env:documentator {--m|metadata=}';
    protected $description = '';

    /**
     * handle
     * 暫定実装
     * @return int
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function handle()
    {
        $config = new Config();
        $handler = new Handler($config);
        $result = $handler->__invoke();

        $this->decidePresenter($config, $result)->__invoke();

        return Command::SUCCESS;
    }

    private function decidePresenter(Config $config, TableOfEnvItemsAndDestinations $table): PresenterInterface
    {
        $metadataOption = new MetadataOption($this->option('metadata'), $config->getMetadataColumns());

        $valueFilterHandler = new ValueFilterHandler();
        $valueFilterHandler->register(new SecretFilter($config));
        $valueFilterHandler->register(new NullFilter());
        return new ArtisanConsoleDefaultPresenter(
            $table,
            $config,
            $valueFilterHandler,
            $this->getOutput(),
            $metadataOption
        );
    }
}
