<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator;

use GitBalocco\LaravelEnvDocumentator\Command\EnvDocumentatorCommand;
use Illuminate\Support\ServiceProvider as BaseProvider;

class ServiceProvider extends BaseProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../resources/env-documentator.php',
            'env-documentator'
        );
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands($this->commandsToRegister());
        }

        $this->publishes($this->itemsToPublish());

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'env-documentator');
    }

    private function commandsToRegister(): array
    {
        return [
            EnvDocumentatorCommand::class
        ];
    }

    private function itemsToPublish(): array
    {
        return [

        ];
    }
}
