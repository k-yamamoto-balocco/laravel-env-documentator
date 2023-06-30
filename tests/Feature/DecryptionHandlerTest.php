<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Feature;

use GitBalocco\LaravelEnvDocumentator\Config\Config;
use GitBalocco\LaravelEnvDocumentator\Decryption\Handler;
use GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations;
use GitBalocco\LaravelEnvDocumentator\Path;

/**
 * @uses GitBalocco\LaravelEnvDocumentator\Entity\TableOfEnvItemsAndDestinations
 * @uses GitBalocco\LaravelEnvDocumentator\Config\Config
 * @uses GitBalocco\LaravelEnvDocumentator\Config\Destination
 * @uses GitBalocco\LaravelEnvDocumentator\Decryption\Decrypter
 * @uses GitBalocco\LaravelEnvDocumentator\Decryption\Handler
 * @uses GitBalocco\LaravelEnvDocumentator\Path
 * @uses GitBalocco\LaravelEnvDocumentator\ServiceProvider
 */
class DecryptionHandlerTest extends FeatureTestCase
{
    /**
     * test_正常系
     * @covers \GitBalocco\LaravelEnvDocumentator\Decryption\Handler
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test_正常系(){

        $testStubs = realpath(__DIR__ . '/../stubs/decrypt-testcase01-conf.php');
        $config = require $testStubs;
        $config = new Config(new Path(), $config);
        $handler = new Handler($config);
        $actual = $handler->__invoke();
        $this->assertInstanceOf(TableOfEnvItemsAndDestinations::class, $actual);

        $this->assertSame(['nice' => ['APP_URL' => 'test']], $actual->table());

    }
}