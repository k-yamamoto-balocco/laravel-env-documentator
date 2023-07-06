<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit;

use GitBalocco\LaravelEnvDocumentator\Config\Config;
use GitBalocco\LaravelEnvDocumentator\Path;
use GitBalocco\LaravelEnvDocumentator\Test\BaseTestCase;
use Illuminate\Support\Facades\Config as ConfigFacade;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Config\Config
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Config::__construct
 * @uses \GitBalocco\LaravelEnvDocumentator\ServiceProvider
 */
class ConfigTest extends BaseTestCase
{
    /**
     * @covers ::__construct
     */
    public function test___construct()
    {
        $config = new Config();
        $this->assertInstanceOf(Config::class, $config);
    }

    /**
     * @covers ::getDestinations
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test_getDestinations_defaultValue()
    {
        $config = new Config();
        $this->assertSame($config->getDestinations(), ['production', 'staging', 'develop', 'testing']);
    }

    /**
     * @covers ::getDestinations
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test_Destinations_appConfigOverwritesDefaultValue()
    {
        ConfigFacade::set('env-documentator.destinations', ['hoge', 'piyo']);
        $config = new Config();
        $this->assertSame($config->getDestinations(), ['hoge', 'piyo']);
    }

    /**
     * @covers ::getPaths
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test_getPaths_defaultValue()
    {
        $config = new Config();
        $this->assertSame([

        ], $config->getPaths());
    }
}