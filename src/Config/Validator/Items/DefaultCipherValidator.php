<?php

declare(strict_types=1);

namespace GitBalocco\LaravelEnvDocumentator\Config\Validator\Items;

use GitBalocco\LaravelEnvDocumentator\Config\Validator\ValidatorInterface;
use Respect\Validation\Validatable;
use Respect\Validation\Validator as v;

class DefaultCipherValidator extends BaseValidator implements ValidatorInterface
{
    public function __construct(private CipherValidator $cipherValidator, mixed $candidate = '')
    {
        parent::__construct($candidate);
    }

    public function definition(): Validatable
    {
        return new v(v::notEmpty(), $this->cipherValidator->definition());
    }

}