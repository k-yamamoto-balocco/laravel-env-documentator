<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Feature\Config;

use GitBalocco\LaravelEnvDocumentator\Config\Validator\Handler;
use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\CiphersValidator;
use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DefaultCipherValidator;
use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DefaultKeyValidator;
use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DestinationValidator;
use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\KeysValidator;
use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\PathsValidator;
use GitBalocco\LaravelEnvDocumentator\Test\BaseTestCase;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Config\Validator\Handler
 * @uses GitBalocco\LaravelEnvDocumentator\Config\Validator\Handler
 * @uses GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\BaseValidator
 * @uses GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\CiphersValidator
 * @uses GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DefaultCipherValidator
 * @uses GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DefaultKeyValidator
 * @uses GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\DestinationValidator
 * @uses GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\KeysValidator
 * @uses GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\PathsValidator
 * @uses GitBalocco\LaravelEnvDocumentator\ServiceProvider
 */
class ValidatorHandlerTest extends BaseTestCase
{
    /**
     * @covers ::__construct
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test___construct()
    {
        $handler = new Handler();

        \Closure::bind(
            function () use ($handler) {
                //assertions
                $tmpCollection = $handler->validators->filter(function ($item) {
                    return ($item instanceof DefaultKeyValidator);
                });
                $this->assertCount(1, $tmpCollection);

                $tmpCollection = $handler->validators->filter(function ($item) {
                    return ($item instanceof DefaultCipherValidator);
                });
                $this->assertCount(1, $tmpCollection);

                $tmpCollection = $handler->validators->filter(function ($item) {
                    return ($item instanceof DestinationValidator);
                });
                $this->assertCount(1, $tmpCollection);

                $tmpCollection = $handler->validators->filter(function ($item) {
                    return ($item instanceof PathsValidator);
                });
                $this->assertCount(1, $tmpCollection);

                $tmpCollection = $handler->validators->filter(function ($item) {
                    return ($item instanceof KeysValidator);
                });
                $this->assertCount(1, $tmpCollection);

                $tmpCollection = $handler->validators->filter(function ($item) {
                    return ($item instanceof CiphersValidator);
                });
                $this->assertCount(1, $tmpCollection);
            },
            $this,
            $handler
        )->__invoke();
    }

    /**
     * test___invokeWithDefaultConfigFailedWithDefaultKeyValidation
     * @covers ::__invoke
     * @covers ::getMessages
     * @uses GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\CipherValidator
     * @uses GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\RespectValidatorExceptionHandler
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test___invokeWithDefaultConfigFailedWithDefaultKeyValidation()
    {
        $handler = new Handler();
        $result = $handler->__invoke();

        $this->assertFalse($result);
        $this->arrayHasKey("default_key", $handler->getMessages());
    }
}

