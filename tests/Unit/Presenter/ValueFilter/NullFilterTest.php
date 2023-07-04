<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit\Presenter\ValueFilter;

use GitBalocco\LaravelEnvDocumentator\Exceptions\InvalidValueFilterCallException;
use GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\NullFilter;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\NullFilter
 * @uses \GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\NullFilter
 * @uses \GitBalocco\LaravelEnvDocumentator\Exceptions\InvalidValueFilterCallException
 */
class NullFilterTest extends TestCase
{
    static public function dataProvider(): array
    {
        return [
            ['', false],
            ['some string', false],
            [[], false],
            [0, false],
            [1, false],
            [null, true],
        ];
    }

    /**
     * test_invoke
     * @covers ::__invoke
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test_invoke()
    {
        $object = new NullFilter();
        $this->assertSame('(NOT EXIST)', $object->__invoke('anyKey', null));
    }

    /**
     * test_validate
     * このテストはネイティブ関数のis_nullを検査しているのと同義・・・意味が無い
     * @param $argValue
     * @param $expectation
     * @covers ::validate
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     * @dataProvider dataProvider
     */
    public function test_validate($argValue, $expectation)
    {
        $object = new NullFilter();
        $this->assertSame($expectation, $object->validate('', $argValue));
    }

    /**
     * @covers ::__invoke
     */
    public function test___invokeRaiseException()
    {
        $object = new NullFilter();
        $this->expectException(InvalidValueFilterCallException::class);
        $object->__invoke('any-key', 'not null value');
    }
}