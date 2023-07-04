<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit\Presenter;

use GitBalocco\LaravelEnvDocumentator\Command\CommandParameters\MetadataOption;
use GitBalocco\LaravelEnvDocumentator\Config\Config;
use GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations;
use GitBalocco\LaravelEnvDocumentator\Presenter\AbstractConverter;
use GitBalocco\LaravelEnvDocumentator\Presenter\ArtisanConsoleDefaultConverter;
use GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\ValueFilterHandlerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Presenter\ArtisanConsoleDefaultConverter
 * @uses \GitBalocco\LaravelEnvDocumentator\Presenter\ArtisanConsoleDefaultConverter
 * @uses \GitBalocco\LaravelEnvDocumentator\Presenter\AbstractConverter
 */
class ArtisanConsoleDefaultConverterTest extends TestCase
{
    static public function headerDataProvider(): array
    {
        return [
            "testcase101_固定値、meta、destの順に並ぶ" => [
                ['dest101'],
                ['meta101'],
                ['name', 'meta101', 'dest101']
            ],
            "testcase102_固定値、meta、destの順に並ぶ" => [
                ['dest102-1', 'dest102-2'],
                ['meta102'],
                ['name', 'meta102', 'dest102-1', 'dest102-2']
            ],
            "testcase200_destとmetaに同じ値が含まれている場合、それぞれが戻る" => [
                ['key201', 'key202'],
                ['key202', 'key203'],
                ['name', 'key202', 'key203', 'key201', 'key202']
            ],


        ];
    }
    /**
     * @covers ::__construct
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test___construct()
    {
        $mockTableOfEnvItemsAndDestinations = \Mockery::mock(TableOfEnvItemsAndDestinations::class);
        $mockConfig = \Mockery::mock(Config::class);
        $mockValueFilterHandlerInterface = \Mockery::mock(ValueFilterHandlerInterface::class);
        $mockMetadataOption = \Mockery::mock(MetadataOption::class);

        $object = new ArtisanConsoleDefaultConverter(
            $mockTableOfEnvItemsAndDestinations,
            $mockConfig,
            $mockValueFilterHandlerInterface,
            $mockMetadataOption
        );

        $this->assertInstanceOf(AbstractConverter::class, $object);
        \Closure::bind(
            function () use ($object, $mockMetadataOption) {
                //assertions
                $this->assertSame($mockMetadataOption, $object->metadataOption);
            },
            $this,
            $object
        )->__invoke();
    }

    /**
     * test_convertToHeader
     * @covers ::convertToHeader
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     * @dataProvider headerDataProvider
     */
    public function test_convertToHeader(array $destinations, array $metadata, array $expectation)
    {
        $mockTableOfEnvItemsAndDestinations = \Mockery::mock(TableOfEnvItemsAndDestinations::class);
        $mockTableOfEnvItemsAndDestinations->allows('getDestinations')->andReturn($destinations);

        $mockConfig = \Mockery::mock(Config::class);
        $mockValueFilterHandlerInterface = \Mockery::mock(ValueFilterHandlerInterface::class);
        $mockMetadataOption = \Mockery::mock(MetadataOption::class);
        $mockMetadataOption->allows('visibleMetadataColumns')->andReturn($metadata);

        $object = new ArtisanConsoleDefaultConverter(
            $mockTableOfEnvItemsAndDestinations,
            $mockConfig,
            $mockValueFilterHandlerInterface,
            $mockMetadataOption
        );

        $this->assertSame(
            $expectation,
            $object->convertToHeader()
        );
    }
}