<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter;

class NullFilter implements ValueFilterInterface
{
    public function __invoke(string $key, mixed $value): mixed
    {
        return "(NOT EXIST)";
    }

    public function validate(string $key, mixed $value): bool
    {
        return is_null($value);
    }
}
