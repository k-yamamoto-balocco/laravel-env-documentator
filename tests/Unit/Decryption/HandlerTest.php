<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit\Decryption;

use GitBalocco\LaravelEnvDocumentator\Config;
use GitBalocco\LaravelEnvDocumentator\Decryption\Handler;
use GitBalocco\LaravelEnvDocumentator\Path;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Decryption\Handler
 */
class HandlerTest extends TestCase
{
    /**
     * @covers ::__invoke
     * @uses GitBalocco\LaravelEnvDocumentator\Config
     * @uses GitBalocco\LaravelEnvDocumentator\Config\Destination
     * @uses GitBalocco\LaravelEnvDocumentator\Decryption\Decrypter
     * @uses GitBalocco\LaravelEnvDocumentator\Decryption\Handler
     * @uses GitBalocco\LaravelEnvDocumentator\Path
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test___invoke()
    {
        $testStubs = realpath(__DIR__ . '/../../stubs/decrypt-testcase01-conf.php');
        $config = require $testStubs;
        $config = new Config(new Path(), $config);
        $handler = new Handler($config);
        $result = $handler->__invoke();
        $this->assertSame('APP_URL=test', trim($result));
    }
}