<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit;

use GitBalocco\LaravelEnvDocumentator\Config;
use GitBalocco\LaravelEnvDocumentator\Exceptions\ConfigurationNotFoundException;
use GitBalocco\LaravelEnvDocumentator\Exceptions\InvalidConfigurationException;
use GitBalocco\LaravelEnvDocumentator\Path;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Config
 */
class ConfigTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function test___construct_DefaultConfigNotFound()
    {
        $pathMock = \Mockery::mock(Path::class);
        $pathMock->shouldReceive('getDefaultConfig')->once()->andReturn('hoge');
        $this->expectException(ConfigurationNotFoundException::class);
        new Config($pathMock, []);
    }

    /**
     * @covers ::__construct
     * @uses \GitBalocco\LaravelEnvDocumentator\Path
     */
    public function test___construct()
    {
        $path = new Path();
        $config = new Config($path, []);
        $this->assertInstanceOf(Config::class, $config);
    }

    /**
     * @covers ::getDestinations
     * @uses \GitBalocco\LaravelEnvDocumentator\Path
     * @uses \GitBalocco\LaravelEnvDocumentator\Config::__construct
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test_getDestinations_defaultValue()
    {
        $path = new Path();
        $config = new Config($path, []);
        $this->assertSame($config->getDestinations(), ['production', 'staging', 'develop', 'testing']);
    }

    /**
     * @covers ::getDestinations
     * @uses \GitBalocco\LaravelEnvDocumentator\Path
     * @uses \GitBalocco\LaravelEnvDocumentator\Config::__construct
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test_Destinations_appConfigOverwritesDefaultValue()
    {
        $path = new Path();
        $config = new Config($path, ['destinations' => ['hoge', 'piyo']]);
        $this->assertSame($config->getDestinations(), ['hoge', 'piyo']);
    }

    /**
     * @covers ::getDestinations
     * @uses \GitBalocco\LaravelEnvDocumentator\Path
     * @uses \GitBalocco\LaravelEnvDocumentator\Config::__construct
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test_Destinations_ShouldHaveValue()
    {
        $path = new Path();
        $config = new Config($path, ['destinations' => []]);
        $this->expectException(InvalidConfigurationException::class);
        $config->getDestinations();
    }

    /**
     * @covers ::getDestinations
     * @uses \GitBalocco\LaravelEnvDocumentator\Path
     * @uses \GitBalocco\LaravelEnvDocumentator\Config::__construct
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test_Destinations_ShouldBeArray()
    {
        $path = new Path();
        $config = new Config($path, ['destinations' => 'not array']);
        $this->expectException(InvalidConfigurationException::class);
        $config->getDestinations();
    }
}