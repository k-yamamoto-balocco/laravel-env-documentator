<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit\Presenter\ValueFilter;

use GitBalocco\LaravelEnvDocumentator\Config\Config;
use GitBalocco\LaravelEnvDocumentator\Exceptions\InvalidValueFilterCallException;
use GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\SecretFilter;
use GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\ValueFilterInterface;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\SecretFilter
 * @uses \GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter\SecretFilter
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Config
 */
class SecretFilterTest extends TestCase
{
    static public function invokeDataProvider(): array
    {
        return [
            "configで置換文字列が指定されていない場合デフォルトの置換文字列となる" => [
                'key101',
                'value101',
                ['key101' => null],
                SecretFilter::DEFAULT_REPLACEMENT,
            ],
            "configで置換文字列が指定されている場合、その値に置換される" => [
                'key102',
                'value102',
                ['key102' => 'RESULT_102'],
                'RESULT_102',
            ],
        ];
    }

    static public function validateDataProvider(): array
    {
        return [
            'valueがNULLの場合false' => [
                'key101',
                null,//filter対象のvalue がnull
                [],
                false
            ],
            'valueが空文字列の場合false' => [
                'key102',
                '',//filter対象のvalue がnull
                [],
                false
            ],
            'configのsecretsが空の場合、false' => [
                'key201',
                'value201',
                [],//configのsecretsが空のため、絶対に該当しない
                false
            ],
            'keyがconfig内にない' => [
                'key202',
                'value201',
                ['key202_is_not_exists_in_secrets' => null],//configにkey202が存在しないためfalse
                false
            ],
            'trueとなるパターン1' => [
                'key301',
                'value301',
                ['key301' => null],//key301がconfigのsecretsにあるためtrueとなる
                true,
            ],

        ];
    }

    /**
     * @covers ::__construct
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test___construct()
    {
        $mock = \Mockery::mock(Config::class);
        $instance = new SecretFilter($mock);
        $this->assertInstanceOf(ValueFilterInterface::class, $instance);

        \Closure::bind(
            function () use ($instance, $mock) {
                //assertions
                $this->assertSame($mock, $instance->config);
            },
            $this,
            $instance
        )->__invoke();
    }

    /**
     * @param string $argKey
     * @param mixed $argValue
     * @param array $secretsDefinedInConfig
     * @param bool $expectation
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     * @dataProvider validateDataProvider
     * @covers ::validate
     */
    public function test_validate(string $argKey, mixed $argValue, array $secretsDefinedInConfig, bool $expectation)
    {
        $mock = \Mockery::mock(Config::class);
        $mock->allows('getSecrets')->andReturn($secretsDefinedInConfig);
        $instance = new SecretFilter($mock);
        $actual = $instance->validate($argKey, $argValue);
        $this->assertSame($expectation, $actual);
    }

    /**
     * @param string $argKey
     * @param mixed $argValue
     * @param array $secretsDefinedInConfig
     * @param mixed $expectation
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     * @dataProvider invokeDataProvider
     * @covers ::__invoke
     */
    public function test___invoke(string $argKey, mixed $argValue, array $secretsDefinedInConfig, mixed $expectation)
    {
        $mock = \Mockery::mock(Config::class);
        $mock->allows('getSecrets')->andReturn($secretsDefinedInConfig);
        $instance = new SecretFilter($mock);
        $actual = $instance->__invoke($argKey, $argValue);
        $this->assertSame($expectation, $actual);
    }

    /**
     * @covers ::__invoke
     */
    public function test___invokeRaiseException()
    {
        $mock = \Mockery::mock(Config::class);
        $mock->allows('getSecrets')->andReturn([]);
        $instance = new SecretFilter($mock);
        $this->expectException(InvalidValueFilterCallException::class);
        $actual = $instance->__invoke('any-key', null);
    }
}