<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter;

interface ValueFilterHandlerInterface
{
    public function register(ValueFilterInterface $valueFilter): void;

    public function __invoke(string $itemName, mixed $value): mixed;
}