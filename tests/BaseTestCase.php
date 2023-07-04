<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test;

use GitBalocco\LaravelEnvDocumentator\ServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class BaseTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }
}