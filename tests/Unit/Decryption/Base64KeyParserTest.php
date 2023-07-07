<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit\Decryption;

use GitBalocco\LaravelEnvDocumentator\Decryption\Base64KeyParser;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Decryption\Base64KeyParser
 */
class Base64KeyParserTest extends TestCase
{
    static public function dataProvider(): array
    {
        return [
            ['', ''],
            ['hoge', 'hoge'],
            ['base64:' . base64_encode('hoge'), 'hoge'],
        ];
    }

    /**
     * test___invoke
     *
     * @param $string
     * @param string $expectation
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     * @dataProvider dataProvider
     * @covers ::__invoke
     */
    public function test___invoke($string, string $expectation)
    {
        $parser = new Base64KeyParser();
        $actual = $parser->__invoke($string);
        $this->assertSame($expectation, $actual);
    }
}