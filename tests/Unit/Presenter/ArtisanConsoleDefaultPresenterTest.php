<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit\Presenter;

use GitBalocco\LaravelEnvDocumentator\Presenter\ArtisanConsoleDefaultConverter;
use GitBalocco\LaravelEnvDocumentator\Presenter\ArtisanConsoleDefaultPresenter;
use GitBalocco\LaravelEnvDocumentator\Presenter\PresenterInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Helper\Table;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Presenter\ArtisanConsoleDefaultPresenter
 * @uses \GitBalocco\LaravelEnvDocumentator\Presenter\ArtisanConsoleDefaultPresenter
 */
class ArtisanConsoleDefaultPresenterTest extends TestCase
{


    /**
     * @covers ::__construct
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test___construct()
    {
        $mockConverter = \Mockery::mock(ArtisanConsoleDefaultConverter::class);
        $mockTable = \Mockery::mock(Table::class);
        $object = new ArtisanConsoleDefaultPresenter($mockConverter, $mockTable);

        \Closure::bind(
            function () use ($object) {
                //assertions
                $this->assertInstanceOf(PresenterInterface::class, $object);
            },
            $this,
            $object
        )->__invoke();
    }

    /**
     * TODO:shouldReceiveがAssertionとして扱われない？
     * @covers ::__invoke
     */
    public function test___invoke()
    {
        $mockConverter = \Mockery::mock(ArtisanConsoleDefaultConverter::class);
        $mockConverter->shouldReceive('convertToHeader')->once()->andReturn([1]);
        $mockConverter->shouldReceive('convertToRows')->once()->andReturn([2]);

        $mockTable = \Mockery::mock(Table::class);
        $mockTable->shouldReceive('setHeaders')->with([1])->once();
        $mockTable->shouldReceive('setRows')->with([2])->once();
        $mockTable->shouldReceive('setStyle')->with('default')->once();
        $mockTable->shouldReceive('render')->once();

        $object = new ArtisanConsoleDefaultPresenter($mockConverter, $mockTable);
        $this->assertNull($object->__invoke());
    }
}