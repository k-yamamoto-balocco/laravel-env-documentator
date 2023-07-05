<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Config\Validator\Items;

use Respect\Validation\Exceptions\ValidationException;

class RespectValidatorExceptionHandler
{
    public function __construct(private ValidationException $validationException)
    {
    }

    public function getMessages(): array
    {
        $result = [];
        foreach ($this->validationException->getIterator() as $validatorException) {
            $result[] = $validatorException->getMessage();
        }
        return $result;
    }

    public function getExceptionClasses(): array
    {
        $result = [];
        foreach ($this->validationException->getIterator() as $item) {
            $result[] = get_class($item);
        }
        return $result;
    }
}
