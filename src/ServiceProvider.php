<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator;

use Illuminate\Support\ServiceProvider as BaseProvider;

class ServiceProvider extends BaseProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands($this->commandsToRegister());
        }

        $this->publishes($this->itemsToPublish());
    }

    private function commandsToRegister(): array
    {
        return [
        ];
    }

    private function itemsToPublish(): array
    {

        return [

        ];
    }
}
