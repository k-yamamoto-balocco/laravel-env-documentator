<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit\Config\Validator\Items;

use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DestinationValidator;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DestinationValidator
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DefaultKeyValidator
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\BaseValidator
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\RespectValidatorExceptionHandler
 */
class DestinationValidatorTest extends TestCase
{
    static public function validateDataProvider(): array
    {
        return [
            [['dest100'], true],
            [['01' => 'dest200'], true],

            "要素は文字列でなければならない" => [[0, 1], false],
            "デプロイ先環境数は7まで" => [
                ['dest901', 'dest902', 'dest903', 'dest904', 'dest905', 'dest906', 'dest907', 'dest908'],
                false
            ],
            "要素数0はNG" => [[], false],
            "文字列はNG" => ['string', false],
            "数値0はNG" => [0, false],
            "数値1はNG" => [1, false],
            "nullはNG" => [null, false],
        ];
    }

    /**
     * @param mixed $candidate
     * @param bool $expectationResult
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     * @dataProvider validateDataProvider
     * @covers ::definition
     */
    public function test___invoke(mixed $candidate, bool $expectationResult)
    {
        $class = new DestinationValidator($candidate);
        $this->assertSame($expectationResult, $class->__invoke());
    }
}