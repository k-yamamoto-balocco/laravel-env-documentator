<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Config\Validator\Items;

use GitBalocco\LaravelEnvDocumentator\Config\Validator\ValidatorInterface;
use Respect\Validation\Exceptions\ValidationException;

abstract class BaseValidator implements ValidatorInterface
{
    private ?ValidationException $validationException = null;

    public function __construct(private mixed $candidate)
    {
    }

    public function getMessage(): string
    {
        return $this->validationException?->getMessage() ?? '';
    }

    public function __invoke(): bool
    {
        try {
            $this->definition()->assert($this->candidate);
            return true;
        } catch (ValidationException $e) {
            $this->validationException = $e;
        }
        return false;
    }

    protected function getCandidate(): mixed
    {
        return $this->candidate;
    }

}