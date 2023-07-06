<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Command;

use GitBalocco\LaravelEnvDocumentator\Command\CommandParameters\MetadataOption;
use GitBalocco\LaravelEnvDocumentator\Config\Config;
use GitBalocco\LaravelEnvDocumentator\Config\Validator\Handler as ValidatorHandler;
use GitBalocco\LaravelEnvDocumentator\Decryption\Handler;
use GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations;
use GitBalocco\LaravelEnvDocumentator\Path;
use GitBalocco\LaravelEnvDocumentator\Presenter\ArtisanConsoleDefaultConverter;
use GitBalocco\LaravelEnvDocumentator\Presenter\ArtisanConsoleDefaultPresenter;
use GitBalocco\LaravelEnvDocumentator\Presenter\PresenterInterface;
use GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\Handler as ValueFilterHandler;
use GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\NullFilter;
use GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\SecretFilter;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\Table;

class EnvDocumentatorCommand extends Command
{
    protected $signature = 'env:documentator {--m|metadata= : 追加表示するメタデータ項目。複数の場合,区切りで指定する}';
    protected $description = '暗号化された環境変数設定ファイルを復号し、整理して表示する';

    /**
     * @return int
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function handle()
    {
        $validatorHandler = new ValidatorHandler();
        if (false === $validatorHandler->__invoke()) {
            $this->error('Invalid configuration.Please modify config/env-documentator.php');
            foreach ($validatorHandler->getMessages() as $validatorClass => $details) {
                $this->line('invalid configuration in:"' . $validatorClass . '"');
                foreach ($details as $errorMessage) {
                    $this->warn($errorMessage);
                }
            }
            return Command::INVALID;
        }

        $config = new Config();
        $handler = new Handler($config);
        $result = $handler->__invoke();

        $this->decidePresenter($config, $result)->__invoke();

        return Command::SUCCESS;
    }

    private function decidePresenter(Config $config, TableOfEnvItemsAndDestinations $table): PresenterInterface
    {
        //暫定実装。他の形式での出力をサポートする場合に改修する。
        $metadataOption = new MetadataOption($this->option('metadata'), $config->getMetadataColumns());

        $valueFilterHandler = new ValueFilterHandler();
        $valueFilterHandler->register(new SecretFilter($config));
        $valueFilterHandler->register(new NullFilter());

        $converter = new ArtisanConsoleDefaultConverter(
            tableOfEnvItemsAndDestinations: $table,
            config: $config,
            valueFilterHandler: $valueFilterHandler,
            metadataOption: $metadataOption
        );

        return new ArtisanConsoleDefaultPresenter(
            converter: $converter,
            symfonyTableHelper: new Table($this->getOutput()),
        );
    }
}
