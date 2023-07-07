<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit\Decryption;

use GitBalocco\LaravelEnvDocumentator\Decryption\Decrypter;
use Illuminate\Encryption\Encrypter;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Decryption\Decrypter
 * @uses \GitBalocco\LaravelEnvDocumentator\Decryption\Decrypter
 */
class DecrypterTest extends TestCase
{
    static public function dataProvider(): array
    {
        return [
            '引数がNULLの場合空配列' => [null, '', []],
            ['any-string', serialize('APP_NAME=test'), ['APP_NAME' => 'test']],
        ];
    }

    /**
     * test___invoke
     *
     * @param ?string $encryptedString
     * @param string $envContent
     * @param array $expectation
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     * @covers ::__invoke
     * @covers ::__construct
     * @dataProvider dataProvider
     */
    public function test___invoke(?string $encryptedString, string $envContent, array $expectation)
    {
        $mockEncrypter = \Mockery::mock(Encrypter::class);
        $mockEncrypter->shouldReceive('decryptString')
            ->with($encryptedString)
            ->once()
            ->andReturn($envContent);

        $object = new Decrypter($mockEncrypter);
        $actual = $object->__invoke($encryptedString);
        $this->assertSame($expectation, $actual);
    }
}