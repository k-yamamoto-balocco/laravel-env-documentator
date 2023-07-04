<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter;

use GitBalocco\LaravelEnvDocumentator\Exceptions\InvalidValueFilterCallException;

class NullFilter implements ValueFilterInterface
{
    public function __invoke(string $key, mixed $value): mixed
    {
        if (!$this->validate($key, $value)) {
            throw new InvalidValueFilterCallException();
        }

        return "(NOT EXIST)";
    }

    public function validate(string $key, mixed $value): bool
    {
        return is_null($value);
    }
}
