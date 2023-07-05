<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Config\Validator\Items;

use GitBalocco\LaravelEnvDocumentator\Config\Validator\ValidatorInterface;
use JetBrains\PhpStorm\Pure;
use Respect\Validation\Validatable;
use Respect\Validation\Validator as v;

class PathsValidator extends BaseValidator implements ValidatorInterface
{
    #[Pure] public function __construct(private array $destinations, mixed $candidate = '')
    {
        parent::__construct($candidate);
    }

    public function definition(): Validatable
    {
        return v::optional(
            v::arrayVal()
                ->call('array_keys', v::each(v::stringType()->in($this->destinations)))
                ->each(
                    v::notEmpty()->stringType()
                )
        );
    }
}
