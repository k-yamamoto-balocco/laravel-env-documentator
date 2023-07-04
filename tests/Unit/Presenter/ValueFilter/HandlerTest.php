<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit\Presenter\ValueFilter;

use GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\Handler;
use GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\ValueFilterHandlerInterface;
use GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\ValueFilterInterface;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

/**
 * ValueFilter 適用のロジック部分のテスト
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\Handler
 * @uses \GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\Handler
 */
class HandlerTest extends TestCase
{
    static public function dataProviderInvoke(): array
    {
        return [
            "validateOKの場合フィルタが適用される" => [
                true,
                'filtered-value01',
                'item01',
                'arg-value01',
                'filtered-value01'
            ],
            "validateNGの場合フィルタが適用されない" => [
                false,
                'filtered-value02',
                'item02',
                'arg-value02',
                'arg-value02'
            ],
        ];
    }

    /**
     * test___construct
     * @covers ::__construct
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test___construct()
    {
        $handler = new Handler();
        $this->assertInstanceOf(ValueFilterHandlerInterface::class, $handler);

        \Closure::bind(
            function () use ($handler) {
                //assertions
                $this->assertInstanceOf(Collection::class, $handler->filters);
            },
            $this,
            $handler
        )->__invoke();
    }

    /**
     * @covers ::register
     */
    public function test_register()
    {
        $handler = new Handler();
        $mock = \Mockery::mock(ValueFilterInterface::class);
        $handler->register($mock);

        \Closure::bind(
            function () use ($handler, $mock) {
                //assertions
                $this->assertSame($mock, $handler->filters->first());
            },
            $this,
            $handler
        )->__invoke();
    }

    /**
     *
     * @param bool $validateMethodWillReturn
     * @param mixed $invokeMethodWillReturn
     * @param string $argItemName
     * @param mixed $argValue
     * @param mixed $expectation
     * @covers ::__invoke()
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     * @dataProvider dataProviderInvoke
     */
    public function test___invoke(
        bool $validateMethodWillReturn,
        mixed $invokeMethodWillReturn,
        string $argItemName,
        mixed $argValue,
        mixed $expectation
    ) {
        $handler = new Handler();

        $mock = \Mockery::mock(ValueFilterInterface::class);

        $mock->shouldReceive('validate')->andReturn($validateMethodWillReturn);

        if ($validateMethodWillReturn) {
            $mock->shouldReceive('__invoke')->andReturn($invokeMethodWillReturn);
        } else {
            $mock->shouldNotReceive('__invoke');
        }

        $handler->register($mock);

        /** execution */
        $actual = $handler->__invoke($argItemName, $argValue);

        /** assertions */
        $this->assertSame($expectation, $actual);
    }
}