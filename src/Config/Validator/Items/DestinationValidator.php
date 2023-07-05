<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Config\Validator\Items;

use GitBalocco\LaravelEnvDocumentator\Config\Validator\ValidatorInterface;
use Respect\Validation\Validatable;
use Respect\Validation\Validator as v;

class DestinationValidator extends BaseValidator implements ValidatorInterface
{
    public function definition(): Validatable
    {
        return v::notEmpty()
            ->arrayVal()
            ->call('count', v::lessThan(8))
            ->each(
                v::notEmpty()->stringType()
            );
    }
}
