<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Test\Unit\Config\Validator\Items;

use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\BaseValidator;
use GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\RespectValidatorExceptionHandler;
use PHPUnit\Framework\TestCase;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validatable;
use Respect\Validation\Validator as v;

/**
 * @coversDefaultClass \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\BaseValidator
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\BaseValidator
 * @uses \GitBalocco\LaravelEnvDocumentator\Config\Validator\Items\RespectValidatorExceptionHandler
 */
class BaseValidatorTest extends TestCase
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
     * @covers ::__construct
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test___construct()
    {
        $candidate = 'hoge';
        $object = $this->createObject($candidate);

        \Closure::bind(
            function () use ($object, $candidate) {
                //assertions
                $this->assertSame($candidate, $object->candidate);
                $this->assertSame(null, $object->exceptionHandler);
            },
            $this,
            BaseValidator::class
        )->__invoke();
    }

    /**
     * @covers ::__invoke
     */
    public function test___invoke_validateSucceeded()
    {
        $candidate = 'candidate';
        $mock = \Mockery::mock(BaseValidator::class)->makePartial();
        $mock->shouldReceive('definition->assert')->with($candidate);;
        $this->assertTrue($mock->__invoke($candidate));
    }

    /**
     * @covers ::__invoke
     */
    public function test___invoke_validateFailed()
    {
        $candidate = 'candidate';
        $mock = \Mockery::mock(BaseValidator::class)->makePartial();
        $mock->shouldReceive('definition->assert')
            ->with($candidate)
            ->andThrow(
                \Mockery::mock(ValidationException::class)
            );
        $this->assertFalse($mock->__invoke($candidate));
    }

    /**
     * @covers ::__invoke
     * @covers ::getExceptionHandler
     * @author kenji yamamoto <k.yamamoto@balocco.info>
     */
    public function test___invoke_withConstructorCandidate()
    {
        $candidate = 'candidate';
        $object = $this->createObject($candidate);
        $result = $object->__invoke();
        $this->assertFalse($result);
        $this->assertInstanceOf(RespectValidatorExceptionHandler::class, $object->getExceptionHandler());
    }


    public function createObject(mixed $candidate): BaseValidator
    {
        return new class($candidate) extends BaseValidator {
            public function definition(): Validatable
            {
                return v::alwaysInvalid();
            }
        };
    }
}