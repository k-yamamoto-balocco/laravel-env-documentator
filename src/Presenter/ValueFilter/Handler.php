<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Presenter\ValueFilter;

use Illuminate\Support\Collection;

class Handler implements ValueFilterHandlerInterface
{
    private Collection $filters;

    public function __construct()
    {
        $this->filters = new Collection();
    }

    public function register(ValueFilterInterface $valueFilter): void
    {
        $this->filters->add($valueFilter);
    }

    public function __invoke(string $itemName, mixed $value): mixed
    {
        /** @var ValueFilterInterface $valueFilter */
        foreach ($this->filters as $valueFilter) {

            $result=$valueFilter->validate($itemName, $value);

            if ($result) {
                $value = $valueFilter->__invoke($itemName, $value);
            }
        }
        return $value;
    }
}
