<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit\Config\Validator\Items;

use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\CipherValidator;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\CipherValidator
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\CipherValidator
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\BaseValidator
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\RespectValidatorExceptionHandler
 */
class CipherValidatorTest extends TestCase
{
    static public function validateDataProvider(): array
    {
        return [
            "許可されている値1" => ['aes-128-cbc', true],
            "許可されている値2" => ['aes-256-cbc', true],
            "許可されている値3" => ['aes-128-gcm', true],
            "許可されている値4" => ['aes-256-gcm', true],
            "大文字はNG" => ['AES-256-GCM', false],
            "空文字列はNG" => ['', false],
            "その他の文字列もNG" => ['test', false],
            "数値0はNG" => [0, false],
            "数値1はNG" => [1, false],
            "bool/trueはNG" => [true, false],
            "bool/falseはNG" => [false, false],
        ];
    }

    /**
     * test___invoke
     *
     * @param mixed $candidate
     * @param bool $expectationResult
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     * @covers ::definition
     * @covers ::__construct
     * @dataProvider validateDataProvider
     */
    public function test___invoke(mixed $candidate, bool $expectationResult)
    {
        $validator = new CipherValidator();
        $this->assertSame($expectationResult, $validator->__invoke($candidate));
    }
}