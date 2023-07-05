<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Config\Validator\Items;

use GitBalocco\LaravelEnvDocumentator\Config\Validator\ValidatorInterface;
use Respect\Validation\Exceptions\ValidationException;

abstract class BaseValidator implements ValidatorInterface
{
    private ?RespectValidatorExceptionHandler $exceptionHandler;

    public function __construct(private mixed $candidate = '')
    {
        $this->exceptionHandler = null;
    }

    /**
     * @return ?RespectValidatorExceptionHandler
     */
    public function getExceptionHandler(): ?RespectValidatorExceptionHandler
    {
        return $this->exceptionHandler;
    }


    public function __invoke(mixed $candidate = null): bool
    {
        if (is_null($candidate)) {
            $candidate = $this->candidate;
        }

        try {
            $this->definition()->assert($candidate);
            return true;
        } catch (ValidationException $e) {
            $this->exceptionHandler = new RespectValidatorExceptionHandler($e);
        }
        return false;
    }

    protected function getCandidate(): mixed
    {
        return $this->candidate;
    }
}
