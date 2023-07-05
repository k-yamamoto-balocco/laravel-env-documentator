<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit\Config\Validator\Items;

use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DefaultKeyValidator;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DefaultKeyValidator
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DefaultKeyValidator
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\BaseValidator
 */
class DefaultKeyValidatorTest extends TestCase
{
    static public function validateDataProvider(): array
    {
        return [
            [1, true, ''],
            ['string', true, ''],
            ['', false, 'All of the required rules must pass for ""'],
            [null, false, 'All of the required rules must pass for `NULL`'],
            [0, false, 'All of the required rules must pass for 0'],
        ];
    }

    /**
     * test___invoke
     *
     * @param mixed $candidate
     * @param bool $expectationResult
     * @param string $expectationMessage
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     * @dataProvider validateDataProvider
     * @covers ::definition
     */
    public function test___invoke(mixed $candidate, bool $expectationResult, string $expectationMessage)
    {
        $class = new DefaultKeyValidator($candidate);
        $this->assertSame($expectationResult, $class->__invoke());
        $this->assertSame($expectationMessage, $class->getMessage());
    }
}