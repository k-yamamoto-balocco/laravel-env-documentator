<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit\Presenter;

use GitBalocco\LaravelEnvDocumentator\Config\Config;
use GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations;
use GitBalocco\LaravelEnvDocumentator\Presenter\AbstractConverter;
use GitBalocco\LaravelEnvDocumentator\Presenter\PresenterInterface;
use GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\ValueFilterHandlerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Presenter\AbstractConverter
 * @uses \GitBalocco\LaravelEnvDocumentator\Presenter\AbstractConverter
 */
class AbstractConverterTest extends TestCase
{

    /**
     * test___construct
     * @covers ::__construct
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test___construct()
    {
        $tableMock = \Mockery::mock(TableOfEnvItemsAndDestinations::class);
        $configMock = \Mockery::mock(Config::class);
        $valueFilterMock = \Mockery::mock(ValueFilterHandlerInterface::class);
        $object = $this->createAnonymousConcreteClass($tableMock, $configMock, $valueFilterMock);
        $this->assertInstanceOf(PresenterInterface::class, $object);
    }

    public function createAnonymousConcreteClass(
        TableOfEnvItemsAndDestinations $table,
        Config $config,
        ValueFilterHandlerInterface $valueFilterHandler
    ): AbstractConverter {
        return new class($table, $config, $valueFilterHandler) extends AbstractConverter {

        };
    }

    /**
     * @covers ::getTableOfEnvItemsAndDestinations
     */
    public function test_getTableOfEnvItemsAndDestinations()
    {
        $tableMock = \Mockery::mock(TableOfEnvItemsAndDestinations::class);
        $configMock = \Mockery::mock(Config::class);
        $valueFilterMock = \Mockery::mock(ValueFilterHandlerInterface::class);
        $object = $this->createAnonymousConcreteClass($tableMock, $configMock, $valueFilterMock);

        \Closure::bind(
            function () use ($object, $tableMock) {
                //assertions
                $this->assertSame($tableMock, $object->getTableOfEnvItemsAndDestinations());
            },
            $this,
            $object
        )->__invoke();
    }

    /**
     * @covers ::getConfig
     */
    public function test_getConfig()
    {
        $tableMock = \Mockery::mock(TableOfEnvItemsAndDestinations::class);
        $configMock = \Mockery::mock(Config::class);
        $valueFilterMock = \Mockery::mock(ValueFilterHandlerInterface::class);
        $object = $this->createAnonymousConcreteClass($tableMock, $configMock, $valueFilterMock);

        \Closure::bind(
            function () use ($object, $configMock) {
                //assertions
                $this->assertSame($configMock, $object->getConfig());
            },
            $this,
            $object
        )->__invoke();
    }

    /**
     * @covers ::getValueFilterHandler
     */
    public function test_getValueFilterHandler()
    {
        $tableMock = \Mockery::mock(TableOfEnvItemsAndDestinations::class);
        $configMock = \Mockery::mock(Config::class);
        $valueFilterMock = \Mockery::mock(ValueFilterHandlerInterface::class);
        $object = $this->createAnonymousConcreteClass($tableMock, $configMock, $valueFilterMock);

        \Closure::bind(
            function () use ($object, $valueFilterMock) {
                //assertions
                $this->assertSame($valueFilterMock, $object->getValueFilterHandler());
            },
            $this,
            $object
        )->__invoke();
    }


}