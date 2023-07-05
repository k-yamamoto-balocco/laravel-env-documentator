<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Config\Validator\Items;

use GitBalocco\LaravelEnvDocumentator\Config\Validator\ValidatorInterface;
use Respect\Validation\Validatable;
use Respect\Validation\Validator as v;

class DefaultKeyValidator extends BaseValidator implements ValidatorInterface
{
    public function definition(): Validatable
    {
        return v::notEmpty();
    }
}
