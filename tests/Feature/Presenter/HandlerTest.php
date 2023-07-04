<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Feature\Presenter;

use GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\Handler;
use GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\NullFilter;
use GitBalocco\LaravelEnvDocumentator\Test\BaseTestCase;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\Handler
 * @uses \GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\NullFilter
 */
class HandlerTest extends BaseTestCase
{

    static public function dataProvider_nullFilter(): array
    {
        return [
            "'aaa'はnullでないためvalidateを通らない。フィルタも適用されない" => ['なんでもよい', 'aaa', 'aaa'],
            "空文字列はnullでないためvalidateを通らない。フィルタも適用されない" => ['なんでもよい', '', ''],
            "nullのためvalidateを通り、変換される。" => ['なんでもよい', null, '(NOT EXIST)'],
            "空配列はnullでないため、validateを通らない。フィルタも適用されない。" => ['なんでもよい', [], []],
            "0はnullでないため、validateを通らない。フィルタも適用されない。" => ['なんでもよい', 0, 0],
        ];
    }

    /**
     * @dataProvider dataProvider_nullFilter
     * @coversNothing
     */
    public function test_onlyNullFilter($argItemName, $argValue, $expected)
    {
        $valueFilterHandler = new Handler();
        $valueFilterHandler->register(new NullFilter());
        $actual = $valueFilterHandler->__invoke($argItemName, $argValue);
        $this->assertSame($expected, $actual);
    }
}