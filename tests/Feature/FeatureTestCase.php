<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Feature;

use GitBalocco\LaravelEnvDocumentator\ServiceProvider;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase;

abstract class FeatureTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }
}