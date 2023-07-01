<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter;

interface ValueFilterInterface
{
    public function __invoke(string $key, mixed $value): mixed;

    public function validate(string $key, mixed $value): bool;
}