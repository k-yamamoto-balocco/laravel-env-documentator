<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit\Config\Validator\Items;

use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\KeysValidator;
use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\PathsValidator;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\KeysValidator
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\KeysValidator
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\BaseValidator
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\RespectValidatorExceptionHandler
 */
class KeysValidatorTest extends TestCase
{
    static public function validateDataProvider(): array
    {
        return [
            "任意項目のため、nullはOK" => [
                null,
                [],
                true
            ],
            "任意項目のため、空文字はOK" => [
                '',
                [],
                true
            ],
            "OK" => [
                ['dest101' => 'encrypted_file_path101'],
                ['dest101'],
                true
            ],
            "0はNG" => [
                0,
                [],
                false
            ],
            "文字列はNG" => [
                'string',
                [],
                false
            ],
            "destinationsに定義されていない項目はNG" => [
                ['key_not_in_dest' => 'encrypted_file_path1001'],
                ['dest1001'],
                false
            ],
            "destinationsに定義されていない項目だが、値がNULLはNG" => [
                ['dest1102' => null],
                ['dest1101', 'dest1102'],
                false
            ],
            "キーが数字の配列はNG" => [
                ['dest1102'],
                ['dest1201', 'dest1202'],
                false
            ],

        ];
    }

    /**
     * @param mixed $candidate
     * @param array $destinations
     * @param bool $expectationResult
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     * @dataProvider validateDataProvider
     * @covers ::definition
     * @covers ::__construct
     *
     */
    public function test___invoke(mixed $candidate, array $destinations, bool $expectationResult)
    {
        $class = new KeysValidator($destinations, $candidate);
        $this->assertSame($expectationResult, $class->__invoke());
    }
}