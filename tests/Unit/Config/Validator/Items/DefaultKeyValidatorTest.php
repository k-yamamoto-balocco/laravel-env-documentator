<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit\Config\Validator\Items;

use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DefaultKeyValidator;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DefaultKeyValidator
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DefaultKeyValidator
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\BaseValidator
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\RespectValidatorExceptionHandler
 */
class DefaultKeyValidatorTest extends TestCase
{
    static public function validateDataProvider(): array
    {
        return [
            [1, true],
            ['string', true],
            ['', false],
            [null, false],
            [0, false],
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
        $class = new DefaultKeyValidator($candidate);
        $this->assertSame($expectationResult, $class->__invoke());
    }
}