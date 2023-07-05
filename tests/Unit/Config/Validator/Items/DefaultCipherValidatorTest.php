<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit\Config\Validator\Items;

use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\CipherValidator;
use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DefaultCipherValidator;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DefaultCipherValidator
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DefaultCipherValidator
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\CipherValidator
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\BaseValidator
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\RespectValidatorExceptionHandler
 */
class DefaultCipherValidatorTest extends TestCase
{
    static public function validateDataProvider(): array
    {
        return [
            ['aes-128-cbc', true],
            ['aes-256-cbc', true],
            ['aes-128-gcm', true],
            ['aes-256-gcm', true],
            [1, false],
            ['string', false],
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
     * @covers ::__construct
     */
    public function test___invoke(mixed $candidate, bool $expectationResult)
    {
        $class = new DefaultCipherValidator(new CipherValidator(), $candidate);
        $this->assertSame($expectationResult, $class->__invoke());
    }
}